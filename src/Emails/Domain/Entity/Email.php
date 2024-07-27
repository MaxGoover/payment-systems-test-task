<?php

declare(strict_types=1);

namespace App\Emails\Domain\Entity;

use App\Shared\Domain\Service\UidService;

class Email
{
    private string $ulid;
    private int $emailStatusId;
    private string $address;
    private string $theme;
    private string $content;
    private string $created_at;
    private ?string $updated_at;

    public function __construct(
        string $address,
        string $theme,
        string $content,
        int $emailStatusId
    ) {
        $this->ulid = UidService::generateUlid();
        $this->address = $address;
        $this->theme = $theme;
        $this->content = $content;
        $this->emailStatusId = $emailStatusId;
    }

    public function getUlid(): string
    {
        return $this->ulid;
    }

    public function getEmailStatusId(): int
    {
        return $this->emailStatusId;
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
}
