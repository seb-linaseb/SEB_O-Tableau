<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Entity\Conversation;
use App\Form\ConversationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/conversation", name="conversation_")
 */
class ConversationController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {

        $repository = $this->getDoctrine()->getRepository(Conversation::class);
        $conv = $repository->findAll();
        
        return $this->render('message/index.html.twig', [
            'conv' => $conv
        ]);
    }


    /**
     * @Route("/show", name="show")
     */
    public function show()
    {
        return $this->render('message/show.html.twig', [
            
        ]);
    }


      /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request)
    {
        $conv = new Conversation();
        $form = $this->createForm(ConversationType::class, $conv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();
            $conv->setUserParticipate($user);
            $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->persist($conv);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Enregistrement effectué'
            );
            
            return $this->redirectToRoute('conversation_index');
        }

        return $this->render('message/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
