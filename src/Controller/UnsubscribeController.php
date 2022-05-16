<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UnsubscribeController extends AbstractController
{
    #[Route('/unsubscribe', name: 'app_unsubscribe')]
    public function index(Request $request, UserRepository $userRepository, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {
        $id = $request->get('id');
        $newsletterId = $request->get('newsletter');

        if (null === $id) {
            return $this->redirectToRoute('app_register');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }

        $user->removeNewsletter($doctrine
            ->getRepository(Newsletter::class)
            ->find($newsletterId));

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->render('unsubscribe/index.html.twig', [
            'email' => $user->getEmail()
        ]);
    }
}
