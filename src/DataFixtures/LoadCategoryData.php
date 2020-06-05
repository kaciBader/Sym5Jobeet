<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class LoadCategoryData extends Fixture
{
    public function load(ObjectManager $manager)
    {

		$design = new Category();
	    $design->setName('Design');
	 
	    $programming = new Category();
	    $programming->setName('Programming');
	 
	    $managere = new Category();
	    $managere->setName('Manager');
	 
	    $administrator = new Category();
	    $administrator->setName('Administrator');
	 
	    $manager->persist($design);
	    $manager->persist($programming);
	    $manager->persist($managere);
	    $manager->persist($administrator);
	 
	    $manager->flush();
	 
	    $this->addReference("category-design", $design);
	    $this->addReference("category-programming", $programming);
	    $this->addReference("category-manager", $manager);
	    $this->addReference("category-administrator", $administrator);
    }
}
