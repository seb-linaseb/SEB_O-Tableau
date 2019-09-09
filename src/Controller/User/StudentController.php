<?php

namespace App\Controller\User;

use App\Entity\Student;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StudentController extends AbstractController
{
    /**    
     * @Route("/profil/eleve/{id}/", name="student_index", requirements={"id"="\d+"})
     */
    public function indedx(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Student::class);        
        $student = $repository->find($id);        
      
        return $this->render('student/index.html.twig', [
            'student' => $student,            
        ]);
    }
}