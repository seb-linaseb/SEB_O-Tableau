<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminCanteenController extends AbstractController
{
    /**
     * @Route("/admin/canteen", name="admin_canteen")
     */
    public function index()
    {
        return $this->render('admin_canteen/index.html.twig', [
            'controller_name' => 'AdminCanteenController',
        ]);
    }
}
