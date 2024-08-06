<?php

declare(strict_types=1);

namespace App\Shared\Domain\Service;

interface UidServiceInterface
{
    public static function generateUlid(): string;
}
