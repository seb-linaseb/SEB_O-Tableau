<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    /**
     * @Route("/profil", name="user_index")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            
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