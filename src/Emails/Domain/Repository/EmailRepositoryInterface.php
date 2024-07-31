<?php

declare(strict_types=1);

namespace App\Emails\Domain\Repository;

use App\Emails\Domain\Entity\Email;

interface EmailRepositoryInterface
{
    public function create(Email $email): void;

    public function delete(Email $email): void;

    public function findById(string $id): ?Email;
}
