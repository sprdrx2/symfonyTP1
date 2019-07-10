<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Product;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
	    $product = new Product();
	    $product->setTitle('salade');
	    $product->setDescription('c bon pour la santé');
	    $product->setPrice(0.99);
	    $manager->persist($product);

	    $product = new Product();
	    $product->setTitle('tomate');
	    $product->setDescription('c bon pour le moral');
	    $product->setPrice(1.99);
	    $manager->persist($product);

            $product = new Product();
	    $product->setTitle('oignon');
	    $product->setDescription('c bon pour le transit');
	    $product->setPrice(2.99);
	    $manager->persist($product);

            $manager->flush();
    }
}
