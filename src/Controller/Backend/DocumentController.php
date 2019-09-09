<?php

namespace App\Controller\Backend;

use App\Entity\Document;
use App\Form\DocumentType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DocumentController extends AbstractController
{

    private $kernelRoot;

    public function __construct(string $kernelRoot)
    {
    $this->kernelRoot = $kernelRoot;
    }

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
    public function delete(Document $document, Request $request, $id, ObjectManager $manager)
    {
        $repository = $this->getDoctrine()->getRepository(Document::class);
        $doc = $repository->find($id);

        $filesystem = new Filesystem();
        $file = $document->getDocumentUrl();
        $path = $this->kernelRoot.'/public/docs/'.$file;
        $filesystem->remove($path);
        $manager->remove($document);
        $manager->flush();      

        return $this->redirectToRoute('document_index');

        return $this->render('backend/document/show.html.twig', [
        'doc' => $doc        
        ]);
    }   
}
