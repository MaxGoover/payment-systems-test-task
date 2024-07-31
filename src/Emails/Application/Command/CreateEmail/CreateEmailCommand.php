<?php

declare(strict_types=1);

namespace App\Emails\Application\Command\CreateEmail;

use App\Shared\Application\Command\CommandInterface;

class CreateEmailCommand implements CommandInterface
{
    public function __construct(
        public readonly string $address,
        public readonly string $theme,
        public readonly string $content,
    ) {
    }
}
