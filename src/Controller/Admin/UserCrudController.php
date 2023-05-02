<?php

namespace App\Controller\Admin;

use App\AbstractClass\UserRolesEnum;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{

    public function __construct(public UserPasswordHasherInterface $passwordHasher)
    {
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $user = new User();
        $user->setEmail($entityInstance->getEmail());
        $user->setIsVerified($entityInstance->isIsVerified());
        $user->setUsername($entityInstance->getUsername());
        $plaintextPassword = 'test';
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);
        $user->setService($entityInstance->getService());
        $user->setLocale($entityInstance->getLocale());
        $user->setRoles($entityInstance->getRoles());
        $entityManager->persist($user);
        $entityManager->flush();
    }

    public function registration()
    {

        // ...
    }

    public function configureFields(string $pageName): iterable
    {
        yield IntegerField::new('id', 'ID')->onlyOnIndex();
        yield TextField::new('username', 'Nom & Prénom');
        yield TextField::new('email', 'Adresse Mail');
        yield TextField::new('locale', 'Locale');
        yield BooleanField::new('is_verified', 'Vérifié');
        yield AssociationField::new('service','Service');
        yield ChoiceField::new('roles', 'Roles')
        ->setChoices(UserRolesEnum::$roles)->allowMultipleChoices();

    }

}
