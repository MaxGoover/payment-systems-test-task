<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Service;

use App\Shared\Application\Service\UidServiceInterface;
use Symfony\Component\Uid\Ulid;

class UidService implements UidServiceInterface
{
    public static function generateUlid(): string
    {
        return Ulid::generate();
    }
}
