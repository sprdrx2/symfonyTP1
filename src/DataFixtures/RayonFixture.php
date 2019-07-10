<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Rayon;

class RayonFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
	$rayon = new Rayon();
	$rayon->setTitle('Legumes');
	$rayon->setDescription('Pour les amateurs de la vie saine');
	$rayon->setImageFile('legumes.jpg');
        $manager->persist($rayon);$rayon = new Rayon();
	
	$rayon->setTitle('Junk Food');
	$rayon->setDescription('Pour les amateurs de la vie pas saine');
	$rayon->setImageFile('junkfood.jpg');
	$manager->persist($rayon);

	$rayon = new Rayon();
	$rayon->setTitle('Alcools');
	$rayon->setDescription('Pour les amateurs de la vie rigolote');
	$rayon->setImageFile('alcools.jpg');
	$manager->persist($rayon);
	
	$rayon = new Rayon();
	$rayon->setTitle('Cigarettes');
	$rayon->setDescription('Pour les amateurs de la vie courte');
	$rayon->setImageFile('cigarettes.jpg');
        $manager->persist($rayon);

	$rayon = new Rayon();
	$rayon->setTitle('Glaces');
	$rayon->setDescription('Pour les amateurs de la vie fraîche');
	$rayon->setImageFile('glaces.jpg');
        $manager->persist($rayon);
    
	$manager->flush();
    }
}
