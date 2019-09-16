<?php

namespace App\Controller\Backend;

use App\Entity\Alert;
use App\Entity\Actuality;
use App\Form\ActualityType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ActualityController extends AbstractController
{
    /**
     * @Route("/profil/admin/actuality", name="actualityadmin_index", methods={"GET","POST"})
     */
    public function index(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Actuality::class);
        $actualitys = $repository->findAll(); 

        return $this->render('/backend/actuality/index.html.twig', [
            'actualitys' => $actualitys
        ]);
    }

    /**    
     * @Route("/profil/admin/actuality/show/{id}", name="actualityadmin_show", requirements={"id"="\d+"})
     */
    public function show(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Actuality::class);
        $actuality = $repository->find($id);

        return $this->render('/backend/actuality/show.html.twig', [
            'actuality' => $actuality                    
        ]);
    }

    /**
     * @Route("/profil/admin/actuality/show/{id}/delete", name="actualityadmin_delete", requirements={"id"="\d+"})
     */
    public function delete(Request $request, $id, ObjectManager $manager)
    {
        $repository = $this->getDoctrine()->getRepository(Actuality::class);
        $actuality = $repository->find($id);           

        $manager->remove($actuality);
        $manager->flush();       
     
        return $this->redirectToRoute('actualityadmin_index');

        return $this->render('/backend/actuality/show.html.twig', [
        'actuality' => $actuality
        ]);
    }   

    /**
     * @Route("/profil/admin/actuality/show/{id}/update", name="actualityadmin_update", requirements={"id"="\d+"})
     */
    public function update(Request $request, $id, ObjectManager $manager)
    {
        $actu = new Actuality();      
        
        $repository = $this->getDoctrine()->getRepository(Actuality::class);
        $actuid = $repository->find($id);    
                             
        $oldActu = $actuid->getPictureUrl();               

        if(!empty($oldActu)) {            
            $actuid->getPictureUrl(
                new File($this->getParameter('upload_directory').'/'.$oldActu)
            );            
        }
        $form = $this->createForm(ActualityType::class, $actu);
        $form->handleRequest($request); 
        
        if ($form->isSubmitted() && $form->isValid()) {

            if(!is_null($actuid->getPictureUrl())){
                $file = $form->get('picture_url')->getData();
                $title = $form->get('title')->getData();
                $content = $form->get('content')->getData();              
                
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                
                    $file->move(
                        $this->getParameter('upload_directory'),
                        $fileName
                    );               
                
                $actuid->setPictureUrl($fileName);
                $actuid->setTitle($title); 
                $actuid->setContent($title);   
                
                if(!empty($oldActu)){
                    unlink(
                        $this->getParameter('upload_directory') .'/'.$oldActu
                    );
                }
            } else {               
                $actuid->setPictureUrl($oldActu);                             
            }

            $this->getDoctrine()->getManager()->flush();  
     
        return $this->redirectToRoute('actualityadmin_index');
        }

        return $this->render('/backend/actuality/update.html.twig', [
            'form' => $form->createView(),
            'actuality' => $actuid
        ]);
    }   
}