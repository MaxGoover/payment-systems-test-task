<?php

declare(strict_types=1);

namespace App\Emails\Application\MessageHandler;

use App\Emails\Application\Message\EmailMessage;
use App\Emails\Domain\Entity\EmailStatus;
use App\Emails\Domain\Repository\EmailRepositoryInterface;
use App\Emails\Domain\Repository\EmailStatusRepositoryInterface;
use DateTime;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;

#[AsMessageHandler]
class EmailMessageHandler
{
    public function __construct(
        private readonly EmailRepositoryInterface $emails,
        private readonly EmailStatusRepositoryInterface $emailStatuses,
        private readonly MailerInterface $mailer,
    ) {
    }

    public function __invoke(EmailMessage $emailMessage)
    {
        $email = $this->emails->findById($emailMessage->id);
        $emailStatus = $this->emailStatuses->findByCodename(EmailStatus::SENT);

        if (!$email->isEmailStatusInQueue()) {
            return 'Неподходящий статус для отправки: emailId = ' . $email->getId();
        }

        $emailToSend = (new Email())
            ->from('maxgoover@gmail.com')
            ->to($email->getAddress())
            ->subject($email->getTheme())
            ->text($email->getContent())
            ->html('<h1>The email was sent!</h1>');

        try {
            $this->mailer->send($emailToSend);
        } catch (\Throwable) {
            $emailStatus = $this->emailStatuses->findByCodename(EmailStatus::SENDING_ERROR);
        }

        $email->setEmailStatus($emailStatus);
        $email->setUpdatedAt(new DateTime());
        $this->emails->store($email);
    }
}
