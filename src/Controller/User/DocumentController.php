<?php

namespace App\Controller\User;

use App\Entity\Student;
use App\Entity\Document;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DocumentController extends AbstractController
{
    /**    
     * @Route("/profil/eleve/{id}/documents", name="document_childrenDoc", requirements={"id"="\d+"})
     */
    public function childrenDoc(Request $request, $id)
    {
           
        $repository = $this->getDoctrine()->getRepository(Document::class);
        $documents = $repository->find($id);       

        $repositorystudent = $this->getDoctrine()->getRepository(Student::class);
        $student = $repositorystudent->find($id);
      
        return $this->render('document/childrenDoc.html.twig', [            
            'student' => $student, 
            'documents' => $documents        
        ]);
    }
}
