<?php

declare(strict_types=1);

namespace App\Emails\Domain\Repository;

use App\Emails\Domain\Entity\EmailStatus;

interface EmailStatusRepositoryInterface
{
    public function create(EmailStatus $emailStatus): void;

    public function findByCodename(string $codename): ?EmailStatus;

    public function findById(int $id): ?EmailStatus;

    public function isExists(EmailStatus $emailStatus): bool;
}
