<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * generates 3 users
     * @param ManagerRegistry $doctrine
     * @param UserPasswordHasherInterface $passwordHasher
     * @return Response
     */
    #[Route('/generate-users', name: 'app_user')]
    public function index(ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher): Response
    {
        $entityManager = $doctrine->getManager();
        $plaintextPassword = 'pouet';
        $cieRepo = $entityManager->getRepository(Company::class)->findAll();
        $users = [];

        for ($i = 0; $i < 3; $i++) {
            $user = new User();
            // Admin
            $i === 0
                ? $user
                ->setRoles(['ROLE_ADMIN'])
                ->setEmail('admin@easypicky.fr')
                ->setFirstName('admin')
                ->setLastName('admin')
                : $user->setRoles(['ROLE_USER']);
            // 2 Customers
            $i !== 0 ? $user->setLastName('userLastname'.$i)
                ->setFirstName('userFirstname'.$i)
                ->setEmail('Client'.$i.'@easypicky.fr') : null;

            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            $user->setCompany($cieRepo[$i]);

            $entityManager->persist($user);
            $users[] = $user;
        }

        // commented to leave the page that lists the users (must not generate again and again)
//        $entityManager->flush();

        return $this->render('user/index.html.twig', ['users' => $users]);
    }
}
