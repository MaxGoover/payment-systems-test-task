<?php

declare(strict_types=1);

namespace App\Emails\Application\Command\SendEmail;

use App\Shared\Application\Command\CommandHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class SendEmailCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
    ) {
    }

    public function __invoke(SendEmailToBusCommand $sendEmailToBusCommand)
    {
        $this->messageBus->dispatch(new SmsNotification('Look! I created a message!'));

        return count($this->emailsList);
    }
}
