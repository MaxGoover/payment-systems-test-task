<?php

declare(strict_types=1);

namespace App\Emails\Application\Message;

class EmailMessage
{
    public function __construct(
        public readonly string $id,
    ) {
    }
}
