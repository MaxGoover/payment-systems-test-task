<?php

declare(strict_types=1);

namespace App\Emails\Domain\Repository;

use App\Emails\Domain\Entity\Email;

interface EmailRepositoryInterface
{
    public function findByEmailStatusId(int $id): array;

    public function findById(string $id): ?Email;

    public function isExistsByParams(array $params): bool;

    public function store(Email $email): void;
    
    public function storeDistribution(array $emails): void;
}
