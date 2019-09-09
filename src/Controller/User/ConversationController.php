<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Entity\Message;
use App\Entity\Conversation;
use App\Form\MessageType;
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
        $conv = $repository->findAllByOrder();
        
        return $this->render('conversation/index.html.twig', [
            'conv' => $conv
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
            
            return $this->redirectToRoute('conversation_show', ['id'=> $conv->getId()]);
        }

        return $this->render('conversation/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="show", methods={"GET","POST"}), requirements={"id"="\d+"})
     */
    public function show(Conversation $conversation, Request $request)
    {
        
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();
            $message->setUserPost($user);
            $message->addConversation($conversation);
            $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->persist($message);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Enregistrement effectué'
            );
            
            return $this->redirectToRoute('conversation_show', ['id'=> $conversation->getId()]);
        }

        return $this->render('conversation/show.html.twig', [
            'conversation' => $conversation,
            'formMessage' => $form->createView()
        ]);
    }


    
}
