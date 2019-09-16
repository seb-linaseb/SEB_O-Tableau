<?php

namespace App\Controller\Backend;

use App\Entity\Alert;
use App\Form\AlertType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AlertController extends AbstractController
{
    /**
     * @Route("/profil/admin/alert", name="alert_index")
     */
    public function index(Request $request)
    {
        $alert = new Alert();
        $repository = $this->getDoctrine()->getRepository(Alert::class);
        $alerts = $repository->findall();

        $form = $this->createForm(AlertType::class, $alert);
        $form->handleRequest($request);     

        if ($form->isSubmitted() && $form->isValid()) {
        
        $user = $this->getUser();     
        $alert->setUser($user);  
        $entityManager = $this->getDoctrine()->getManager();            
        $entityManager->persist($alert);      
        $entityManager->flush();
        return $this->redirectToRoute('alert_index');    
        }

        return $this->render('/backend/alert/index.html.twig', [
            'alerts' => $alerts,
            'form' => $form->createView()
        ]);
    }

    /**    
     * @Route("/profil/admin/alert/show/{id}", name="alert_show", requirements={"id"="\d+"})
     */
    public function show(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Alert::class);
        $alert = $repository->find($id);

        return $this->render('/backend/alert/show.html.twig', [
            "alert" => $alert                     
        ]);
    }

    /**    
     * @Route("/profil/admin/alert/show/{id}/update", name="alert_update", requirements={"id"="\d+"})
     */
    public function update(Request $request, $id)
    {
        $alert = new Alert();

        $repository = $this->getDoctrine()->getRepository(Alert::class);
        $alertid = $repository->find($id);  

        $form = $this->createForm(AlertType::class, $alert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        $title = $form->get('title')->getData(); 
        $content = $form->get('content')->getData();        
        $alertid->setTitle($title);
        $alertid->setContent($content);            
        $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('alert_index');
        }

        return $this->render('/backend/alert/update.html.twig', [           
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profil/admin/alert/show/{id}/delete", name="alert_delete", requirements={"id"="\d+"})
     */
    public function delete(Request $request, $id, ObjectManager $manager)
    {
        $repository = $this->getDoctrine()->getRepository(Alert::class);
        $alert = $repository->find($id);           

        $manager->remove($alert);
        $manager->flush();       
     
        return $this->redirectToRoute('alert_index');

        return $this->render('/backend/alert/show.html.twig', [
        'alert' => $alert      
        ]);
    }   
    
}
