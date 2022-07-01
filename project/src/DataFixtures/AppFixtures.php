<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    { }

    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        /* COMPANY FIXTURES */
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
            $cie->setPhoneNumber(0 . (random_int(100000000, 798765432)));
            $manager->persist($cie);
        }
        $manager->flush();


        /* USER FIXTURES */
        $cieRepo = $manager->getRepository(Company::class)->findAll();
        $plaintextPassword = 'pouet';
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
                ->setRoles(['ROLE_CLIENT_'.$i])
                ->setEmail('client'.$i.'@easypicky.fr')
                ->setCompany($cieRepo[$i]) : null;

            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);

            $manager->persist($user);
        }
        $manager->flush();
    }
}
