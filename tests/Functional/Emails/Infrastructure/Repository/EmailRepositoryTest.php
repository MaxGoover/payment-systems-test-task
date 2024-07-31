<?php

declare(strict_types=1);

namespace Tests\Functional\Emails\Infrastructure\Repository;

use App\Emails\Domain\Entity\Email;
use App\Emails\Domain\Repository\EmailRepositoryInterface;
use App\Emails\Domain\Repository\EmailStatusRepositoryInterface;
use Tests\Fixture\Emails\EmailFixture;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmailRepositoryTest extends WebTestCase
{
    private ?Email $email;
    private EmailFixture $emailFixture;
    private EmailRepositoryInterface $emails;

    public function setUp(): void
    {
        parent::setUp();
        $this->emails = static::getContainer()->get(EmailRepositoryInterface::class);
        $emailStatuses = static::getContainer()->get(EmailStatusRepositoryInterface::class);
        $this->emailFixture = new EmailFixture($this->emails, $emailStatuses);
        $this->testCreateSuccess();
    }

    public function testCreateSuccess(): void
    {
        $this->email = $this->emailFixture->create();
        $this->email = $this->emails->findById($this->email->getId());
        $this->assertNotNull($this->email);
    }

    public function testDeleteSuccess(): void
    {
        $id = $this->email->getId();
        $this->emails->delete($this->email);

        $this->email = $this->emails->findById($id);
        $this->assertNull($this->email);
    }

    public function testFindByIdSuccess()
    {
        $id = $this->email->getId();
        $this->email = $this->emails->findById($id);
        $this->assertEquals($this->email->getId(), $id);
    }
}
