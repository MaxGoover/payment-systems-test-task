<?php

declare(strict_types=1);

namespace App\Emails\Infrastructure\Repository;

use App\Emails\Domain\Entity\Email;
use App\Emails\Domain\Repository\EmailRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EmailRepository extends ServiceEntityRepository implements EmailRepositoryInterface
{
    private $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Email::class);
        $this->em = $this->getEntityManager();
    }

    public function create(Email $email): void
    {
        $this->em->persist($email);
        $this->em->flush();
    }

    /**
     * @param Email[] $emails
     */
    public function createDistribution(array $emails): void
    {
        foreach ($emails as $email) {
            $isExistsEmail = $this->isExistsByParams([
                'address' => $email->getAddress(),
                'theme' => $email->getTheme()
            ]);

            if (!$isExistsEmail) {
                $this->em->persist($email);
            }
        }
        $this->em->flush();
    }

    public function findById(string $id): ?Email
    {
        return $this->find($id);
    }

    public function isExistsByParams(array $params): bool
    {
        return (bool)$this->findOneBy($params);
    }
}
