<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Entity\Message;
use App\Form\MessageType;
use App\Entity\Conversation;
use App\Entity\MessageStatus;
use App\Form\ConversationType;
use App\Repository\UserRepository;
use App\Repository\ClassroomRepository;
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
    public function new(Request $request, ConversationRepository $conversationRepository, UserRepository $userRepository, ClassroomRepository $classroomRepository)
    {
        $receiverList = [];

        //affichage des directeurs => pour tous
        $directors = $userRepository->findAllDirector(3);
        foreach ($directors as $director){
            $receiverList[] = $director;
        }
        //affichage des enseignants de mes enfants => pour les parents
        $enfants = $this->getUser()->getStudents();
        foreach ($enfants as $enfant){
            $enseignantId = $enfant->getClassroom()->getUser();
            //dump($enseignantId);
            $receiverList[]= $enseignantId;           
        }

        // affichage de la liste des parents de ma classe => pour les enseignants
        if ($this->getUser()->getRole()->getId() == 4){
            //$maclasse = $this->getUser()->getClassroom();
            $classes = $classroomRepository->findAll();
            foreach ($classes as $class){
                if ($this->getUser() == $class->getUser()){
                    $toto = $class->getStudents();
                    foreach($toto as $etudiant){
                        $parents = $etudiant->getUser();
                        foreach($parents as $parent){
                            $parent->getName();
                            $receiverList[] = $parent;
                        }
                    }   
                }
            }
        } 
        
        //affichage de la liste de tous le monde => pour les directeurs
        if ($this->getUser()->getRole()->getId() == 3){
            $everybody = $userRepository->findAll();
            foreach ($everybody as $person){
                $receiverList [] = $person;
            }
        }
        //affichage de la liste des parents de la classe dont je suis l'élu
        //TODO
        //Ne pas m'afficher moi-même
        foreach ($receiverList as $key=>$user) {
            //je veux me chercher dans le tableau si j'y suis
            if ($user == $this->getUser()){
                //je me trouve dans le tableau
                $key = array_search($user, $receiverList);
                //je me retire du tableau
                unset($receiverList[$key]);
            }
        }



        $message = new Message();

        $form = $this->createForm(MessageType::class, $message, array('receiverList'=> $receiverList));
    
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
        //$conversation->setNewMessage(false);
        
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
        
        $okToShow = [];
        $messages = $conversation->getMessages();
        //$okToShow [] = $messages;
        foreach ($messages as $key => $message) {
            $messageRemoves = $message->getMessageStatuses();
            $okToShow[] = $message;
            //dump($messageRemoves);

            foreach ($messageRemoves as $key => $messageRemove) {
                $userRemove = $messageRemove->getUser();
                $user = $this->getUser();
                //dump($userRemove);
                if ($userRemove == $user) {
                    $okToRemove = $messageRemove->getMessage();
                    $key = array_search($okToRemove, $okToShow);
                    //je me retire du tableau
                    unset($okToShow[$key]);
                    //dump($okToRemove);
                }
            }


        }
        //dump($okToShow);
        //die;

        return $this->render('conversation/show.html.twig', [
            'conversation' => $conversation,
            'okToShow' =>$okToShow,
            'formMessage' => $form->createView()
        ]);
    }


    /**
    * @Route("{id}/delete", name="delete", methods={"POST","GET"}, requirements={"id"="\d+"})
    */
    public function delete($id, Conversation $conv, EntityManagerInterface $em)
    {
        $messages = $conv->getMessages();
        $user = $this->getUser();
        //dump($messages);
        foreach ($messages as $key => $message) {
            $delete = new MessageStatus();
            $delete->setMessage($message);
            $delete->setUser($user);
            $delete->setRemove(true);
            $em->persist($delete);
            dump($delete);
        }
        //die;

        $em->flush();

        $this->addFlash(
            'danger',
            'Suppression effectuée'
        );
        
        return $this->redirectToRoute('conversation_show', ['id'=> $conv->getId()]);
    }
    
    // /**
    // * @Route("{id}/delete", name="delete", methods={"POST","GET"}, requirements={"id"="\d+"})
    // */
    // public function delete($id, Conversation $conv, EntityManagerInterface $em)
    // {
    //     $em->remove($conv);
    //     $em->flush();

    //     $this->addFlash(
    //         'danger',
    //         'Suppression effectuée'
    //     );
        
    //     return $this->redirectToRoute('conversation_index');
    // }


    
}



