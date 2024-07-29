<?php

declare(strict_types=1);

namespace App\Emails\Domain\Factory;

use App\Emails\Domain\Entity\Email;
use App\Emails\Domain\Entity\EmailStatus;
use DateTimeImmutable;

class EmailFactory
{
    public static function create(
        string $address,
        string $theme,
        string $content,
        EmailStatus $emailStatus,
    ): Email {
        return new Email($address, $theme, $content, $emailStatus, new DateTimeImmutable());
    }
}
