<?php

namespace App\Repository;

use App\Entity\CategoryAffiliate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoryAffiliate|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryAffiliate|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryAffiliate[]    findAll()
 * @method CategoryAffiliate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryAffiliateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryAffiliate::class);
    }

    // /**
    //  * @return CategoryAffiliate[] Returns an array of CategoryAffiliate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategoryAffiliate
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
