<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Entity\Document;
use App\Entity\Classroom;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ClassroomRepository;


class UserController extends AbstractController
{
    /**
     * @Route("/profil", name="user_index")
     */
    public function index(ClassroomRepository $classroomrepository)
    {
        $repository = $this->getDoctrine()->getRepository(Document::class);
        $documents = $repository->findAllDocWithStudentIdNull(); 

        return $this->render('user/index.html.twig', [        
        'documents' => $documents,
        ]);
    }     

    /**
     * @Route("/profil/mon-compte", name="user_myAccount")
     */
    public function myAccount()
    {
        return $this->render('user/account.html.twig', [
            
        ]);
    }
    
}