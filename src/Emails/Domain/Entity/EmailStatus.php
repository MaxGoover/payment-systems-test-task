<?php

declare(strict_types=1);

namespace App\Emails\Domain\Entity;

class EmailStatus
{
    private int $id;
    private string $name;
    private string $codename;

    public function __construct(
        string $name,
        string $codename,
    ) {
        $this->name = $name;
        $this->codename = $codename;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCodename(): string
    {
        return $this->codename;
    }
}
