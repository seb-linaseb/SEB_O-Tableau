<?php

namespace App\Controller\Backend;

use App\Entity\Classroom;
use App\Form\ClassroomType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/profil/admin/classroom", name="admin_classroom_")
 */
class ClassroomController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Classroom::class);
        $classrooms = $repository->findAll(); 

        return $this->render('/backend/classroom/index.html.twig', [
            'classrooms' => $classrooms
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request)
    {
        $classrooms = new Classroom();
        $form = $this->createForm(ClassroomType::class, $classrooms);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($classrooms);
            $entityManager->flush();

            return $this->redirectToRoute('admin_classroom_index');
        }

        return $this->render('backend/classroom/new.html.twig', [
            'form' => $form->createView(),
            'classrooms' => $classrooms,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit", requirements={"id"="\d+"})
     */
    public function edit(Request $request, Classroom $classroom)
    {
        $form = $this->createForm(ClassroomType::class, $classroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_classroom_index');
        }
        
        return $this->render('backend/classroom/edit.html.twig', [
            'classrooms' => $classroom,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request, Classroom $classroom)
    {
        if ($this->isCsrfTokenValid('delete'.$classroom->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($classroom);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_classroom_index');
    }
}
