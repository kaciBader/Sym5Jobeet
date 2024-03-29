<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JobControllerTest extends WebTestCase
{
     private function getMostRecentProgrammingJob()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
 
        $query = $em->createQuery('SELECT j from App\Entity\Job j LEFT JOIN j.category c WHERE c.slug = :slug AND j.expires_at > :date ORDER BY j.created_at DESC');
        $query->setParameter('slug', 'programming');
        $query->setParameter('date', date('Y-m-d H:i:s', time()));
        $query->setMaxResults(1);
        return $query->getSingleResult();
    }

    public function getExpiredJob()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        $query = $em->createQuery('SELECT j from App\Entity\Job j WHERE j.expires_at < :date');     $query->setParameter('date', date('Y-m-d H:i:s', time()));
        $query->setParameter('date', date('Y-m-d H:i:s', time()));
        $query->setMaxResults(1);
        return $query->getSingleResult();
    }

    public function testIndex()
    {
        $client = static::createClient();
        $crawler  = $client->request('GET','/job/');
        //test response code 
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        // test the called action
        $this->assertEquals("App\Controller\JobController::index", $client->getRequest()->attributes->get('_controller'));
        // test the route 
        $this->assertEquals("job_index", $client->getRequest()->attributes->get('_route'));
        // test that the expired td balise d'ont exist
        $this->assertTrue($crawler->filter('.jobs td.position:contains("Expired")')->count() == 0);
        // autre ecriture de test precedent 
        $this->assertEquals(0,$crawler->filter('.jobs td.position:contains("Expired")')->count());


		 $container = self::$container;
    	 $max_jobs_on_homepage = $container->getParameter('max_jobs_on_homepage');
		//$this->assertTrue($crawler->filter('.category_programming tr')->count());
		$this->assertTrue($max_jobs_on_homepage === $crawler->filter('.category_programming tr')->count());

		$this->assertFalse($crawler->filter('.category_design .more_jobs')->count() == 0);
		$this->assertTrue($crawler->filter('.category_programming .more_jobs')->count() == 1);

        //get the recente jobs  
       $this->assertTrue($crawler->filter('.category_programming tr')->first()->filter(sprintf('a[href*="/%d/"]', $this->getMostRecentProgrammingJob()->getId()))->count() == 1);


        $job = $this->getMostRecentProgrammingJob();
        $link = $crawler->selectLink('Web Developer1')->first()->link(); 
        $crawler = $client->click($link);
        // test the link 
        // when the link is clicked show action is executed
        $this->assertEquals('App\Controller\JobController::show', $client->getRequest()->attributes->get('_controller'));

        $this->assertEquals($job->getCompanySlug(), $client->getRequest()->attributes->get('company'));

        $this->assertEquals($job->getLocationSlug(), $client->getRequest()->attributes->get('location'));

        $this->assertEquals($job->getPositionSlug(), $client->getRequest()->attributes->get('position'));

        $this->assertEquals($job->getId(), $client->getRequest()->attributes->get('id'));

        // a non-existent job forwards the user to a 404
        $crawler = $client->request('GET', '/job/foo-inc/milano-italy/0/painter');
        $this->assertTrue(404 === $client->getResponse()->getStatusCode());
        // an expired job page forwards the user to a 404
        $crawler = $client->request('GET', sprintf('/job/sensio-labs/paris-france/%d/web-developer-expired', $this->getExpiredJob()->getId()));
        $this->assertTrue(404 === $client->getResponse()->getStatusCode());

    }

   
}
