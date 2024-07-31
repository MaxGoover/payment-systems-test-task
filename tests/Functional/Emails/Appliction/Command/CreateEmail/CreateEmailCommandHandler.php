<?php

namespace Tests\Functional\Emails\Application\Command\CreateEmail;

use App\Emails\Application\Command\CreateEmail\CreateEmailCommand;
use App\Emails\Domain\Repository\EmailRepositoryInterface;
use App\Emails\Domain\Repository\EmailStatusRepositoryInterface;
use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\Fixture\Emails\EmailFixture;

class CreateEmailCommandHandlerTest extends WebTestCase
{
    private CommandBusInterface $commandBus;
    private EmailFixture $emailFixture;
    private EmailRepositoryInterface $emails;

    public function setUp(): void
    {
        parent::setUp();
        $this->commandBus = $this::getContainer()->get(CommandBusInterface::class);
        $this->emails = static::getContainer()->get(EmailRepositoryInterface::class);
        $emailStatuses = static::getContainer()->get(EmailStatusRepositoryInterface::class);
        $this->emailFixture = new EmailFixture($this->emails, $emailStatuses);
    }

    public function testCreateEmailSuccess(): void
    {
        $email = $this->emailFixture->create();

        $command = new CreateEmailCommand($email->getAddress(), $email->getTheme(), $email->getContent());
        $emailId = $this->commandBus->execute($command);

        $email = $this->emails->findById($emailId);
        $this->assertIsString($email);
    }
}