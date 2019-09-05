<?php

namespace App\Repository;

use App\Entity\LunchType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LunchType|null find($id, $lockMode = null, $lockVersion = null)
 * @method LunchType|null findOneBy(array $criteria, array $orderBy = null)
 * @method LunchType[]    findAll()
 * @method LunchType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LunchTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LunchType::class);
    }

    // /**
    //  * @return LunchType[] Returns an array of LunchType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LunchType
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
