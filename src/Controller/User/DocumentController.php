<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Entity\Student;
use App\Entity\Document;
use App\Form\DocumentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DocumentController extends AbstractController
{
    /**    
     * @Route("/profil/eleve/{id}/documents", name="document_childrenDoc", requirements={"id"="\d+"})
     */
    public function show(Request $request, $id)
    {           
        $repository = $this->getDoctrine()->getRepository(Document::class);
        $documents = $repository->find($id);       
        
        $repositorystudent = $this->getDoctrine()->getRepository(Student::class);
        $student = $repositorystudent->find($id);        
      
        return $this->render('document/childrenDoc.html.twig', [            
            'student' => $student, 
            'documents' => $documents,                 
        ]);
    }

     /**    
     * @Route("/profil/eleve/{id}/documents/add", name="document_addchildrenDoc", requirements={"id"="\d+"})
     */
    public function addDocByParent(Request $request, $id)
    {
        $document = new Document();         
        $repositorystudent = $this->getDoctrine()->getRepository(Student::class);
        $student = $repositorystudent->find($id);       
        
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);     

        if ($form->isSubmitted() && $form->isValid()) {
        
        $user = $this->getUser();     
        $document->setUser($user);
        $document->setStudent($student);      
        $file = $document->getDocumentUrl();        
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->getParameter('upload_directory'), $fileName);
        $document->setDocumentUrl($fileName);
        $entityManager = $this->getDoctrine()->getManager();            
        $entityManager->persist($document);      
        $entityManager->flush();

        return $this->redirectToRoute('document_childrenDoc', ['id'=> $student->getId()]);
        } 
        return $this->render('document/form_add_childrenDoc.html.twig', [
        'form' => $form->createView(),
        ]);
    }
}
