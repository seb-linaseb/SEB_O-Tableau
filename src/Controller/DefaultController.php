<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default_index")
     */
    public function index(/* Request $request, $name, \Swift_Mailer $mailer */)
    {

        // $message = (new \Swift_Message('Bienvenue'))
        // ->setFrom('kain.mrda@gmail.com')
        // ->setTo('kaka@gmail.com')
        // ->setBody(
        //     $this->renderView(
        //         // templates/emails/registration.html.twig
        //         'emails/registration.html.twig',
        //         ['name' => $name]
        //     ),
        //     'text/html'
        //   )
        // ;

        // $mailer->send($message);


        // $form = $this->createForm(ContactType::class);
        // $form->handleRequest($request);
        
        // if ($form->isSubmitted() && $form->isValid()) {
        //     $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->persist();
        //     $entityManager->flush();

        //     return $this->redirectToRoute('default_index');
        // }

        return $this->render('default/index.html.twig', [
            // 'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/mentions-legales", name="default_legalMention")
     */
    public function legalMention()
    {
        return $this->render('default/legal.html.twig', [
            
        ]);
    }

    /**
     * @Route("/reglement-interieur", name="default_reglement")
     */
    public function reglement()
    {
        return $this->render('default/reglement.html.twig', [
            
        ]);
    }

    
}
