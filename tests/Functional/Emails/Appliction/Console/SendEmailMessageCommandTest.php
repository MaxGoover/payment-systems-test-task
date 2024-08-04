<?php

namespace Tests\Functional\Emails\Application\Console;

use App\Emails\Application\Console\SendEmailMessageCommand;
use App\Emails\Domain\Entity\EmailStatus;
use App\Emails\Domain\Repository\EmailRepositoryInterface;
use App\Emails\Domain\Repository\EmailStatusRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Messenger\MessageBusInterface;
use Tests\Fixture\Emails\EmailFixture;

class SendEmailMessageCommandTest extends KernelTestCase
{
    private EmailFixture $emailFixture;
    private EmailRepositoryInterface $emails;
    private EmailStatusRepositoryInterface $emailStatuses;
    private MessageBusInterface $messageBus;

    public function setUp(): void
    {
        parent::setUp();
        $this->messageBus = static::getContainer()->get(MessageBusInterface::class);
        $this->emails = static::getContainer()->get(EmailRepositoryInterface::class);
        $this->emailStatuses = static::getContainer()->get(EmailStatusRepositoryInterface::class);
        $this->emailFixture = new EmailFixture($this->emails, $this->emailStatuses);
    }

    public function testExecuteSuccess()
    {
        $emailsList = [];
        for ($i = 0; $i < 3; $i++) {
            $emailsList[] = $this->emailFixture->create();
        }
        $this->emails->storeDistribution($emailsList);

        $command = new SendEmailMessageCommand(
            $this->emails,
            $this->emailStatuses,
            $this->messageBus,
        );
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString(
            EmailStatus::IN_QUEUE,
            $output,
        );
        $this->assertEquals(0, $commandTester->getStatusCode());
    }
}
