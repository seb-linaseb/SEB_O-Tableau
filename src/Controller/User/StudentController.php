<?php

namespace App\Controller\User;

use App\Entity\Student;
use App\Entity\Document;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StudentController extends AbstractController
{
    /**    
     * @Route("/profil/eleve/{id}/", name="student_index", requirements={"id"="\d+"})
     */
    public function index(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Student::class);
        $student = $repository->find($id);   
              
        $repositorydoc = $this->getDoctrine()->getRepository(Document::class);
        $documents = $repositorydoc->find($id); 

        $bulletins = $repositorydoc->findNoteByStudent($id);
        
        return $this->render('student/index.html.twig', [
            'student' => $student,         
            'bulletins' => $bulletins,
            'documents' => $documents          
        ]);
    }
}