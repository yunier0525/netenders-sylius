<?php

namespace App\Services;

use App\Entity\Newsletter;
use App\Email\NewsletterEmail;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

class SendNewslettersService
{
    public function __construct(
        private ManagerRegistry $doctrine,
        private NewsletterEmail $newsletterEmail
    ) {
    }

    public function sendNewsletter(string|int $newsletterId)
    {
        $newsletters = [];

        if ($newsletterId === 'all') {
            $newsletters = $this->doctrine
                ->getRepository(Newsletter::class)
                ->findAll();
        } else {
            $newsletters = [
                $this->doctrine
                    ->getRepository(Newsletter::class)
                    ->find($newsletterId)
            ];
        }

        try {
            $this->send($newsletters);

            return true;
        } catch (Exception) {
            return false;
        }
    }

    private function send(array $newsletters)
    {
        foreach ($newsletters as $newsletter) {
            $subscribers = $newsletter->getUsers();
            if ($subscribers->count() > 0) {
                foreach ($subscribers as $subscriber) {
                    $this->newsletterEmail->sendEmail($newsletter, $subscriber);
                }
            }
        }
    }
}
