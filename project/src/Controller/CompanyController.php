<?php

namespace App\Controller;

use App\Entity\Company;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    /**
     * generates 3 companies
     * @throws Exception
     */
    #[Route('/generate-companies', name: 'app_company')]
    public function index(ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher): Response
    {
        $entityManager = $doctrine->getManager();
        $listCie = ['Danone', 'Mondelez', 'Nestlé'];

        for ($i = 0; $i < 3; $i++) {
            $cie = new Company();
            $cie->setName($listCie[$i]);
            $cie->setAddress('address' . $i);
            $cie->setCity('city' . $i);
            $cie->setActivityArea('activity area' . $i);
            $cie->setCountry('country' . $i);
            $cie->setSiren(strval(random_int(000000001, 999999999)));
            $cie->setZipCode(strval(random_int(01000, 97400)));
            $cie->setPhoneNumber(strval(0 . (random_int(100000000, 798765432))));
            $entityManager->persist($cie);
        }

        // commented to leave the page that lists the companies (must not generate again and again)
//        $entityManager->flush();

        return new Response('Saved new Companies');

    }
}
