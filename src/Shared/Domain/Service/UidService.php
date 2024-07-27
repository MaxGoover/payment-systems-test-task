<?php

declare(strict_types=1);

namespace App\Shared\Domain\Service;

use Symfony\Component\Uid\Ulid;

class UidService
{
    public static function generateUlid(): string
    {
        return Ulid::generate();
    }
}
