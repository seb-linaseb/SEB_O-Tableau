<?php

namespace App\Controller\User;

use App\Entity\Student;
use App\Entity\Classroom;
use App\Utils\Calendar\Week;
use App\Entity\PresenceLunch;
use App\Form\PresenceLunchType;
use Doctrine\ORM\EntityManager;
use App\Repository\CalendarRepository;
use App\Repository\ClassroomRepository;
use App\Repository\PresenceLunchRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CanteenController extends AbstractController
{    /**
  * @Route("canteen/day/", name="canteen_day")
  */
 public function day(Request $request, ClassroomRepository $classroomRepository, PresenceLunchRepository $presenceLunchRepository, CalendarRepository $calendarRepository)
 {

   // On récupère les infos sur le professeur et sa classe
   $repositoryclass = $this->getDoctrine()->getRepository(Classroom::class);
   $classrooms = $repositoryclass->findAll();            
     
   $user = $this->getUser()->getId();
   $my_classroom = $repositoryclass->findMyClass($user);

   // ********************** AFFICHAGE DU TABLEAU JOURNALIER + NAVIGATION *******************************

   // Si la date du jour est fournie dans l'url, on la décompose
   if(isset($_GET['date_of_day'])) {
     $date_values = explode("-", $_GET['date_of_day']);
     $date_year = intval($date_values[0]);
     $date_month = intval($date_values[1]);
     $date_day = intval($date_values[2]);  
   }

   // Si la date du jour n'est pas fournie, on utilise la date du jour système
   if(!isset($_GET['date_of_day'])) {
     $date_of_day = new \DateTime();
     //$calendar = new Calendar();
     //$calendar->setDate($date_of_day);
     //$calendar->setIsWorked(true);
   } else {
     $date_of_day = new \DateTime("{$date_year}-{$date_month}-{$date_day}");
   };
   
   // Date de la veille
   $date_of_yesterday = ((clone $date_of_day)->modify("-" . 1 . "day"))->format('Y-m-d');
 
   // Date du lendemain
   $date_of_tomorrow = (clone $date_of_day)->modify("+" . 1 . "day")->format('Y-m-d');

   // Date du jour (au bon format pour renvoi à la vue)
   // Ne pas remonter cet élément au dessus des calculs de dates de la veille et du lendemain
   $date_of_day_to_display = $date_of_day->format('d-m-Y');
   $date_of_day_bdd = $date_of_day->format('Y-m-d');

   // Récupération de la liste des élèves

   $students = $my_classroom->getStudents();
   dump($my_classroom);die();
   $forms = [];

      foreach ($students as $key => $student) {
        //$student->getLunches()
        $thisCalendar = $calendarRepository->findByDate($date_of_day_bdd);
        //dump($thisCalendar[0]);
        //die;
        $presenceLunches = $presenceLunchRepository->findThisPresenceLunch($thisCalendar[0], $student->getId());
        
        //dump($student->getId());
        if (empty($presenceLunches)){
          $presenceLunch = new PresenceLunch();
          $form = $this->createForm(PresenceLunchType::class, $presenceLunch);
          $form->handleRequest($request);
          
          $forms[$student->getId()] = $form->createView();

            if ($form->isSubmitted() && $form->isValid()) {
              $presenceLunch->setCalendar($thisCalendar[0]);
              $presenceLunch->setIsCanceled(false);
              $presenceLunch->setIsOrdered(true);

              $entityManager = $this->getDoctrine()->getManager();
              $entityManager->persist($presenceLunch);
              $entityManager->flush();
              //dump($presenceLunch);
              return $this->redirectToRoute('canteen_day');
            }
            
        
          }

         
        }
   //dump($forms);die();
   //die;
   

 return $this->render('canteen/day.html.twig', [
     'date_of_day_to_display' => $date_of_day_to_display,
     'date_of_yesterday' => $date_of_yesterday,
     'date_of_tomorrow' => $date_of_tomorrow,
     'students' => $students,
     'student'=>$student,
     'my_classroom' => $my_classroom,
     'forms'=> $forms,
     'form' => $form->createView(),

 ]);
 }
}
