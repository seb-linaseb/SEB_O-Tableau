<?php

namespace App\DataFixtures;

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
            
            $em->persist($entity);

            if ($entity->getCode() == 'ROLE_ADMIN'){
                $entity->setName('administrateur');
            }elseif ($entity->getCode() == 'ROLE_PROF'){
                $entity->setName('enseignant');
            }elseif ($entity->getCode() == 'ROLE_ELU'){
                $entity->setName('parent elu');
            }else{
                $entity->setName('parent');
            }

            $em->persist($entity);

            // dump($entity->getCode());
            // dump($entity->getName());
            // die;
            
        };


    
        $em->flush();
        
    }
}