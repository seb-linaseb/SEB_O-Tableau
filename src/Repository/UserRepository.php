<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function findAllDirector($role)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.role = :val')
            ->setParameter('val', $role)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneByEmail($email)
    {
        return $this->findOneBy(array('email' => $email));
    }
    
}
