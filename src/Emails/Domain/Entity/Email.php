<?php

declare(strict_types=1);

namespace App\Emails\Domain\Entity;

use App\Shared\Domain\Service\UidService;
use DateTime;

class Email
{
    private string $id;
    private EmailStatus $emailStatus;
    private string $address;
    private string $theme;
    private string $content;
    private DateTime $createdAt;
    private ?DateTime $updatedAt = null;

    public function __construct(
        string $address,
        string $theme,
        string $content,
        EmailStatus $emailStatus,
        DateTime $createdAt,
    ) {
        $this->id = UidService::generateUlid();
        $this->address = $address;
        $this->theme = $theme;
        $this->content = $content;
        $this->emailStatus = $emailStatus;
        $this->createdAt = $createdAt;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmailStatus(): EmailStatus
    {
        return $this->emailStatus;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getTheme(): string
    {
        return $this->theme;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
}
