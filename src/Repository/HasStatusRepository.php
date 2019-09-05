<?php

namespace App\Repository;

use App\Entity\HasStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method HasStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method HasStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method HasStatus[]    findAll()
 * @method HasStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HasStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HasStatus::class);
    }

    // /**
    //  * @return HasStatus[] Returns an array of HasStatus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HasStatus
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
