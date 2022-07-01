<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class MyCompanyController extends AbstractController
{

    public function __construct(private Security $security)
    {}

    public function __invoke(): UserInterface
    {
        return $this->security->getUser();
    }

}
