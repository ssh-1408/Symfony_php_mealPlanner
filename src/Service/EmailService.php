<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendContactMessage(string $fromEmail, string $messageContent): void
    {
        $email = (new Email())
            ->from($fromEmail)
            ->to('admin@example.com') // << Admin-Email eintragen
            ->subject('New Contact Message')
            ->text($messageContent);

        $this->mailer->send($email);
    }
}
