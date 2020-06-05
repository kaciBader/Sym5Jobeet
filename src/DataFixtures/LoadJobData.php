<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Job; 
use Faker ;
class LoadJobData extends Fixture implements DependentFixtureInterface
{
	/**
	* 
	* return a category reference 
	* @param int $index
	* @return string 
	*/
	private static  function getCategoryRandomly($index = 0)
	{
		$catTab  = ['category-design', 'category-programming', 'category-manager', 'category-administrator'] ;
		var_dump($catTab);
		return $catTab[$index];

	}
	/*private static function getPositionFromReference($str)
	{
		return str_replace($str,'category-','');
	}*/
    public function load(ObjectManager $manager)
    {
	    $faker = Faker\Factory::create();
	    for($i =0 ; $i< 10; $i++) 
        {
        	$job = new Job();
        	//$x  = rand(0,2);
        	//var_dump($x);
        	$ref  = self::getCategoryRandomly($i%2);
 //var_dump($ref);
	        $job->setCategory($this->getReference($ref));
	       
			$job->setType('full-time');  // penser a faire une fonction qui expose les types de données full-time, half-time, 
			$job->setCompany($faker->company);
			$job->setLogo('sensio-labs.gif');  // penser pour les gif
			$job->setUrl('http://www.sensiolabs'.$i.'com/');
			// $job->setUrl($faker->url);
			$job->setPosition('Web Developer'.$i);
			$job->setLocation($faker->city);
			$job->setDescription($faker->realText(30,2) );
			$email   = $faker->email;
			$job->setHowToApply('Send your resume to'.$email);
			$job->setIsPublic($faker->boolean(50));
			$job->setIsActivated(true);  // to check
			$job->setToken('job_expired');
			$job->setEmail($email);
			$job->setCreatedAt(new \DateTime('2020-12-01')); 
			$job->setExpiresAt(new \DateTime('2020-11-10'));
		    $manager->persist($job);
		    
	    }
	    $manager->flush();
    }

    // define order of fixtures 
    public function getDependencies()
    {
        return array(
            LoadCategoryData::class,
        );
    }
}
