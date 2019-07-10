<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use App\Entity\Rayon;

class RayonFixture extends Fixture implements OrderedFixtureInterface
{
    public function getOrder() { return 1; }

    public function load(ObjectManager $manager)
    {
	$rayon = new Rayon();
	$rayon->setTitle('Legumes');
	$rayon->setDescription('Pour les amateurs de la vie saine');
	$rayon->setImageFile('legumes.jpg');
	$this->setReference('rayonLegumes', $rayon);
        $manager->persist($rayon);$rayon = new Rayon();
	
	$rayon->setTitle('Junk Food');
	$rayon->setDescription('Pour les amateurs de la vie pas saine');
	$rayon->setImageFile('junkfood.jpg');
	$this->setReference('rayonJunkFood', $rayon);
	$manager->persist($rayon);

	$rayon = new Rayon();
	$rayon->setTitle('Alcools');
	$rayon->setDescription('Pour les amateurs de la vie rigolote');
	$rayon->setImageFile('alcools.jpg');
	$this->setReference('rayonAlcools', $rayon);
	$manager->persist($rayon);
	
	$rayon = new Rayon();
	$rayon->setTitle('Cigarettes');
	$rayon->setDescription('Pour les amateurs de la vie courte');
	$rayon->setImageFile('cigarettes.jpg');
	$this->setReference('rayonCigarettes', $rayon);
        $manager->persist($rayon);

	$rayon = new Rayon();
	$rayon->setTitle('Glaces');
	$rayon->setDescription('Pour les amateurs de la vie fraîche');
	$rayon->setImageFile('glaces.jpg');
	$this->setReference('rayonGlaces', $rayon);
        $manager->persist($rayon);
    
	$manager->flush();
    }
}
