<?php

declare(strict_types=1);

namespace App\Emails\Infrastructure\Repository;

use App\Emails\Domain\Entity\EmailStatus;
use App\Emails\Domain\Repository\EmailStatusRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EmailStatusRepository extends ServiceEntityRepository implements EmailStatusRepositoryInterface
{
    private $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailStatus::class);
        $this->em = $this->getEntityManager();
    }

    public function create(EmailStatus $emailStatus): void
    {
        $this->em->persist($emailStatus);
        $this->em->flush();
    }

    public function delete(EmailStatus $emailStatus): void
    {
        $this->em->remove($emailStatus);
        $this->em->flush();
    }

    public function findByCodename(string $codename): ?EmailStatus
    {
        return $this->findOneBy(['codename' => $codename]);
    }

    public function findById(int $id): ?EmailStatus
    {
        return $this->find($id);
    }

    public function isExists(EmailStatus $emailStatus): bool
    {
        return (bool)$this->findByCodename($emailStatus->getCodename());
    }
}
