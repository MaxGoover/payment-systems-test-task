<?php

declare(strict_types=1);

namespace Tests\Fixture\Emails;

use App\Emails\Domain\Entity\EmailStatus;
use App\Emails\Domain\Factory\EmailStatusFactory;
use App\Emails\Infrastructure\Repository\EmailStatusRepository;
use Faker\Factory;
use Faker\Generator;

class EmailStatusFixture
{
    private EmailStatusRepository $emailStatuses;
    private Generator $faker;

    public function __construct(EmailStatusRepository $emailStatuses)
    {
        $this->faker = Factory::create();
        $this->emailStatuses = $emailStatuses;
    }

    public function create(): EmailStatus
    {
        $codename = $this->faker->text(10);
        $emailStatus = EmailStatusFactory::create($codename);
        $this->emailStatuses->create($emailStatus);

        return $emailStatus;
    }
}
