<?php

declare(strict_types=1);

namespace Tests\Fixture\Emails;

use App\Emails\Domain\Entity\Email;
use App\Emails\Domain\Entity\EmailStatus;
use App\Emails\Domain\Factory\EmailFactory;
use App\Emails\Infrastructure\Repository\EmailRepository;
use App\Emails\Infrastructure\Repository\EmailStatusRepository;
use Faker\Factory;
use Faker\Generator;

class EmailFixture
{
    private EmailRepository $emails;
    private EmailStatusRepository $emailStatuses;
    private Generator $faker;

    public function __construct(EmailRepository $emails, EmailStatusRepository $emailStatuses)
    {
        $this->faker = Factory::create();
        $this->emails = $emails;
        $this->emailStatuses = $emailStatuses;
    }

    public function create(): Email
    {
        $address = $this->fakeAddress();
        $theme = $this->faker->realText(50);
        $content = $this->faker->realText(100);
        $emailStatus = $this->emailStatuses->findByCodename(EmailStatus::NEW);

        $email = EmailFactory::create($address, $theme, $content, $emailStatus);
        $this->emails->store($email);

        return $email;
    }

    public function fakeAddress(): string
    {
        return $this->faker->email();
    }
}
