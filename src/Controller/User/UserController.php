<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Entity\Document;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UserController extends AbstractController
{
    /**
     * @Route("/profil", name="user_index")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Document::class);
        $documents = $repository->findAllDocWithStudentIdNull(); 

        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();
        
        return $this->render('user/index.html.twig', [        
        'documents' => $documents,
        'user' => $users
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