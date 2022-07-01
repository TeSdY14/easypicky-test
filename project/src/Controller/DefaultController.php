<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    #[Route(path: '/', name: 'app_index')]
    public function index(): Response {
        $user = $this->getUser();
        return $this->render('default/index.html.twig', [
            'user' => $user
        ]);
    }

}
