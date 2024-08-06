<?php

declare(strict_types=1);

namespace Tests\Functional\Emails\Domain\Factory;

use App\Emails\Domain\Entity\Email;
use App\Emails\Domain\Entity\EmailStatus;
use App\Emails\Domain\Factory\EmailFactory;
use App\Emails\Domain\Repository\EmailStatusRepositoryInterface;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmailFactoryTest extends WebTestCase
{
    private EmailStatusRepositoryInterface $emailStatuses;
    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->emailStatuses = static::getContainer()->get(EmailStatusRepositoryInterface::class);
        $this->faker = Factory::create();
    }

    public function testCreateSuccess()
    {
        $address = $this->faker->email();
        $theme = $this->faker->realText(50);
        $content = $this->faker->realText(100);
        $emailStatus = $this->emailStatuses->findByCodename(EmailStatus::NEW);

        $email = EmailFactory::create($address, $theme, $content, $emailStatus);
        $this->assertInstanceOf(Email::class, $email);
    }
}
