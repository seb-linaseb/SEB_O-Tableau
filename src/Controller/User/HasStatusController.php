<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HasStatusController extends AbstractController
{
    /**
     * @Route("/has_status", name="has_status")
     */
    public function index()
    {
        return $this->render('has_status/index.html.twig', [
            'controller_name' => 'HasStatusController',
        ]);
    }
}