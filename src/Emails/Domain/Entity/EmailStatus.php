<?php

declare(strict_types=1);

namespace App\Emails\Domain\Entity;

class EmailStatus
{
    const NEW = 'new';
    const IN_QUEUE = 'in_queue';
    const SENT = 'sent';
    const BUS_ERROR = 'bus_error';
    const SENDING_ERROR = 'sending_error';

    const LIST_ALL = [
        self::NEW,
        self::IN_QUEUE,
        self::SENT,
        self::BUS_ERROR,
        self::SENDING_ERROR,
    ];

    private int $id;
    private string $codename;

    public function __construct(string $codename)
    {
        $this->codename = $codename;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCodename(): string
    {
        return $this->codename;
    }
}
