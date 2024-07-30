<?php

declare(strict_types=1);

namespace Tests\Functional\Emails\Infrastructure\Repository;

use App\Emails\Domain\Entity\EmailStatus;
use App\Emails\Infrastructure\Repository\EmailStatusRepository;
use Tests\Fixture\Emails\EmailStatusFixture;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmailStatusRepositoryTest extends WebTestCase
{
    private EmailStatus $emailStatus;
    private EmailStatusFixture $emailStatusFixture;
    private EmailStatusRepository $emailStatuses;

    public function setUp(): void
    {
        parent::setUp();
        $this->emailStatuses = static::getContainer()->get(EmailStatusRepository::class);
        $this->emailStatusFixture = new EmailStatusFixture($this->emailStatuses);
        $this->testCreateSuccess();
    }

    public function tearDown(): void
    {
        $this->testDeleteSuccess();
    }

    public function testFindByCodenameSuccess()
    {
        $codename = $this->emailStatus->getCodename();
        $this->emailStatus = $this->emailStatuses->findByCodename($codename);
        $this->assertEquals($this->emailStatus->getCodename(), $codename);
    }

    public function testFindByIdSuccess()
    {
        $id = $this->emailStatus->getId();
        $this->emailStatus = $this->emailStatuses->findById($id);
        $this->assertEquals($this->emailStatus->getId(), $id);
    }

    public function testIsExistsSuccess()
    {
        $isExists = $this->emailStatuses->isExists($this->emailStatus);
        $this->assertTrue($isExists);
    }

    private function testCreateSuccess(): void
    {
        $this->emailStatus = $this->emailStatusFixture->create();
        $isExists = $this->emailStatuses->isExists($this->emailStatus);
        $this->assertTrue($isExists);
    }

    private function testDeleteSuccess(): void
    {
        $this->emailStatuses->delete($this->emailStatus);
        $isExists = $this->emailStatuses->isExists($this->emailStatus);
        $this->assertFalse($isExists);
    }
}
