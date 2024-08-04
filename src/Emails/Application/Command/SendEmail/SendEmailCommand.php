<?php

declare(strict_types=1);

namespace App\Emails\Application\Command\SendEmail;

use App\Shared\Application\Command\CommandInterface;

class SendEmailCommand implements CommandInterface
{
    public function __construct(
        public readonly string $id,
    ) {
    }
}
