<?php

namespace App\Controller\Backend;

use App\Entity\Person;
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
        $persons = $repository->findAll(); 

        return $this->render('/backend/person/index.html.twig', [
            'persons' => $persons
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request)
    {
        $persons = new Person();
        $form = $this->createForm(PersonType::class, $persons);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($persons);
            $entityManager->flush();

            return $this->redirectToRoute('admin_person_index');
        }

        return $this->render('backend/person/new.html.twig', [
            'form' => $form->createView(),
            'person' => $persons,
        ]);
    }

    /**
     * @Route("/show/{id}", name="show", requirements={"id"="\d+"})
     */
    public function show(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Person::class);
        $persons = $repository->find($id);

        return $this->render('/backend/person/show.html.twig', [
            'persons' => $persons                    
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit", requirements={"id"="\d+"})
     */
    public function edit(Request $request, Person $person)
    {
        $form = $this->createForm(RoleType::class, $roles);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_person_show', [
                'id' => $person->getId(),
            ]);
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

