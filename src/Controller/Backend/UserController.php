<?php

namespace App\Controller\Backend;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Document;
use App\Form\DocumentType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("/profil/admin/user", name="admin_user_")
 */
class UserController extends AbstractController
{
    
    /**
     * @Route(name="index")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findall();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);     

        if ($form->isSubmitted() && $form->isValid()) {   
            
        $encodedPassword = $encoder->encodePassword($user, $user->getPassword());           
        $user->setPassword($encodedPassword);                              
       
        $entityManager = $this->getDoctrine()->getManager();            
        $entityManager->persist($user);      
        $entityManager->flush();
        return $this->redirectToRoute('admin_user_index');    
        }

        return $this->render('backend/user/index.html.twig', [
            'users' => $users,
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->find($id);

        return $this->render('backend/user/show.html.twig', [
            'user' => $user                   
        ]);
    }

    /**
     * @Route("/update/{id}", name="update", requirements={"id"="\d+"})
     */
    public function update(Request $request, $id, User $user, UserPasswordEncoderInterface $encoder)
    {     
        $repository = $this->getDoctrine()->getRepository(User::class);
        $userid = $repository->find($id);  

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {   
            
            $encodedPassword = $encoder->encodePassword($user, $user->getPassword());           
            $user->setPassword($encodedPassword);  
                   
        $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('backend/user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request, $id, ObjectManager $manager)
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->find($id);           

        $manager->remove($user);
        $manager->flush();       
     
        return $this->redirectToRoute('admin_user_index');

        return $this->render('backend/user/show.html.twig', [
            'user' => $user
        ]);
    }
}