<?php

namespace App\Controller\User;

use App\Entity\Alert;
use App\Entity\Actuality;
use App\Form\ActualityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ActualityController extends AbstractController
{
    /**
     * @Route("/actu", name="actuality_index")
     */
    public function index(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Actuality::class);
        $news = $repository->findAllOrderedByDate(); 

        $repository = $this->getDoctrine()->getRepository(Alert::class);
        $alerts = $repository->findLastAlert();

        return $this->render('actuality/index.html.twig', [
            'news' => $news,       
            'alerts' => $alerts     
        ]);
    }

    /**    
     * @Route("/actu/show/{id}", name="actuality_show", requirements={"id"="\d+"})
     */
    public function show(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Actuality::class);
        $new = $repository->find($id);

        return $this->render('actuality/show.html.twig', [
            'new' => $new                     
        ]);
    }

    /**
     * @Route("/actu/add", name="actuality_add")
     */
    public function addActuality(Request $request)
    {
        $actuality = new Actuality();       
                    
        $form = $this->createForm(ActualityType::class, $actuality);
        $form->handleRequest($request);     

        if ($form->isSubmitted() && $form->isValid()) {
        
        $user = $this->getUser();     
        $actuality->setUser($user);         
        $file = $actuality->getPictureUrl();        
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->getParameter('upload_directory'), $fileName);
        $actuality->setPictureUrl($fileName);
        $entityManager = $this->getDoctrine()->getManager();            
        $entityManager->persist($actuality);      
        $entityManager->flush();

        return $this->redirectToRoute('actuality_index');
        }
        return $this->render('actuality/form_add_actu.html.twig', [
            'form' => $form->createView(),          
        ]);
    }

}