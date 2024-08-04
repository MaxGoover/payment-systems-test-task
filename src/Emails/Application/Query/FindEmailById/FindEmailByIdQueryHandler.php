<?php

declare(strict_types=1);

namespace App\Emails\Application\Query\FindEmailById;

use App\Emails\Application\DTO\EmailDTO;
use App\Emails\Domain\Repository\EmailRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

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
        return new EmailDTO(
            id: $email->getId(),
            emailStatus: $email->getEmailStatus(),
            address: $email->getAddress(),
            theme: $email->getTheme(),
            content: $email->getContent(),
            createdAt: $email->getCreatedAt(),
        );
    }
}
