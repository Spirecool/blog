<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    //on injecte le passwordHasher dans le constructeur
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }
    


    public static function getEntityFqcn(): string
    {
        return User::class;
    }

   
    public function configureFields(string $pageName): iterable
    {
        
        yield TextField::new('username');
        yield TextField::new('password')
            ->setFormType(PasswordType::class)
            ->onlyOnForms();
        yield ChoiceField::new('roles')
            ->allowMultipleChoices()
            ->renderAsBadges([
                'ROLE_ADMIN' => 'success',
                'ROLE_AUTHOR' => 'warning'
            ])
            ->setChoices([
                'Administrateur' => 'ROLE_ADMIN',
                'Auteur' => 'ROLE_AUTHOR'
            ]);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /** @var User $user */
        $user = $entityInstance;

        $plainPassword = $user->getPassword();
        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);

        //on hashe le password à la volée, juste avant de l'enregistrer en bdd
        $user->setPassword($hashedPassword);

        parent::persistEntity($entityManager, $entityInstance);
    }
   
}
