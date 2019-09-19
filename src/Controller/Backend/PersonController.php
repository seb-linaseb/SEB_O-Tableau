<?php

namespace App\Controller\Backend;

use App\Entity\Person;
use App\Form\PersonType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/profil/admin/person", name="admin_person_")
*/
class PersonController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Person::class);
        $person = $repository->findAll(); 

        return $this->render('/backend/person/index.html.twig', [
            'person' => $person
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request)
    {
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($person);
            $entityManager->flush();

            return $this->redirectToRoute('admin_person_index');
        }

        return $this->render('backend/person/new.html.twig', [
            'form' => $form->createView(),
            'person' => $person,
        ]);
    }
    
    /**
     * @Route("/edit/{id}", name="edit", requirements={"id"="\d+"})
     */
    public function edit(Request $request, Person $person)
    {
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_person_index');
        }
        
        return $this->render('backend/person/edit.html.twig', [
            'person' => $person,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request, Person $person)
    {
        if ($this->isCsrfTokenValid('delete'.$person->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($person);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_person_index');
    }
}

