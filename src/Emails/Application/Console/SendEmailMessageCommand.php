<?php

declare(strict_types=1);

namespace App\Emails\Application\Console;

use App\Emails\Application\Message\EmailMessage;
use App\Emails\Domain\Entity\EmailStatus;
use App\Emails\Domain\Repository\EmailRepositoryInterface;
use App\Emails\Domain\Repository\EmailStatusRepositoryInterface;
use DateTime;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'rabbitmq:send-email-message',
    description: 'Send email into rabbitmq',
)]
class SendEmailMessageCommand extends Command
{
    public function __construct(
        private readonly EmailRepositoryInterface $emails,
        private readonly EmailStatusRepositoryInterface $emailStatuses,
        private readonly MessageBusInterface $messageBus,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $emailStatusNew = $this->emailStatuses->findByCodename(EmailStatus::NEW);
        $emailStatus = $this->emailStatuses->findByCodename(EmailStatus::IN_QUEUE);
        $emailsNew = $this->emails->findByEmailStatusId($emailStatusNew->getId());

        foreach ($emailsNew as $emailNew) {
            try {
                $this->messageBus->dispatch(new EmailMessage($emailNew->getId()));
            } catch (ExceptionInterface) {
                $emailStatus = $this->emailStatuses->findByCodename(EmailStatus::BUS_ERROR);
            }

            $emailNew->setEmailStatus($emailStatus);
            $emailNew->setUpdatedAt(new DateTime());
            $this->emails->store($emailNew);
            $output->writeln('EmailId = ' . $emailNew->getId() . '; EmailStatus = ' . $emailStatus->getCodename());
        }

        return Command::SUCCESS;
    }
}
