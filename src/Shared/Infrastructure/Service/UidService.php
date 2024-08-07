<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Service;

use App\Shared\Application\Service\UidServiceInterface;
use Symfony\Component\Uid\Uuid;

class UidService implements UidServiceInterface
{
    public static function generateUuid(): string
    {
        return Uuid::v4()->toString();
    }
}
