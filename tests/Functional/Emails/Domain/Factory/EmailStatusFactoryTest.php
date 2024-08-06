<?php

declare(strict_types=1);

namespace Tests\Functional\Emails\Domain\Factory;

use App\Emails\Domain\Entity\EmailStatus;
use App\Emails\Domain\Factory\EmailStatusFactory;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmailStatusFactoryTest extends WebTestCase
{
    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }

    public function testCreateSuccess()
    {
        $codename = $this->faker->text(10);
        $emailStatus = EmailStatusFactory::create($codename);
        $this->assertInstanceOf(EmailStatus::class, $emailStatus);
    }
}
