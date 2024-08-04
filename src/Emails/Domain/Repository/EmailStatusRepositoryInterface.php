<?php

declare(strict_types=1);

namespace App\Emails\Domain\Repository;

use App\Emails\Domain\Entity\EmailStatus;

interface EmailStatusRepositoryInterface
{
    public function findByCodename(string $codename): ?EmailStatus;
    
    public function findById(int $id): ?EmailStatus;
    
    public function isExists(EmailStatus $emailStatus): bool;
    
    public function store(EmailStatus $emailStatus): void;
}
