<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DocumentController extends AbstractController
{
    /**
     * @Route("/profil/eleve/1/documents", name="document_childrenDoc")
     */
    public function childrenDoc()
    {
        return $this->render('document/childrenDoc.html.twig', [
            'controller_name' => 'DocumentController',
        ]);
    }
}
