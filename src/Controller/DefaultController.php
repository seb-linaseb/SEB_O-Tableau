<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default_index")
     */
    public function index()
    {
        return $this->render('default/index.html.twig', [
            
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
