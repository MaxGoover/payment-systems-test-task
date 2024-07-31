<?php

declare(strict_types=1);

namespace App\Emails\Application\DTO;

use App\Emails\Domain\Entity\Email;

class EmailDTO
{
    public static function fromEntity(Email $email): self
    {
        return new self(
            $email->getId(),
            $email->getEmailStatus(),
            $email->getAddress(),
            $email->getTheme(),
            $email->getContent(),
            $email->getCreatedAt(),
        );
    }
}
