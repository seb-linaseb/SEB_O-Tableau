<?php

namespace App\DataFixtures;

use App\Entity\User as User;
use App\Entity\Role as Role;
use App\Entity\LunchType as LunchType;
use App\DataFixtures\MyCustomNativeLoader;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
      $this->encoder = $encoder;   
         
    }
    
    public function load(ObjectManager $em)
    {
       
        $loader = new MyCustomNativeLoader();
        
        //importe le fichier de fixtures et récupère les entités générés
        $entities = $loader->loadFile(__DIR__.'/fixtures.yml')->getObjects();
        
        //empile la liste d'objet à enregistrer en BDD
        foreach ($entities as $entity) {
            
            
            if ($entity instanceof Role){
                if ($entity->getCode() == 'ROLE_ADMIN'){
                    $entity->setName('administrateur');
                }elseif ($entity->getCode() == 'ROLE_PROF'){
                    $entity->setName('enseignant');
                }elseif ($entity->getCode() == 'ROLE_ELU'){
                    $entity->setName('parent-elu');
                }else{
                    $entity->setName('parent');
                }
                
            }

            if ($entity instanceof LunchType){
                if ($entity->getCode() == 'NC'){
                    $entity->setName('non-concerne');
                }elseif ($entity->getCode() == 'NORMAL'){
                    $entity->setName('normal');
                }elseif ($entity->getCode() == 'SP'){
                    $entity->setName('sans-porc');
                }else{
                    $entity->setName('regime-special');
                }
                
            }
            
            // if ($entityClass =  '/^user_.*/'){
            if ($entity instanceof User){
                
                $encodedPassword = $this->encoder->encodePassword($entity, $entity->getPassword()); 
                $new = $entity->setPassword($encodedPassword);
                    
            }

            // dump($entity);
            // die;

            $em->persist($entity);
        };

        $em->flush();
        
    }
}