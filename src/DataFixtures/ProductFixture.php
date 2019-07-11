<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use App\Entity\Product;
use App\Entity\PopularVote;
use App\Entity\Comment;

class ProductFixture extends Fixture implements OrderedFixtureInterface
{
    private $fakeClients = ["Norimaki Arale", "Norimaki Gatchan", "Joe Le Taxi", "Mr. Oiseau", "Francky le Franckais"];
    public function getOrder() { return 2; }

    public function load(ObjectManager $manager)
    {
            $this->manager = $manager;

	    $rayonLegumes = $this->getReference('rayonLegumes'); 
	    $rayonJunkFood = $this->getReference('rayonJunkFood'); 
	    $rayonCigarettes = $this->getReference('rayonCigarettes'); 
	    $rayonAlcools = $this->getReference('rayonAlcools'); 
	    $rayonGlaces = $this->getReference('rayonGlaces'); 
	
	    $product = new Product();
	    $product->setTitle('salade');
	    $product->setDescription('c bon pour la sante');
	    $product->setPrice(0.99);
	    $product->setRayon($rayonLegumes);
	    $manager->persist($product);
	    $this->addCommentsAndPopularVotes($product);

	    $product = new Product();
	    $product->setTitle('tomate');
	    $product->setDescription('c bon pour le moral');
	    $product->setPrice(1.99);
	    $product->setRayon($rayonLegumes);
	    $manager->persist($product);
	     $this->addCommentsAndPopularVotes($product);

            $product = new Product();
	    $product->setTitle('oignon');
	    $product->setDescription('c bon pour le transit');
	    $product->setPrice(2.99);
	    $product->setRayon($rayonLegumes);
	    $manager->persist($product);
 	    $this->addCommentsAndPopularVotes($product);

	    foreach (["choux de bruxelle","carotte", "persil", "courgette", "aubergine", "petit pois", "haricot vert", "topinenbourg"] as $legume) {
		    $product = new Product();
		    $product->setTitle($legume);
		    $product->setDescription('c bon pour tout');
		    $product->setPrice(rand(0,9) + .99);
		    $product->setRayon($rayonLegumes);
		    $manager->persist($product);
 		    $this->addCommentsAndPopularVotes($product);
	    }

	    foreach (["whiskey", "bourbon", "rhum", "champagne", "piquette"] as $alcool) {
		    $product = new Product();
		    $product->setTitle($alcool);
		    $product->setDescription('c mal');
		    $product->setPrice(rand(0,9) + .99);
		    $product->setRayon($rayonAlcools);
		    $manager->persist($product);
		    $this->addCommentsAndPopularVotes($product);
	    }

            for($i = 60; $i < 70; $i++) {
		    $product = new Product();
		    $product->setTitle("Boisson 16$i");
		    $product->setDescription('c mal');
		    $product->setPrice($i + .99);
		    $product->setRayon($rayonAlcools);
		    $manager->persist($product);
	    	     $this->addCommentsAndPopularVotes($product);	    
	    }

	    foreach (["pistache", "vanille", "chocolat", "fraise", "noix de coco"] as $glace) {
		    $product = new Product();
		    $product->setTitle("Glace a la $glace");
		    $product->setDescription('c mal');
		    $product->setPrice(rand(0,9) + .99);
		    $product->setRayon($rayonGlaces);
		    $manager->persist($product);
 		    $this->addCommentsAndPopularVotes($product);
	    }

	    foreach (["pizza", "kebab", "sandwich a la banane", "merguez", "burger triple XL"] as $junkFood) {
		    $product = new Product();
		    $product->setTitle("$junkFood surgele");
		    $product->setDescription('a consommer avec moderation');
		    $product->setPrice(rand(0,9) + .99);
		    $product->setRayon($rayonJunkFood);
		    $manager->persist($product);
 		    $this->addCommentsAndPopularVotes($product);
	    }

	    foreach (["Malbobo Light", "Chameau Original", "Locky Strap", "Mento Fraise", "La Havane"] as $cigarette) {
		    $product = new Product();
		    $product->setTitle($cigarette);
		    $product->setDescription('Pour les deadlines. Paquet de 20.');
		    $product->setPrice(rand(0,9) + .99);
		    $product->setRayon($rayonCigarettes);
		    $manager->persist($product);
 		    $this->addCommentsAndPopularVotes($product);
	    }

            $manager->flush();
    }

    private function addCommentsAndPopularVotes($product) {
	    	$m = $this->manager;

	        for($i = 0; $i <= rand(1,100); $i++) {
                        $v = new PopularVote();
                        $v->setProduct($product);
                        $v->setVerdict(TRUE);
                        $m->persist($v);
                }
                for($i = 0; $i <= rand(1,100); $i++) {
                        $v = new PopularVote();
                        $v->setProduct($product);
                        $v->setVerdict(FALSE);
                        $m->persist($v);
		}
		for($i = 0; $i <= rand(1,3); $i++) {
			$c = new Comment();
			$c->setClientName($this->fakeClients[array_rand($this->fakeClients)]);
			$c->setProduct($product);
			$c->setText("SP".str_repeat("A", rand(1,17))."M");
			$m->persist($c);	
		}
    }	    

}
