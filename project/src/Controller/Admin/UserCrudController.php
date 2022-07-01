<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    { }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $roles = ['ROLE_ADMIN', 'ROLE_USER'];
        return [
            FormField::addPanel( 'Données clients' )->setIcon( 'fa fa-user' ),
            TextField::new('firstName'),
            TextField::new('lastName'),
            TextField::new('email'),
            ChoiceField::new('roles')
                ->setChoices(array_combine($roles, $roles))
                ->allowMultipleChoices()
                ->renderExpanded()
                ->renderAsBadges()
                ->setHelp('Vous serez déconnecté en cas de modification des roles!'),
            AssociationField::new('company'),
            FormField::addPanel( 'Change password' )->setIcon( 'fa fa-key' ),
            Field::new( 'plainPassword', 'Mot de passe' )->setRequired(false)
                ->onlyOnForms()
                ->setFormType( RepeatedType::class )
                ->setFormTypeOptions( [
                    'type'            => PasswordType::class,
                    'first_options'   => [ 'label' => 'Mot de passe' ],
                    'second_options'  => [ 'label' => 'Répétez Mot de passe' ],
                    'error_bubbling'  => false,
                    'invalid_message' => 'Les mots de passe ne corresponde pas.',
                ] ),
        ];
    }


    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->encodePassword($entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->checkPassword($entityInstance);
        $this->checkCompany($entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }

    private function encodePassword(User $user)
    {
        if ($user->getPlainPassword() !== null) {
            $user->setPassword($this->passwordHasher->hashPassword(
                $user,
                $user->getPlainPassword()
            ));

        }
    }

    public function createEntity(string $entityFqcn)
    {
        $article = new User();
        $article->setPassword($this->getUser());

        return $article;
    }

    private function checkPassword($entityInstance)
    {
        if (empty($entityInstance->getPlainPassword())) {
            return;
        }
        $this->encodePassword($entityInstance);
    }

    private function checkCompany($entityInstance)
    {
        if ($entityInstance->getCompany() === '') {
            $entityInstance->setCompany(null);
        }
    }

}
