<?php

declare(strict_types=1);

namespace Tests\Functional\Emails\Infrastructure\Controller;

use App\Emails\Application\Command\CreateEmailDistribution\CreateEmailDistributionCommand;
use App\Emails\Domain\Repository\EmailRepositoryInterface;
use App\Emails\Domain\Repository\EmailStatusRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Tests\Fixture\Emails\EmailFixture;

class SendActionTest extends WebTestCase
{
    private string $url;
    private array $addressesList;
    private KernelBrowser $client;
    private EmailFixture $emailFixture;

    public function setUp(): void
    {
        parent::setUp();
        $this->url = 'http://localhost:888/api/send';
        $this->client = static::createClient();
        $emails = static::getContainer()->get(EmailRepositoryInterface::class);
        $emailStatuses = static::getContainer()->get(EmailStatusRepositoryInterface::class);
        $this->emailFixture = new EmailFixture($emails, $emailStatuses);
    }

    public function testSendActionSuccess()
    {
        $email = $this->emailFixture->create();
        $this->fillAddressesList();

        $command = new CreateEmailDistributionCommand($this->addressesList, $email->getTheme(), $email->getContent());

        $this->client->request(Request::METHOD_POST, $this->url, [], [], [], json_encode($command));
        $this->assertResponseIsSuccessful();

        /** @var array $responseData */
        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertSame('Emails created successfully', $responseData['message']);
        $this->assertIsArray($responseData['createdEmailIdsList']);

        /** @var array $responseData['createdEmailIdsList'] */
        foreach ($responseData['createdEmailIdsList'] as $emailId) {
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
