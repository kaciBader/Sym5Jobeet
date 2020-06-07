<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\JobRepository;

/**
* @Route("/Category")
*/
class CategoryController extends AbstractController
{
   

    /**
    * @Route("/{slug}", name ="category_show")
    */
    public function show($slug, CategoryRepository $categoryRepository, JobRepository $jobRepository)
    {
    	
 
	    $category = $categoryRepository->findOneBySlug($slug);
	 
	    if (!$category) {
	        throw $this->createNotFoundException('Unable to find Category entity.');
	    }
	 
	    $category->setActiveJobs($jobRepository->getActiveJobs($category->getId()));
	 
	    return $this->render('category/show.html.twig', [
	        'category' => $category
	    ]);
    }
}
