<?php

namespace Tests\Functional\Emails\Application\Command\CreateEmailDistribution;

use App\Emails\Application\Command\CreateEmailDistribution\CreateEmailDistributionCommand;
use App\Emails\Domain\Repository\EmailRepositoryInterface;
use App\Emails\Domain\Repository\EmailStatusRepositoryInterface;
use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\Fixture\Emails\EmailFixture;

class CreateEmailDistributionCommandHandlerTest extends WebTestCase
{
    private CommandBusInterface $commandBus;
    private EmailFixture $emailFixture;
    private EmailRepositoryInterface $emails;
    private array $addressesList;

    public function setUp(): void
    {
        parent::setUp();
        $this->commandBus = static::getContainer()->get(CommandBusInterface::class);
        $this->emails = static::getContainer()->get(EmailRepositoryInterface::class);
        $emailStatuses = static::getContainer()->get(EmailStatusRepositoryInterface::class);
        $this->emailFixture = new EmailFixture($this->emails, $emailStatuses);
    }

    public function testStoreEmailSuccess(): void
    {
        $email = $this->emailFixture->create();
        $this->fillAddressesList();

        $command = new CreateEmailDistributionCommand($this->addressesList, $email->getTheme(), $email->getContent());
        $emailIdsList = $this->commandBus->execute($command);
        $this->assertEquals(count($this->addressesList), count($emailIdsList));

        foreach ($emailIdsList as $emailId) {
            $this->assertIsString($emailId);
        }
    }

    private function fillAddressesList()
    {
        for ($i = 0; $i < 3; $i++) {
            $this->addressesList[] = $this->emailFixture->fakeAddress();
        }
    }
}