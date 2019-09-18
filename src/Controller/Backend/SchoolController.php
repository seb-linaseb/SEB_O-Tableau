<?php

namespace App\Controller\Backend;

use App\Entity\School;
use App\Form\SchoolType;
use App\Repository\SchoolRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/profil/admin/school", name="admin_school_")
 */
class SchoolController extends AbstractController
{
    
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(School::class);
        $school = $repository->findAll(); 

        return $this->render('/backend/school/index.html.twig', [
            'school' => $school
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request)
    {
        $school = new School();
        $form = $this->createForm(SchoolType::class, $school);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($school);
            $entityManager->flush();

            return $this->redirectToRoute('admin_school_index');
        }

        return $this->render('backend/school/new.html.twig', [
            'form' => $form->createView(),
            'school' => $school,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit", requirements={"id"="\d+"})
     */
    public function edit(Request $request, School $school)
    {
        $form = $this->createForm(SchoolType::class, $school);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_school_index'
            );
        }
        
        return $this->render('backend/school/edit.html.twig', [
            'school' => $school,
            'form' => $form->createView(),
        ]);
    }
}
