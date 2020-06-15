<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends  WebTestCase
{
    public function testShow()
    {

         // get the custom parameters from app config.yml
        $kernel = static::createKernel();
        $kernel->boot();
        $max_jobs_on_homepage = $kernel->getContainer()->getParameter('max_jobs_on_homepage');
        $max_jobs_on_category = $kernel->getContainer()->getParameter('max_jobs_on_category');



        $client = static::createClient();

        // categories on homepage are clickable
        $crawler = $client->request('GET', '/job/');
        $link = $crawler->selectLink('Programming')->link();
        $crawler = $client->click($link);
        $this->assertEquals('App\Controller\CategoryController::show', $client->getRequest()->attributes->get('_controller'));
        $this->assertEquals('programming', $client->getRequest()->attributes->get('slug'));

        // categories with more than $max_jobs_on_homepage jobs also have a "more" link
        $crawler = $client->request('GET', '/job/');
        $link = $crawler->selectLink('25')->link();
        $crawler = $client->click($link);
        $this->assertEquals('App\Controller\CategoryController::show', $client->getRequest()->attributes->get('_controller'));
        $this->assertEquals('design', $client->getRequest()->attributes->get('slug'));

         // only $max_jobs_on_category jobs are listed
        $this->assertTrue($crawler->filter('.jobs tr')->count() == 10);
        //$this->assertRegExp('/32 jobs/', $crawler->filter('.pagination_desc')->text());
        //$this->assertRegExp('/page 1\/2/', $crawler->filter('.pagination_desc')->text());

        $link = $crawler->selectLink('2')->link();
        $crawler = $client->click($link);
        //$this->assertEquals(2, $client->getRequest()->attributes->get('page'));
        //$this->assertRegExp('/page 2\/2/', $crawler->filter('.pagination_desc')->text());
       

       //$this->assertEquals('programming', $client->getRequest()->attributes->get('slug'));

    	/*$crawler = $client->request('GET', '/Category/design');
    	// test of the executed action
    	$this->assertEquals('App\Controller\CategoryController::show', $client->getRequest()->attributes->get('_controller'));
    	$slug  = ucfirst($client->getRequest()->attributes->get('slug'));
    	dump($slug);
    	// test de slug passée en parametre 
    	$this->assertEquals('design',$client->getRequest()->attributes->get('slug')) ;
    	// test de la route
    	$this->assertEquals('category_show', $client->getRequest()->attributes->get('_route'));
    	// test de la reponse 
    	$this->assertTrue(200 === $client->getResponse()->getStatusCode());
    	// test de templates retournée 
    	 $this->assertTrue($crawler->filter('.category h1:contains('.$slug.')')->count() == 1);


    	 //test parameter in services 
    	// $container = self::$container;
    	// $max_jobs_on_homepage = $container->getParameter('max_jobs_on_homepage');
		//$this->assertTrue($crawler->filter('.category_programming tr')->count());*/
    }
}
