<?php

declare(strict_types=1);

namespace App\Shared\Application\Service;

interface UidServiceInterface
{
    public static function generateUuid(): string;
}
