<?php

namespace App\Controller\Backend;

use App\Entity\Student;
use App\Form\StudentType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/profil/admin/student", name="admin_student_")
 */
class StudentController extends AbstractController
{
    /**
     * @Route(name="index")
     */
    public function index(Request $request)
    {
        $student = new Student();
        $repository = $this->getDoctrine()->getRepository(Student::class);
        $students = $repository->findall();

        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);     

        if ($form->isSubmitted() && $form->isValid()) {        
       
        $entityManager = $this->getDoctrine()->getManager();            
        $entityManager->persist($student);      
        $entityManager->flush();
        return $this->redirectToRoute('admin_canteen_create', ['id'=> $student->getId()]);    
        }

        return $this->render('backend/student/index.html.twig', [
            'students' => $students,
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Student::class);
        $student = $repository->find($id);

        return $this->render('backend/student/show.html.twig', [
            'student' => $student                     
        ]);
    }

    /**
     * @Route("/update/{id}", name="update", requirements={"id"="\d+"})
     */
    public function update(Request $request, $id, Student $student)
    {     
        $repository = $this->getDoctrine()->getRepository(Student::class);
        $studentid = $repository->find($id);  

        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {             
                   
        $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_student_show', ['id'=> $id]);
        }

        return $this->render('backend/student/edit.html.twig', [
            'form' => $form->createView(),
            'student' => $student
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request, $id, ObjectManager $manager)
    {
        $repository = $this->getDoctrine()->getRepository(Student::class);
        $student = $repository->find($id);           

        $manager->remove($student);
        $manager->flush();       
     
        return $this->redirectToRoute('admin_student_index');

        return $this->render('backend/student/show.html.twig', [
            'student' => $student
        ]);
    }
}