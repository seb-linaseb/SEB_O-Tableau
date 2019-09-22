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
{
  /**
  * @Route("canteen/day/", name="canteen_day_read")
  */
 public function day_read(Request $request, ClassroomRepository $classroomRepository, PresenceLunchRepository $presenceLunchRepository, CalendarRepository $calendarRepository)
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
  //  dump($my_classroom);die();

/********************************************************************************************************************* */

  // Récupération de toutes les dates du Calendar
  $dates = $calendarRepository->findAll();

  // Récupération de tous les id de toutes les dates du Calendar
  $dates_for_id = [];
    foreach ($dates as $date) {
      $dates_for_id['id'] = $date->getId();
      $dates_for_id['date'] = $date->getDate()->format('Y-m-d');

  // Récupération de l'id de la date du jour
     if ($dates_for_id['date'] == $date_of_day_bdd) {
       $date_of_day_id = $dates_for_id['id'];     
     }
   }

/********************************************************************************************************************* */

   // Récupération des présences Lunch du jour
   $id = $date_of_day_id;
  //  dump($id);die();
  $my_classroom_id = $my_classroom->getId();
  // dump($my_classroom_id);die();
   $presenceLunches = $presenceLunchRepository->findByCalendar($id);
   
   $presenceLunchesToSend = [];
   foreach ($presenceLunches as $presenceLunch) {
    if ($presenceLunch->getStudent()->getClassroom()->getId() == $my_classroom_id) {
      $presenceLunchesToSend[] = $presenceLunch;
    }
   }
  //  dump($presenceLunchesToSend);die();
  
  $lunchesByDate = [];


   foreach ($presenceLunchesToSend as $key => $presenceLunch) {

    // dump($presenceLunch);
    $lunchesByDate[$key]['id'] = $presenceLunch->getId();
    $lunchesByDate[$key]['studentId'] = $presenceLunch->getStudent()->getId();
    $lunchesByDate[$key]['studentName'] = $presenceLunch->getStudent()->getName();
    $lunchesByDate[$key]['studentFirstname'] = $presenceLunch->getStudent()->getFirstname();
    $lunchesByDate[$key]['isPresent'] = $presenceLunch->getIsPresent();
    $lunchesByDate[$key]['hasEated'] = $presenceLunch->getHasEated();
   }


 return $this->render('canteen/day.html.twig', [

     'date_of_day_to_display' => $date_of_day_to_display,
     'date_of_day_bdd' => $date_of_day_bdd,
     'date_of_yesterday' => $date_of_yesterday,
     'date_of_tomorrow' => $date_of_tomorrow,
     'students' => $students,
     'my_classroom' => $my_classroom,
    'date_of_day_id' => $date_of_day_id,
    'lunchesByDate' => $lunchesByDate,

 ]);
 }

  /**
  * @Route("canteen/day/save", name="canteen_day_save", methods={"GET", "POST"} )
  */
  public function day_save(PresenceLunchRepository $presenceLunchRepository)
  {
    $datas = $_POST;
    // dump($datas);die();
    $entityManager = $this->getDoctrine()->getManager();
    foreach ($datas as $key => $data) {
      // dump($key);
      // dump($data);

      if ($key == 'date_of_day_bdd') {
        $date_of_day_bdd = $data;
      } else if ($key == $data) {
        $presenceLunchId = $data;
        $presenceLunch = new PresenceLunch();
        $presenceLunch = $presenceLunchRepository->findById($presenceLunchId);
        $presenceLunch[0]->setIsPresent(false);
        $presenceLunch[0]->setHasEated(false);
        $entityManager->persist($presenceLunch[0]);
      } else {
        $values = explode('-', $key);
        $presenceLunchId = $values[0];
        $fieldToUpdate = $values[1];
        $value = $data;
        // dump($presenceLunchId, $fieldToUpdate, $value);
      

        // if($value == 'on'){
          
          $presenceLunch = new PresenceLunch();
          // dump($presenceLunch);
          $presenceLunch = $presenceLunchRepository->findById($presenceLunchId);
          // dump($presenceLunch[0]);die();
          // dump($presenceLunch);

          if ($fieldToUpdate == 'presence') {
            $presenceLunch[0]->setIsPresent($value);
            
          } else if ($fieldToUpdate == 'eated') {
            $presenceLunch[0]->setHasEated($value);
          }

          
          $entityManager->persist($presenceLunch[0]);
          

          // dump($presenceLunch);
        }
          // $calendar = new Calendar();
          // $calendar->setDate(\DateTime::createFromFormat('d/m/Y', $key));
          // $presenceLunch = new PresenceLunch();
          // $presenceLunch->setIsPresent(true);
          // $presenceLunch->setHasEated(true);
          // $entityManager = $this->getDoctrine()->getManager();
          // $entityManager->persist($calendar);
          // $entityManager->flush();
          //dump($calendar);
        // }
        // else if($value == $key){
            // dump($key);
            // $calendar = new Calendar();
            // $calendar->setDate(\DateTime::createFromFormat('d/m/Y', $key));
            // $calendar->setIsWorked(false);
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($calendar);
            // $entityManager->flush();
            //dump($calendar);
          // }

      }
      $entityManager->flush();
      // $this->addFlash(
        // 'success',
        // 'Enregistrement effectué'
    // );

// die();
      // Rediriger sur la route (date du jour = date réelle)
      return $this->redirectToRoute('canteen_day_read');
      // Rediriger sur la route (date du jour sur laquelle on a apporté des modifications)
      // return $this->redirect($this->generateUrl('canteen_day_read', ['date_of_day' => $date_of_day_bdd]));
    }


}
