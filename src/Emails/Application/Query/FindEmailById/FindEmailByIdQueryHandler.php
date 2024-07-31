<?php

declare(strict_types=1);

namespace App\Emails\Application\Query\FindEmailById;

use App\Shared\Application\Query\QueryHandlerInterface;
use App\Emails\Application\DTO\EmailDTO;
use App\Emails\Domain\Repository\EmailRepositoryInterface;

class FindEmailByIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly EmailRepositoryInterface $emails)
    {
    }

    public function __invoke(FindEmailByIdQuery $query): ?EmailDTO
    {
        $email = $this->emails->findById($query->id);

        if (is_null($email)) {
            return null;
        }

        return EmailDTO::fromEntity($email);
    }
}