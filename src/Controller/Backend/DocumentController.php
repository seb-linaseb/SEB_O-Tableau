<?php

namespace App\Controller\Backend;

use App\Entity\Student;
use App\Entity\Document;
use App\Entity\Classroom;
use App\Form\DocumentType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/profil/admin")
 */
class DocumentController extends AbstractController
{

    private $kernelRoot;

    public function __construct(string $kernelRoot)
    {
    $this->kernelRoot = $kernelRoot;
    }

      /**
     * @Route("/document", name="document_index")
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
     * @Route("/documenteleve/{id}", name="documentStudent_show", requirements={"id"="\d+"})
     */
    public function showDocStudent(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Document::class);
        $doc = $repository->find($id);

        return $this->render('backend/document/show_doc_student.html.twig', [
        'doc' => $doc        
        ]);
    }   

    /**
     * @Route("/documentscolaire/{id}", name="documentSchool_show", requirements={"id"="\d+"})
     */
    public function showDocSchool(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Document::class);
        $doc = $repository->find($id);

        return $this->render('backend/document/show_doc_school.html.twig', [
        'doc' => $doc        
        ]);
    }   

    /**
     * @Route("/document/classroom/{id}", name="documentClassroom_show", requirements={"id"="\d+"})
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
     * @Route("/document/classroom/{id}/eleve/{studentid}/documents", name="documentByStudent_show", requirements={"id"="\d+"})
     */
    public function showDocsByStudent(Request $request, $id, $studentid)
    {              
        $repositoryclass = $this->getDoctrine()->getRepository(Classroom::class);
        $classroom = $repositoryclass->find($id); 

        $repositorystudent = $this->getDoctrine()->getRepository(Student::class);
        $student = $repositorystudent->find($studentid);
       
        return $this->render('backend/document/show_docsbystudent.html.twig', [
            'student' => $student, 
            'classroom' => $classroom        
        ]);
    }
    
    /**    
     * @Route("/document/classroom/{id}/eleve/{studentid}/documents/add", name="document_adminAddchildrenDoc", requirements={"id"="\d+"})
     */
    public function addDocStudent(Request $request, $id, $studentid)
    {
        $document = new Document();      
        
        $repositoryclass = $this->getDoctrine()->getRepository(Classroom::class);
        $classroom = $repositoryclass->find($id); 

        $repositorystudent = $this->getDoctrine()->getRepository(Student::class);
        $student = $repositorystudent->find($studentid);        
       
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

        return $this->redirectToRoute('documentByStudent_show', ['studentid'=> $student->getId(), 'id'=> $classroom->getId()]);
        } 
        return $this->render('document/form_add_childrenDoc.html.twig', [
        'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/documenteleve/{id}/delete", name="document_delete", requirements={"id"="\d+"})
     */
    public function deleteDocStudent(Document $document, Request $request, $id, ObjectManager $manager)
    {
        $repository = $this->getDoctrine()->getRepository(Document::class);
        $doc = $repository->find($id);              

        $repositorystudent = $this->getDoctrine()->getRepository(Student::class);
        $student = $repositorystudent->find($id);  
        $studentid = $document->getStudent($student); 
        $classroomid = $studentid->getClassroom();    
    
        $filesystem = new Filesystem();       
        $file = $document->getDocumentUrl();
        $path = $this->kernelRoot.'/public/docs/'.$file;
        $filesystem->remove($path);
        $manager->remove($document);
        $manager->flush();
        
        return $this->redirectToRoute('documentByStudent_show', ['studentid'=> $studentid->getId(), 'id'=> $classroomid->getId()]);

        return $this->render('backend/document/show.html.twig', [
        'doc' => $doc        
        ]);
    }   

    /**
     * @Route("/documentscolaire/{id}/delete", name="documentschool_delete", requirements={"id"="\d+"})
     */
    public function deleteDocSchool(Document $document, Request $request, $id, ObjectManager $manager)
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

        return $this->render('backend/document/show_doc_school.html.twig', [
        'doc' => $doc        
        ]);
    }   



    /**
     * @Route("/profil/admin/documenteleve/{id}/edit", name="document_edit", requirements={"id"="\d+"})
     */
    public function editDocStudent(Request $request, $id)
    {
        $document = new Document();      
        
        $repository = $this->getDoctrine()->getRepository(Document::class);
        $doc = $repository->find($id);    
                             
        $oldDoc = $doc->getDocumentUrl();               

        if(!empty($oldDoc)) {            
            $doc->getDocumentUrl(
                new File($this->getParameter('upload_directory').'/'.$oldDoc)
            );            
        }
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request); 
        
        if ($form->isSubmitted() && $form->isValid()) {

            if(!is_null($doc->getDocumentUrl())){
                $file = $form->get('document_url')->getData();
                $name = $form->get('name')->getData();              
                
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                
                    $file->move(
                        $this->getParameter('upload_directory'),
                        $fileName
                    );               
                
                $doc->setDocumentUrl($fileName);
                $doc->setName($name);  
                
                if(!empty($oldDoc)){
                    unlink(
                        $this->getParameter('upload_directory') .'/'.$oldDoc
                    );
                }
            } else {               
                $doc->setDocumentUrl($oldDoc);                             
            }

            $this->getDoctrine()->getManager()->flush();
                   
            return $this->redirectToRoute('documentStudent_show', ['id'=> $doc->getId()]);
            }               
        return $this->render('backend/document/edit.html.twig', [
            'form' => $form->createView(),
            ]);
    }  

    /**
     * @Route("/profil/admin/documentscolaire/{id}/edit", name="documentschool_edit", requirements={"id"="\d+"})
     */
    public function editDocSchool(Request $request, $id)
    {
        $document = new Document();       
        
        $repository = $this->getDoctrine()->getRepository(Document::class);
        $doc = $repository->find($id);    
                             
        $oldDoc = $doc->getDocumentUrl();

        if(!empty($oldDoc)) {
            $doc->getDocumentUrl(
                new File($this->getParameter('upload_directory').'/'.$oldDoc)
            );
        }

        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request); 
        
        if ($form->isSubmitted() && $form->isValid()) {

            if(!is_null($doc->getDocumentUrl())){
                $file = $form->get('document_url')->getData();
                $name = $form->get('name')->getData();
                
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                
                    $file->move(
                        $this->getParameter('upload_directory'),
                        $fileName
                    );           
                
                $doc->setDocumentUrl($fileName);
                $doc->setName($name);

                if(!empty($oldDoc)){
                    unlink(
                        $this->getParameter('upload_directory') .'/'.$oldDoc
                    );
                }
            } else {                
                $doc->setDocumentUrl($oldDoc);
            }

            $this->getDoctrine()->getManager()->flush();
          
            return $this->redirectToRoute('documentSchool_show', ['id'=> $doc->getId()]);
            }               
        return $this->render('backend/document/edit.html.twig', [
            'form' => $form->createView(),
            ]);
    }    
}
