<?php

namespace App\Repository;

use App\Entity\Calendar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Calendar|null find($id, $lockMode = null, $lockVersion = null)
 * @method Calendar|null findOneBy(array $criteria, array $orderBy = null)
 * @method Calendar[]    findAll()
 * @method Calendar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalendarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Calendar::class);
    }

    // /**
    //  * @return Calendar[] Returns an array of Calendar objects
    //  */
    
    public function findByDate($dateOfDay)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.date = :val')
            ->setParameter('val', $dateOfDay)
            //->orderBy('c.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    
    // /**
    //  * @return Calendar[] Returns an array of Calendar objects
    //  */
    
    public function findByWeek($week_starting_day)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.date >= :val')
            ->setParameter('val', $week_starting_day)
            //->orderBy('c.id', 'ASC')
            ->setMaxResults(7)
            ->getQuery()
            ->getResult()
        ;
    }
    /*
    public function findOneBySomeField($value): ?Calendar
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
