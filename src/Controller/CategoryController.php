<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\JobRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

/**
* @Route("/Category")
*/
class CategoryController extends AbstractController
{
    /**
    * @Route("/{slug}", name ="category_show")
    */
    public function show($slug, CategoryRepository $categoryRepository, JobRepository $jobRepository, PaginatorInterface $paginator, Request $request)
    {

	    $category = $categoryRepository->findOneBySlug($slug);
	 
	    if (!$category) {
	        throw $this->createNotFoundException('Unable to find Category entity.');
	    }

	    $query = $jobRepository->getActiveJobsQuery($category->getId());
    	$pagination = $paginator->paginate(
        	$query, /* query NOT result */
        	$request->query->getInt('page', 1), /*page number*/
        	10 /*limit per page*/
    	);

    // parameters to template
    return $this->render('category/show.html.twig', [
    	'category' => $category,
    	'pagination' => $pagination]);
    }
}
