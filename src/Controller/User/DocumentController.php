<?php

namespace App\Controller\User;

use App\Entity\Document;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DocumentController extends AbstractController
{
    /**    
     * @Route("/profil/eleve/{id}/documents", name="document_childrenDoc", requirements={"id"="\d+"})
     */
    public function childrenDoc(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Document::class);
        $doc = $repository->find($id);
      
        return $this->render('document/childrenDoc.html.twig', [
            'doc' => $doc
        ]);
    }
}
