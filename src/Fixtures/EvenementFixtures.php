<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Evenement;

class EvenementFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Create and persist test data
        $evenement1 = new Evenement();
        $evenement1->setTitre('Test Evenement 1');
        $evenement1->setDescription('Description for Test Evenement 1');
        $evenement1->setDateDeDebut(new \DateTime('08-12-2023'));
        $evenement1->setDateDeFin(new \DateTime('09-12-2023'));
        $evenement1->setLieu("Tunis");

        $evenement2 = new Evenement();
        $evenement2->setTitre('Test Evenement 2');
        $evenement2->setDescription('Description for Test Evenement 2');
        $evenement2->setDateDeDebut(new \DateTime('08-12-2023'));
        $evenement2->setDateDeFin(new \DateTime('09-12-2023'));
        $evenement2->setLieu("Tunis");
        // Set other properties as needed

        $manager->persist($evenement1);
        $manager->persist($evenement2);

        $manager->flush();
    }
}