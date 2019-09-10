<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Entity\Message;
use App\Form\MessageType;
use App\Entity\Conversation;
use App\Form\ConversationType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ConversationRepository;
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
    public function new(Request $request, ConversationRepository $conversationRepository)
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();
            $message->setUserPost($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);

            foreach ($message->getUsers() as $eachUser) {

               $conversation = $conversationRepository->findThisConversation($user->getId(), $eachUser->getId()); 

             if (!empty($conversation)){
                 $conversation[0]->addMessage($message);

             } else { 
                
                 $conversation = new Conversation();
                 $conversation->setUserParticipate($user);
                 $conversation->setUserConsult($eachUser);
                 $entityManager->persist($conversation);
                 $message->addConversation($conversation);
             }
        }
                       
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Message envoyé'
            );
            
            $nbMessage = count($message->getUsers());
            

            if ($nbMessage > 1){
                return $this->redirectToRoute('conversation_index') ;

            } else {
                $conversation = $message->getConversation();
                $thisConversation = $conversation[0];
                dump($thisConversation->getId());
                return $this->redirectToRoute('conversation_show',['id'=> $thisConversation->getId()]) ;
            }    
        }

        return $this->render('conversation/new.html.twig', [
            'formMessage' => $form->createView(),
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



    
    /**
    * @Route("{id}/delete", name="delete", methods={"POST","GET"}, requirements={"id"="\d+"})
    */
    public function delete($id, Conversation $conv, EntityManagerInterface $em)
    {
        $em->remove($conv);
        $em->flush();

        $this->addFlash(
            'danger',
            'Suppression effectuée'
        );
        
        return $this->redirectToRoute('conversation_index');
    }


    
}



