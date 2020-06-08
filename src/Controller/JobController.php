<?php

namespace App\Controller;

use App\Entity\Job;
use App\Form\JobType;
use App\Repository\JobRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/job")
 */
class JobController extends AbstractController
{
    /**
     * @Route("/",
     *        name="job_index", 
     *        methods={"GET"}
     *  )
     */
    public function index(JobRepository $jobRepository, CategoryRepository $categoryRepository, PaginatorInterface $paginator, Request $request): Response
    {
     
        $categories = $categoryRepository->getWithJobs();
        foreach($categories as $category)
        {
            /* $category->setActiveJobs($jobRepository->getActiveJobs($category->getId(), $this->getParameter('max_jobs_on_homepage'))); */

            $query = $jobRepository->getActiveJobsQuery($category->getId());
            $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

            $category->setMoreJobs($jobRepository->countActiveJobs($category->getId()),$this->getParameter('max_jobs_on_homepage'));
        }
        return $this->render('job/index.html.twig', [
        'categories' => $categories,
        'pagination' => $pagination]);
        
    }

    /**
     * @Route("/new", 
     *         name="job_new", 
     *         methods={"GET","POST"}
     *  )
     */
    public function new(Request $request): Response
    {
        $job = new Job();
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($job);
            $entityManager->flush();

            return $this->redirectToRoute('job_index');
        }

        return $this->render('job/new.html.twig', [
            'job' => $job,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{company}/{location}/{id}/{position}", 
     *         name="job_show", 
     *         methods={"GET"},
     *         requirements={"id"="\d+"}
     *  )
     */
    public function show($id, JobRepository $jobRepository): Response
    {
        $job  =  $jobRepository->getActiveJob($id);
        if (!$job) {
        throw $this->createNotFoundException('Unable to find Job entity.');
        }
        // $deleteForm = $this->createDeleteForm($id);
        return $this->render('job/show.html.twig', [
            'job' => $job,
        ]);
    }

   /* public function show(Job $job): Response
    {
        return $this->render('job/show.html.twig', [
            'job' => $job,
        ]);
    }*/

    /**
     * @Route("/{id}/edit", 
     *          name="job_edit", 
     *          methods={"GET","POST"}
     *  )
     */
    public function edit(Request $request, Job $job): Response
    {
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('job_index');
        }

        return $this->render('job/edit.html.twig', [
            'job' => $job,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", 
     *          name="job_delete", 
     *          methods={"DELETE"}
     *  )
     */
    public function delete(Request $request, Job $job): Response
    {
        if ($this->isCsrfTokenValid('delete'.$job->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($job);
            $entityManager->flush();
        }

        return $this->redirectToRoute('job_index');
    }
}
