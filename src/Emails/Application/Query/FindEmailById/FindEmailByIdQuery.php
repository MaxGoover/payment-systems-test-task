<?php

declare(strict_types=1);

namespace App\Emails\Application\Query\FindEmailById;

use App\Shared\Application\Query\QueryInterface;

class FindEmailByIdQuery implements QueryInterface
{
    public function __construct(public readonly string $id)
    {
    }
}
