<?php

namespace App\Repository;

use App\Entity\Job;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Job|null find($id, $lockMode = null, $lockVersion = null)
 * @method Job|null findOneBy(array $criteria, array $orderBy = null)
 * @method Job[]    findAll()
 * @method Job[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Job::class);
    }

    // /**
    //  * @return Job[] Returns an array of Job objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Job
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
    * @param int category_id
    *
    * @return Job[] Returns an array of Job objects
    */
    public function getActiveJobs($category_id = null, $max_jobs = null)
    {
        $qb = $this->createQueryBuilder('j')
                   -> where('j.expires_at > :date')
                   ->setParameter('date', date('Y-m-d H:i:s', time()))
                   ->orderBy('j.expires_at','DESC');
        if($max_jobs)
            $qb->setMaxResults($max_jobs);

        if($category_id)
        {
            $qb->andWhere('j.category =:category_id')
               ->setParameter('category_id',$category_id);
        }
        $query  = $qb->getQuery();
        $result  = $query->getResult();
        return $result ;
    }

    public function getActiveJob($id)
    {
          $query = $this->createQueryBuilder('j')
            ->where('j.id = :id')
            ->setParameter('id', $id)
            ->andWhere('j.expires_at > :date')
            ->setParameter('date', date('Y-m-d H:i:s', time()))
            ->setMaxResults(1)
            ->getQuery();
         
          try {
            $job = $query->getSingleResult();
          } catch (\Doctrine\Orm\NoResultException $e) {
            $job = null;
          }
         
          return $job;
    }
}
