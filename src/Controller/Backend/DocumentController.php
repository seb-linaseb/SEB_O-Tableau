<?php

namespace App\Controller\Backend;

use App\Entity\Student;
use App\Entity\Document;
use App\Entity\Classroom;
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
        $documents = $repository->findAllDocWithStudentIdNull(); 

        $repositoryclass = $this->getDoctrine()->getRepository(Classroom::class);
        $classrooms = $repositoryclass->findAll(); 

        $document = new Document();
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        $user = $this->getUser();     
        $document->setUser($user);
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
        'documents' => $documents,  
        'classrooms' => $classrooms
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
     * @Route("/profil/admin/document/classroom/{id}", name="document_classroom_show", requirements={"id"="\d+"})
     */
    public function showClassroom(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Classroom::class);
        $classroom = $repository->find($id);

        $repositorystudent = $this->getDoctrine()->getRepository(Student::class);
        $students = $repositorystudent->findAll();        

        return $this->render('backend/document/show_classroom.html.twig', [
        'classroom' => $classroom,
        'students' => $students        
        ]);
    }   

        /**
     * @Route("/profil/admin/document/classroom/{id}/eleve/{studentid}/documents", name="document_bystudent_show", requirements={"id"="\d+"})
     */
    public function showDocsByStudent(Request $request, $id, $studentid)
    {
        $repository = $this->getDoctrine()->getRepository(Document::class);
        $documents = $repository->find($id);       

        $repositorystudent = $this->getDoctrine()->getRepository(Student::class);
        $student = $repositorystudent->find($studentid);       

        return $this->render('backend/document/show_docsbystudent.html.twig', [
            'student' => $student, 
            'documents' => $documents        
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
