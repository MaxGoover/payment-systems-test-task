<?php

declare(strict_types=1);

namespace App\Tests\Functional\Emails\Infrastructure\Repository;

use App\Emails\Domain\Entity\EmailStatus;
use App\Emails\Domain\Factory\EmailStatusFactory;
use App\Emails\Infrastructure\Repository\EmailStatusRepository;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmailStatusRepositoryTest extends WebTestCase
{
    private ?EmailStatus $createdEmailStatus;
    private EmailStatusRepository $emailStatuses;
    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->emailStatuses = static::getContainer()->get(EmailStatusRepository::class);
        $this->faker = Factory::create();
    }

    public function testCreateSuccess(): void
    {
        $this->createEmailStatus();
        $this->deleteEmailStatus();
    }

    private function createEmailStatus()
    {
        $codename = $this->faker->randomElement(EmailStatus::LIST_CODENAMES);
        $this->assertIsString($codename);

        $emailStatus = EmailStatusFactory::create($codename, $codename);
        $this->emailStatuses->create($emailStatus);

        $this->createdEmailStatus = $this->emailStatuses->findById($emailStatus->getId());
        $this->assertNotNull($this->createdEmailStatus);
        $this->assertEquals($emailStatus->getCodename(), $this->createdEmailStatus->getCodename());
    }

    private function deleteEmailStatus()
    {
        $createdEmailStatusId = $this->createdEmailStatus->getId();
        $this->emailStatuses->delete($this->createdEmailStatus);
        $this->createdEmailStatus = $this->emailStatuses->findById($createdEmailStatusId);
        $this->assertNull($this->createdEmailStatus);
    }
}
