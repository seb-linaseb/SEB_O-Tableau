<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    /**
     * @Route("/profil/eleve/1", name="student_index")
     */
    public function index()
    {
        return $this->render('student/index.html.twig', [
            
        ]);
    }
}