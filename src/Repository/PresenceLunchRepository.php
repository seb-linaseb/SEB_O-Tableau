<?php

namespace App\Repository;

use App\Entity\PresenceLunch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PresenceLunch|null find($id, $lockMode = null, $lockVersion = null)
 * @method PresenceLunch|null findOneBy(array $criteria, array $orderBy = null)
 * @method PresenceLunch[]    findAll()
 * @method PresenceLunch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PresenceLunchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PresenceLunch::class);
    }

    // /**
    //  * @return PresenceLunch[] Returns an array of HasStatus objects
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

    /**
     * 
     *  @return PresenceLunch[] Returns an array of PresenceLunch
     */
    public function findThisPresenceLunch($dateOfDay, $studentId)
    {
        $query = $this->getEntityManager()->createQuery('
            SELECT p
            FROM App\Entity\PresenceLunch p
            WHERE (p.calendar = :dateOfDay)
            AND (p.student = :studentId)
            
        ')
        ->setParameters(array(
                     'dateOfDay' => $dateOfDay,
                     'studentId' => $studentId));

                     
        return $query->getResult(); 

    }

    /*
    public function findOneBySomeField($value): ?PresenceLunch
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
