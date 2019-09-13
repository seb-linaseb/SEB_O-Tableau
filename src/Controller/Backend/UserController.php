<?php

namespace App\Controller\Backend;

use App\Entity\Document;
use App\Form\DocumentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/profil/admin/user", name="admin_user_")
 */
class UserController extends AbstractController
{
    
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('backend/index.html.twig', [
            
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new()
    {
        return $this->render('backend/user/index.html.twig', [
            
        ]);
    }

    /**
     * @Route("/show/{id}", name="show", requirements={"id"="\d+"})
     */
    public function show()
    {
        return $this->render('backend/user/show.html.twig', [
            
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit, requirements={"id"="\d+"})
     */
    public function edit()
    {
        return $this->render('backend/user/edit.html.twig', [
            
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete()
    {
        return $this->redirectToRoute('admin_user_index');
    }
}