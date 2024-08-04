<?php

declare(strict_types=1);

namespace App\Emails\Application\MessageHandler;

use App\Emails\Application\Message\EmailMessage;
use App\Emails\Domain\Repository\EmailRepositoryInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;

#[AsMessageHandler]
class EmailMessageHandler
{
    public function __construct(
        private readonly EmailRepositoryInterface $emails,
        private readonly MailerInterface $mailer,
    ) {
    }

    public function __invoke(EmailMessage $emailMessage)
    {
        $email = $this->emails->findById($emailMessage->id);
        
        if ($email->isEmailStatusNew()) {
            $emailToSend = (new Email())
                ->from('maxgoover@gmail.com')
                ->to($email->getAddress())
                ->subject($email->getTheme())
                ->text($email->getContent());
            // ->html('<p>See Twig integration for better HTML integration!</p>');

            $this->mailer->send($emailToSend);
        }
    }
}
