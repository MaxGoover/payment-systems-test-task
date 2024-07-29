<?php

declare(strict_types=1);

namespace App\Tests\Functional\Emails\Infrastructure\Repository;

use App\Emails\Domain\Entity\Email;
use App\Emails\Domain\Entity\EmailStatus;
use App\Emails\Domain\Factory\EmailFactory;
use App\Emails\Domain\Factory\EmailStatusFactory;
use App\Emails\Infrastructure\Repository\EmailRepository;
use App\Emails\Infrastructure\Repository\EmailStatusRepository;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmailRepositoryTest extends WebTestCase
{
    private ?Email $createdEmail;
    private ?EmailStatus $createdEmailStatus;
    private EmailRepository $emails;
    private EmailStatusRepository $emailStatuses;
    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->emails = static::getContainer()->get(EmailRepository::class);
        $this->emailStatuses = static::getContainer()->get(EmailStatusRepository::class);
        $this->faker = Factory::create();

        $this->createEmailStatusNew();
    }
    
    public function tearDown(): void
    {
        $this->deleteEmailStatus();
    }
    
    public function testCreateSuccess(): void
    {
        $this->createEmail();
        $this->deleteEmail();
    }

    private function createEmail()
    {
        $address = $this->faker->email();
        $theme = $this->faker->realText(50);
        $content = $this->faker->realText(100);

        $email = EmailFactory::create($address, $theme, $content, $this->createdEmailStatus);
        $this->emails->create($email);

        $this->createdEmail = $this->emails->findById($email->getId());
        $this->assertNotNull($this->createdEmail);
        $this->assertEquals($email->getId(), $this->createdEmail->getId());
    }

    private function createEmailStatusNew()
    {
        $emailStatus = EmailStatusFactory::create(EmailStatus::NEW);
        $this->emailStatuses->create($emailStatus);

        $this->createdEmailStatus = $this->emailStatuses->findByCodename(EmailStatus::NEW);
        $this->assertNotNull($this->createdEmailStatus);
    }

    private function deleteEmail()
    {
        $createdEmailId = $this->createdEmail->getId();
        $this->emails->delete($this->createdEmail);
        $this->createdEmail = $this->emails->findById($createdEmailId);
        $this->assertNull($this->createdEmail);
    }

    private function deleteEmailStatus()
    {
        $createdEmailStatusId = $this->createdEmailStatus->getId();
        $this->emailStatuses->delete($this->createdEmailStatus);
        $this->createdEmailStatus = $this->emailStatuses->findById($createdEmailStatusId);
        $this->assertNull($this->createdEmailStatus);
    }
}
