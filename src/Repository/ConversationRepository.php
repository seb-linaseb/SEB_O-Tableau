<?php

namespace App\Repository;

use App\Entity\Conversation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Conversation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conversation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conversation[]    findAll()
 * @method Conversation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conversation::class);
    }

     /**
     * EXO 1 : Récupérer la liste les films par ordre alphabétique
     * Méthode en DQL (Doctrine Query Language)
     * 
     *  @return Conversation[] Returns an array of Movie objects
     */
    public function findAllByOrder()
    {
        return $this->getEntityManager()
            ->createQuery('
                SELECT c 
                FROM App\Entity\Conversation c 
                ORDER BY c.id DESC
            ')
            ->getResult();
    }

    /**
     * 
     *  @return Conversation[] Returns an array of Movie objects
     */
    public function findThisConversation($expediteurId, $destinataireId)
    {
        $query = $this->getEntityManager()->createQuery('
            SELECT c
            FROM App\Entity\Conversation c
            WHERE (c.user_consult = :first or c.user_consult = :second)
            AND (c.user_participate = :first or c.user_participate = :second)
            
        ')
        ->setParameters(array(
                     'first' => $destinataireId,
                     'second' => $expediteurId));

                     
        return $query->getResult(); 

    }
}

