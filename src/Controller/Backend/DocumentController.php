<?php

namespace App\Controller\Backend;

use App\Entity\Document;
use App\Form\DocumentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DocumentController extends AbstractController
{
      /**
     * @Route("/profil/admin/document", name="document_index")
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

        return $this->redirectToRoute('document_index');
        } 
        return $this->render('backend/document/index.html.twig', [
        'form' => $form->createView(),   
        'documents' => $documents      
        ]);
    }

    /**
     * @Route("/profil/admin/document/{id}", name="document_show", requirements={"id"="\d+"})
     */
    public function show(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Document::class);
        $doc = $repository->find($id);

        return $this->render('backend/document/show.html.twig', [
        'doc' => $doc        
        ]);
    }   

    /**
     * @Route("/profil/admin/document/{id}/delete", name="document_delete", requirements={"id"="\d+"})
     */
    public function delete(Document $document, Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Document::class);
        $doc = $repository->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($document);
        $entityManager->flush();

        return $this->redirectToRoute('document_index');

        return $this->render('backend/document/show.html.twig', [
        'doc' => $doc        
        ]);
    }   
}
