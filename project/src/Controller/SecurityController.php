<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        // last Email entered by the user
        $lastEmail = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'controller_name' => 'App\Controller\SecurityController',
            'last_email' => $lastEmail,
            'error'         => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): Response
    {
        return $this->render('security/index.html.twig', []);
    }

    #[Route(path: '/api/login', name: 'api_login', methods: ['POST'])]
    public function jsonLogin(): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->json([
            'username' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ]);
    }
}
