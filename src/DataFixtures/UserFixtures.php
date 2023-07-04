<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher) 
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager): void
    {
        // Création d’un utilisateur de type “contributeur” (= auteur)
        $contributor = new User();
        $contributor->setEmail('olivia@monsite.com');
        $contributor->setRoles(['ROLE_CONTRIBUTOR']);
        $contributor->setUsername('Olivia');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $contributor,
            'olivia'
        );
        $contributor->setPassword($hashedPassword);
        $this->addReference('contributor1', $contributor);
        $manager->persist($contributor);

        $contributor = new User();
        $contributor->setEmail('emily@monsite.com');
        $contributor->setRoles(['ROLE_CONTRIBUTOR']);
        $contributor->setUsername('Emily');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $contributor,
            'emily'
        );
        $contributor->setPassword($hashedPassword);
        $this->addReference('contributor2', $contributor);
        $manager->persist($contributor);
        
        // Création d’un utilisateur de type “administrateur”
        $admin = new User();
        $admin->setEmail('james@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setUsername('James');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'james'
        );
        $admin->setPassword($hashedPassword);
        $this->addReference('admin1', $admin);
        $manager->persist($admin);

        $admin = new User();
        $admin->setEmail('david@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setUsername('David');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'david'
        );
        $admin->setPassword($hashedPassword);
        $this->addReference('admin2', $admin);
        $manager->persist($admin);

        // Sauvegarde les 4 nouveaux utilisateurs :
        $manager->flush();
    }
}