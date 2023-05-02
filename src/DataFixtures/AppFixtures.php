<?php

namespace App\DataFixtures;

use App\Entity\Roles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\ClientFactory; 
use App\Factory\FactureClientFactory; 
use App\Factory\FournisseurFactory; 
use App\Factory\FactureFournisseurFactory; 
use App\Factory\LigneProduitClientFactory; 
use App\Factory\ServiceFactory; 
use App\Factory\ProduitFactory; 
use App\Factory\UserFactory; 

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        ClientFactory::createMany(10);
        FactureClientFactory::createMany(10);
        FournisseurFactory::createMany(10);
        FactureFournisseurFactory::createMany(10);
        FournisseurFactory::createMany(10);
        ProduitFactory::createMany(10);
        FournisseurFactory::createMany(10);
        UserFactory::createMany(1);
        LigneProduitClientFactory::createMany(1);
        
        $manager->flush();
    }


    /***
     * Création de roles
     * @param ObjectManager $manager
     */
    private function createRoles(ObjectManager $manager): void
    {
        $roleList = [
            'ROLE_ADMIN',
            'ROLE_USER',
            'ROLE_COMPTABLE'
        ];

        foreach ($roleList as $role) {
            $userBase = new Roles();
            $userBase->setName($role);
            $manager->persist($userBase);
        }

        $manager->flush();
    }
}
