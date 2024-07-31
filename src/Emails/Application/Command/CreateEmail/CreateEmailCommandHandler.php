<?php

declare(strict_types=1);

namespace App\Emails\Application\Command\CreateEmail;

use App\Emails\Domain\Entity\EmailStatus;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Emails\Domain\Factory\EmailFactory;
use App\Emails\Domain\Repository\EmailRepositoryInterface;
use App\Emails\Domain\Repository\EmailStatusRepositoryInterface;

class CreateEmailCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly EmailRepositoryInterface $emails,
        private readonly EmailStatusRepositoryInterface $emailStatuses,
    ) {
    }

    public function __invoke(CreateEmailCommand $createEmailCommand): string
    {
        $emailStatusNew = $this->emailStatuses->findByCodename(EmailStatus::NEW);
        $user = EmailFactory::create(
            $createEmailCommand->address,
            $createEmailCommand->theme,
            $createEmailCommand->content,
            $emailStatusNew,
        );

        $this->emails->create($user);

        return $user->getId();
    }
}
