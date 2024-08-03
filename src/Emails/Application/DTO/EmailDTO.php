<?php

declare(strict_types=1);

namespace App\Emails\Application\DTO;

use App\Emails\Domain\Entity\Email;
use App\Emails\Domain\Entity\EmailStatus;
use DateTime;
use ReflectionClass;

class EmailDTO
{
    public function __construct(
        public readonly ?string $id,
        public readonly ?EmailStatus $emailStatus,
        public readonly ?string $address,
        public readonly ?string $theme,
        public readonly ?string $content,
        public readonly ?DateTime $createdAt,
    ) {
    }

    public function getStatusCodename(): string
    {
        return $this->emailStatus->getCodename();
    }
}
