<?php

declare(strict_types=1);

namespace App\Emails\Domain\Factory;

use App\Emails\Domain\Entity\EmailStatus;

class EmailStatusFactory
{
    public static function create(string $codename): EmailStatus
    {
        return new EmailStatus($codename);
    }
}
