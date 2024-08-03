<?php

declare(strict_types=1);

namespace App\Emails\Application\Command\CreateEmailDistribution;

use App\Shared\Application\Command\CommandInterface;

class CreateEmailDistributionCommand implements CommandInterface
{
    public function __construct(
        public readonly array $addresses,
        public readonly string $theme,
        public readonly string $content,
    ) {
    }
}
