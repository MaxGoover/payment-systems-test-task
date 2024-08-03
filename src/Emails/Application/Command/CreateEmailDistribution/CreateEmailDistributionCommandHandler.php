<?php

declare(strict_types=1);

namespace App\Emails\Application\Command\CreateEmailDistribution;

use App\Emails\Domain\Entity\EmailStatus;
use App\Emails\Domain\Factory\EmailFactory;
use App\Emails\Domain\Repository\EmailRepositoryInterface;
use App\Emails\Domain\Repository\EmailStatusRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

class CreateEmailDistributionCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly EmailRepositoryInterface $emails,
        private readonly EmailStatusRepositoryInterface $emailStatuses,
        private array $emailsList = [],
    ) {
    }

    public function __invoke(CreateEmailDistributionCommand $createEmailDistribution): int
    {
        $this->fillEmailsList($createEmailDistribution);
        $this->emails->createDistribution($this->emailsList);

        return count($this->emailsList);
    }

    private function fillEmailsList(CreateEmailDistributionCommand $createEmailDistribution): void
    {
        $emailStatusNew = $this->emailStatuses->findByCodename(EmailStatus::NEW);

        foreach ($createEmailDistribution->addresses as $address) {
            $this->emailsList[] = EmailFactory::create(
                $address,
                $createEmailDistribution->theme,
                $createEmailDistribution->content,
                $emailStatusNew,
            );
        }
    }
}
