<?php

namespace App\Email;

use App\Entity\Newsletter;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Security\Core\User\UserInterface;

class NewsletterEmail
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(Newsletter $newsletter, UserInterface $user): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address('netenders@sylius.com', 'Netenders Sylius Bot'))
            ->to($user->getEmail())
            ->subject($newsletter->getSubject())
            ->htmlTemplate('newsletter/newsletter_email.html.twig');

        $context = $email->getContext();
        $context['unsubscribeUrl'] = 'test';
        $context['newsletter'] = $newsletter;
        $context['subscriber'] = $user;

        $email->context($context);

        $this->mailer->send($email);
    }
}
