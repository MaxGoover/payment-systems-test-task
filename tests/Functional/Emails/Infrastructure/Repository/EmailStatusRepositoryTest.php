<?php

declare(strict_types=1);

namespace Tests\Functional\Emails\Infrastructure\Repository;

use App\Emails\Domain\Entity\EmailStatus;
use App\Emails\Domain\Repository\EmailStatusRepositoryInterface;
use Tests\Fixture\Emails\EmailStatusFixture;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmailStatusRepositoryTest extends WebTestCase
{
    private EmailStatus $emailStatus;
    private EmailStatusFixture $emailStatusFixture;
    private EmailStatusRepositoryInterface $emailStatuses;

    public function setUp(): void
    {
        parent::setUp();
        $this->emailStatuses = static::getContainer()->get(EmailStatusRepositoryInterface::class);
        $this->emailStatusFixture = new EmailStatusFixture($this->emailStatuses);
        $this->testStoreSuccess();
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

    public function testStoreSuccess(): void
    {
        $this->emailStatus = $this->emailStatusFixture->create();
        $isExists = $this->emailStatuses->isExists($this->emailStatus);
        $this->assertTrue($isExists);
    }
}
