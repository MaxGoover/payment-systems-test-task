<?php

declare(strict_types=1);

namespace App\Tests\Feature\Mailer;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Tests\Fixtures\EmailFixture;

class MailerSendActionTest extends WebTestCase
{
    public function testCreateEmailSuccess(): void{
        $emailFixture = EmailFixture::create();
        $client = static::createClient();
        $client->request(Request::METHOD_POST, '/mailer/send', (array)$emailFixture);

        $this->assertResponseIsSuccessful();
        $jsonResult = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($jsonResult['message'], 'Email created successfully');
    }
}
