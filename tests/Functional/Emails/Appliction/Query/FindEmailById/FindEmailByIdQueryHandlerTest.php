<?php

namespace Tests\Functional\Emails\Application\Query\FindEmailById;

use App\Emails\Application\DTO\EmailDTO;
use App\Emails\Application\Query\FindEmailById\FindEmailByIdQuery;
use App\Emails\Domain\Repository\EmailRepositoryInterface;
use App\Emails\Domain\Repository\EmailStatusRepositoryInterface;
use App\Shared\Application\Query\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\Fixture\Emails\EmailFixture;

class FindEmailByIdQueryHandlerTest extends WebTestCase
{
    private QueryBusInterface $queryBus;
    private EmailFixture $emailFixture;
    private EmailRepositoryInterface $emails;

    public function setUp(): void
    {
        parent::setUp();
        $this->queryBus = static::getContainer()->get(QueryBusInterface::class);
        $this->emails = static::getContainer()->get(EmailRepositoryInterface::class);
        $emailStatuses = static::getContainer()->get(EmailStatusRepositoryInterface::class);
        $this->emailFixture = new EmailFixture($this->emails, $emailStatuses);
    }

    public function testFindEmailByIdSuccess(): void
    {
        $email = $this->emailFixture->create();
        $query = new FindEmailByIdQuery($email->getId());
        $emailDTO = $this->queryBus->execute($query);

        $this->assertInstanceOf(EmailDTO::class, $emailDTO);
        $this->assertEquals($emailDTO->id, $email->getId());
    }

    // public function testFindEmailByIdFailed(): void
    // {
    //     $email = $this->emailFixture->create();
    //     $query = new FindEmailByIdQuery($email->getId());
    //     $emailDTO = $this->queryBus->execute($query);

    //     $this->assertInstanceOf(EmailDTO::class, $emailDTO);
    //     $this->assertEquals($emailDTO->id, $email->getId());
    // }
}
