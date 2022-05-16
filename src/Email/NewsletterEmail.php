<?php

namespace App\Email;

use App\Entity\Newsletter;
use App\Services\UrlSignerService;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Security\Core\User\UserInterface;

class NewsletterEmail
{
    public function __construct(
        private MailerInterface $mailer,
        private UrlSignerService $urlSignerService
    ) {
    }

    public function sendEmail(Newsletter $newsletter, UserInterface $user): void
    {
        $signature = $this->urlSignerService->generateUrlSigned(
            'app_unsubscribe',
            $user->getId(),
            $user->getEmail(),
            ['id' => $user->getId(), 'newsletter' => $newsletter->getId()]
        );

        $email = (new TemplatedEmail())
            ->from(new Address('netenders@sylius.com', 'Netenders Sylius Bot'))
            ->to($user->getEmail())
            ->subject($newsletter->getSubject())
            ->htmlTemplate('newsletter/newsletter_email.html.twig');

        $context = $email->getContext();
        $context['unsubscribeUrl'] = 'test';
        $context['newsletter'] = $newsletter;
        $context['subscriber'] = $user;
        $context['unsubscribe'] = $signature;

        $email->context($context);

        $this->mailer->send($email);
    }
}
