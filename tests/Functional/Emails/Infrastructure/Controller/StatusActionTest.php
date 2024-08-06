<?php

declare(strict_types=1);

namespace Tests\Functional\Emails\Infrastructure\Controller;

use App\Emails\Application\Query\FindEmailById\FindEmailByIdQuery;
use App\Emails\Domain\Repository\EmailRepositoryInterface;
use App\Emails\Domain\Repository\EmailStatusRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Tests\Fixture\Emails\EmailFixture;

class StatusActionTest extends WebTestCase
{
    private string $url;
    private KernelBrowser $client;
    private EmailFixture $emailFixture;

    public function setUp(): void
    {
        parent::setUp();
        $this->url = 'http://localhost:888/api/status';
        $this->client = static::createClient();
        $emails = static::getContainer()->get(EmailRepositoryInterface::class);
        $emailStatuses = static::getContainer()->get(EmailStatusRepositoryInterface::class);
        $this->emailFixture = new EmailFixture($emails, $emailStatuses);
    }

    public function testSendActionSuccess()
    {
        $email = $this->emailFixture->create();
        $query = new FindEmailByIdQuery($email->getId());

        $this->client->request(Request::METHOD_GET, $this->url, (array)$query);
        $this->assertResponseIsSuccessful();

        /** @var array $responseData */
        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertSame('Email got successfully', $responseData['message']);
        $this->assertIsString($responseData['status']);
    }
}
