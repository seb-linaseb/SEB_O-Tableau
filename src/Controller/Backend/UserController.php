<?php

namespace App\Controller\Backend;

use App\Entity\Document;
use App\Form\DocumentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UserController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Document::class);
        $documents = $repository->findAll(); 
        $document = new Document();       
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        $file = $document->getDocumentUrl();
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->getParameter('upload_directory'), $fileName);
        $document->setDocumentUrl($fileName);
        $entityManager = $this->getDoctrine()->getManager();            
        $entityManager->persist($document);      
        $entityManager->flush();

        return $this->redirectToRoute('profil');
        } 
        return $this->render('user/profil.html.twig', [
        'form' => $form->createView(),
        'documents' => $documents 
        ]);
    }
    
}