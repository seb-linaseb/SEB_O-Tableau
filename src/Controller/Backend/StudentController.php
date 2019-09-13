<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/profil/admin/student", name="admin_student_")
 */
class StudentController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('backend/student/index.html.twig', [
            
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new()
    {
        return $this->render('backend/student/index.html.twig', [
            
        ]);
    }

    /**
     * @Route("/show/{id}", name="show", requirements={"id"="\d+"})
     */
    public function show()
    {
        return $this->render('backend/student/show.html.twig', [
            
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit", requirements={"id"="\d+"})
     */
    public function edit()
    {
        return $this->render('backend/student/edit.html.twig', [
            
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete()
    {
        return $this->redirectToRoute('admin_student_index');
    }
}