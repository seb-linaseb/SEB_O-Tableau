<?php

namespace App\Controller\Backend;

use App\Entity\Role;
use App\Form\RoleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



/**
 * @Route("/profil/admin/role", name="admin_role_")
 */
class RoleController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Role::class);
        $roles = $repository->findAll(); 

        return $this->render('/backend/role/index.html.twig', [
            'roles' => $roles
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request)
    {
        $roles = new Role();
        $form = $this->createForm(RoleType::class, $roles);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($roles);
            $entityManager->flush();

            return $this->redirectToRoute('admin_role_index');
        }

        return $this->render('backend/role/new.html.twig', [
            'form' => $form->createView(),
            'roles' => $roles,
        ]);
    }



    /**
     * @Route("/edit/{id}", name="edit", requirements={"id"="\d+"})
     */
    public function edit(Request $request, Role $roles)
    {
        $form = $this->createForm(RoleType::class, $roles);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_role_show', [
                'id' => $roles->getId(),
            ]);
        }
        
        return $this->render('backend/role/edit.html.twig', [
            'roles' => $roles,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request, Role $roles)
    {
        if ($this->isCsrfTokenValid('delete'.$roles->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($roles);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_role_index');
    }
}
