<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Entity\Alert;
use App\Form\UserType;
use App\Entity\Document;
use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UserController extends AbstractController
{
    /**
     * @Route("/profil", name="user_index")
     */
    public function index(ClassroomRepository $classroomrepository)
    {
        $repository = $this->getDoctrine()->getRepository(Document::class);
        $documents = $repository->findAllDocWithStudentIdNull();
               
        $repository = $this->getDoctrine()->getRepository(Alert::class);
        $alerts = $repository->findLastAlert();

        return $this->render('user/index.html.twig', [        
        'documents' => $documents,
        'alerts' => $alerts
        ]);
    }     

    /**
     * @Route("/profil/mon-compte", name="user_myAccount")
     */
    public function myAccount()
    {
        return $this->render('user/account.html.twig', [
            
        ]);
    }

    /**
     * @Route("/profil/mon-compte/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user)
    {

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_myAccount');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
    
}