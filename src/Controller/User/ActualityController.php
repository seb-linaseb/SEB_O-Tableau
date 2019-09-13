<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ActualityController extends AbstractController
{
    /**
     * @Route("/actu", name="actuality_index")
     */
    public function index()
    {
        return $this->render('actuality/index.html.twig', [
            
        ]);
    }


    /**
     * @Route("/actu/show/1", name="actuality_show")
     */
    public function show()
    {
        return $this->render('actuality/show.html.twig', [
            
        ]);
    }
}