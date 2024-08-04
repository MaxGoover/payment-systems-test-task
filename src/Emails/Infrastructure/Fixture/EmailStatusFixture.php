<?php

declare(strict_types=1);

namespace App\Emails\Infrastructure\Fixture;

use App\Emails\Domain\Entity\EmailStatus;
use App\Emails\Domain\Factory\EmailStatusFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EmailStatusFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach (EmailStatus::LIST_ALL as $codename) {
            $emailStatus = EmailStatusFactory::create($codename);
            $manager->persist($emailStatus);
        }

        $manager->flush();
    }
}
