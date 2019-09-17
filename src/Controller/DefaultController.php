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
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();

            $message = (new \Swift_Message('O\'Tableau - Vous avez un message'))               
            ->setFrom(["sirius@gmail.com" => $contactFormData['Nom']] )
            ->setReplyto([$contactFormData['Adresse-mail']] )
            ->setTo('otableau.sirius@gmail.com')
            ->setBody(        
                $contactFormData['content'],
                'text/plain'                
            )
           ;

           $mailer->send($message);

           return $this->redirectToRoute('default_index');
        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
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
