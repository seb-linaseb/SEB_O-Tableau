<?php

namespace App\Controller\Backend;

use DateTime;
use App\Utils\Calendar\Week;
use App\Entity\PresenceLunch;
use App\Repository\StudentRepository;
use App\Repository\CalendarRepository;
use App\Repository\ClassroomRepository;
use App\Repository\PresenceLunchRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCanteenController extends AbstractController
{
  /**
   * @Route("/admin/canteen/read", name="admin_canteen_read_by_week")
   */
  public function readByWeek(ClassroomRepository $classroomRepository, StudentRepository $studentRepository, PresenceLunchRepository $presenceLunchRepository, CalendarRepository $calendarRepository){

      // Si la semaine n'est pas fournie, on utilise la semaine correspondant à la date du jour système
      if(!isset($_GET['week'])) {
        // $week = new \DateTime();
        $week = new Week();
        $week = $week->today;
        $actual_week = $week->format('W');
      } else {
        $week = new Week();
        $actual_week = $week->week;
        $actual_week = $_GET['week'];
      };

      if(!isset($_GET['year'])) {
        $year = new Week();
        $year = $year->today;
        $actual_year = $year->format('Y');
      } else {
        $year = new Week();
        $actual_year = $year->year;
        $actual_year = $_GET['year'];
      };

      // Semaine précédente
      if($actual_week == 1) {
        $previous_week_week = intval("52");
        $previous_week_year = $actual_year - 1;
      } else {
        $previous_week_week = $actual_week - 1;
        $previous_week_year = $actual_year;  
      }

      // Semaine suivante
      if($actual_week == 52) {
        $next_week_week = intval("1");
        $next_week_year = $actual_year + 1;
      } else {
        $next_week_week = $actual_week + 1;
        $next_week_year = $actual_year;  
      }

      // ***** 1er jour à afficher dans le calendrier hebdomadaire *****

        $base_day = new Week();
        $base_day = new \DateTime("{$actual_year}-01-01");  // Le 1er Janvier de l'année en cours
        $base_number = $base_day->format('N');        // Le numéro du jour du 1er Janvier de l'année en cours
        
        // Calcul du décalage de semaine
        if($actual_week == 1) {
          $shift_number = $actual_week - 1;
        } else {
          $shift_number = $actual_week - 1;
        }

        // 1er jour de la semaine recherchée
        if($base_number == 1) {
          $week_starting_day = $base_day;
        } else {
          $week_starting_day = ((clone $base_day)->modify("+" . $shift_number . "weeks"))->modify('last monday');
        }

      $week_number = $week_starting_day->format('W');
      $year_number = $week_starting_day->format('Y');
      // Récupère les jours à afficher dans le tableau hebdomadaire

      
      $week_day_1 = (clone $week_starting_day)->format('d/m/Y');
      $week_day_2 = (clone $week_starting_day)->modify("+" . 1 . "day")->format('d/m/Y');
      $week_day_3 = (clone $week_starting_day)->modify("+" . 2 . "day")->format('d/m/Y');
      $week_day_4 = (clone $week_starting_day)->modify("+" . 3 . "day")->format('d/m/Y');
      $week_day_5 = (clone $week_starting_day)->modify("+" . 4 . "day")->format('d/m/Y');
      $week_day_6 = (clone $week_starting_day)->modify("+" . 5 . "day")->format('d/m/Y');
      $week_day_7 = (clone $week_starting_day)->modify("+" . 6 . "day")->format('d/m/Y');
      
      // Récupérer la liste des classes
      $classrooms = $classroomRepository->findAll();
      
      // Récupérer la liste des élèves
      $students = $studentRepository->findAll();

      // Récupérer les présences lunch
      $presenceLunches = $presenceLunchRepository->findAll();
      // dump($presenceLunches);die();

      //$calendarDatesByWeek = $calendarRepository->findByWeek($week_starting_day);
      $calendars = $calendarRepository->findAll();
    //   dump($calendars);

      // Chaque calendarDate renvoie un objet avec un variable id et un variable date

      // Récupérer le calendar_id d'une date
      // $week_day_1_datetime = date_create_from_format('d/m/Y', $week_day_1);
      // $week_day_1_calendarId = $calendarRepository->findByDate($week_day_1_datetime);
      // dump($week_day_1_calendarId);die();
      // chaque presence lunch renvoie objet avec une variable calendar=>id

        $dates = [];  
      foreach ($calendars as $calendar) {
        $calendarDate = $calendar->getDate()->format('d/m/Y');
        // dump($calendarDate);
        $week = $calendar->getDate()->format('W');
        // dump($week);
         $dates [$calendarDate] = $week;
       
      }
    //   dump($week_number);
     
    // dump($dates);die;
// die();
        /********************* myriam */
    // $datesOfWeek = $presenceLunchRepository->findAll();
         $infos = [];
         $weekDates = [];
         $infos ['week'] = $weekDates;

        foreach ($students as $key=> $student){
          $infos ['student'] = $student;
          $lunchType = $student->getLunchType();
          $infos['lunchType'] = $lunchType->getCode();
         
       }

       foreach ($calendars as $key => $date) {
        $week =  $date->getDate()->format('W');
        $year =  $date->getDate()->format('Y');
        $weekDates[$week] = [];
        $weekDates[$week]['date'] = $date->getDate()->format('d/m/Y');
        $weekDates[$week]['year'] = $year;
        
         
       // $year =  $date->getDate()->format('Y');
       // if ($month == $month_number && $year == $year_number){
           // $currentDates [$date->getDate()->format('d/m/Y')]= $date->getIsWorked(); 
        }


       
        $status = $presenceLunchRepository->findThisPresenceLunch($date, $student);
        $infoCantine = [];
        
        $infos ['status'] = $status;
        dump($infos);
        dump($week);

        
      
/************* MYRIAM FIN */

      // dump($datesOfWeek);die(); // Renvoie des objets avec calendar.id


      // foreach ($datesOfWeek as $key => $date) {
        // $test = $date[$key];
        // dump($test);die();
      // }

      // $idOfWeek = $datesOfWeek[0]['calendar']->getId();
      // dump($idOfWeek);die(); // Renvoie des objets avec calendar.id
      // $currentDates = [];

      // foreach ($datesOfWeek as $key => $date) {
      // $week =  $date->getDate()->format('W');
      // $year =  $date->getDate()->format('Y');
      // if ($week == $week_number && $year == $year_number){
          // $currentDates [$date->getDate()->format('d/m/Y')]= $date->getIsOrdered();
          // $currentDates [$date->getDate()->format('d/m/Y')]= $date->getIsCanceled();
          // $currentDates [$date->getDate()->format('d/m/Y')]= $date->getHasEated();
          
      // }
      
      // }
      // dump($currentDates);
// die();

        return $this->render('backend/canteen/read_week.html.twig', [
            'actual_week' => $actual_week,
            'actual_year' => $actual_year,
            'previous_week_week' => $previous_week_week,
            'previous_week_year' => $previous_week_year,
            'next_week_week' => $next_week_week,
            'next_week_year' => $next_week_year,
            'week_day_1' => $week_day_1,
            'week_day_2' => $week_day_2,
            'week_day_3' => $week_day_3,
            'week_day_4' => $week_day_4,
            'week_day_5' => $week_day_5,
            'week_day_6' => $week_day_6,
            'week_day_7' => $week_day_7,
            'classrooms' => $classrooms,
            'students' => $students,
            'presenceLunches' => $presenceLunches,
            'dates' => $dates,
            'week_number' => $week_number,
            
            // 'infos'=>$infos,
            // 'calendarDate' => $calendarDate,
        ]);
  }
  /**
   * @Route("/admin/canteen/update", name="admin_canteen_update_by_week")
   */
  public function updateByWeek(){

  }

    /**
     * @Route("/admin/canteen/create/{id}", name="admin_canteen_create", requirements={"id"="\d+"})
     */
    public function createByStudent($id, CalendarRepository $calendarRepository, StudentRepository $studentRepository)
    {
      $dates = $calendarRepository->findAll();

      $student = $studentRepository->find($id);
      // dump($student); die;      

        
      foreach ($dates as $key => $date){
          $presenceLunch = new PresenceLunch();
          $presenceLunch->setStudent($student);
          $presenceLunch->setCalendar($date);

          if ($student->getMondayLunch() == true && $date->getDate()->format('N') == 1 ){
            $presenceLunch->setIsOrdered(true);
            $presenceLunch->setHasEated(true);
          }
          else if ($student->getTuesdayLunch() == true && $date->getDate()->format('N') == 2 ){
            $presenceLunch->setIsOrdered(true);
            $presenceLunch->setHasEated(true);
          }
          else if ($student->getWednesdayLunch() == true && $date->getDate()->format('N') == 3 ){
            $presenceLunch->setIsOrdered(true);
            $presenceLunch->setHasEated(true);
          }
          else if ($student->getThursdayLunch() == true && $date->getDate()->format('N') == 4 ){
            $presenceLunch->setIsOrdered(true);
            $presenceLunch->setHasEated(true);
          }
          else if ($student->getFridayLunch() == true && $date->getDate()->format('N') == 5 ){
            $presenceLunch->setIsOrdered(true);
            $presenceLunch->setHasEated(true);
          }
          else {
            $presenceLunch->setIsOrdered(false);
            $presenceLunch->setHasEated(false);
          }
          //dump($presenceLunch);
        

          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($presenceLunch);
          $entityManager->flush();

       }
        


        return $this->redirectToRoute('admin_student_index');  
    }

    /**
     * @Route("/admin/canteen/update/{id}", name="admin_canteen_update", requirements={"id"="\d+"})
     */
    public function updateByStudent($id, PresenceLunchRepository $presenceLunchRepository, StudentRepository $studentRepository, CalendarRepository $calendarRepository)
    {
        //Recuperer les dates de Calendar a partir d'aujourd'hui
            $today = new DateTime();
        //Recupère les colonnes de presenceLunch à partir de cette date et pour cet eleve
            $studentDates = $presenceLunchRepository->findStudentDates($today, $id);
            $student = $studentRepository->find($id);  
            
        // J'update la selection   
            foreach ($studentDates as $key => $lunch) {
              $date = $calendarRepository->find($lunch->getCalendar());
              // dump($date);die;

              if ($student->getMondayLunch() == true && $date->getDate()->format('N') == 1 ){
                $lunch->setIsOrdered(true);
                $lunch->setHasEated(true);
              }
              else if ($student->getTuesdayLunch() == true && $date->getDate()->format('N') == 2 ){
                $lunch->setIsOrdered(true);
                $lunch->setHasEated(true);
              }
              else if ($student->getWednesdayLunch() == true && $date->getDate()->format('N') == 3 ){
                $lunch->setIsOrdered(true);
                $lunch->setHasEated(true);
              }
              else if ($student->getThursdayLunch() == true && $date->getDate()->format('N') == 4 ){
                $lunch->setIsOrdered(true);
                $lunch->setHasEated(true);
              }
              else if ($student->getFridayLunch() == true && $date->getDate()->format('N') == 5 ){
                $lunch->setIsOrdered(true);
                $lunch->setHasEated(true);
              }
              else {
                $lunch->setIsOrdered(false);
                $lunch->setHasEated(false);
              }

              $entityManager = $this->getDoctrine()->getManager();
              $entityManager->persist($lunch);
              $entityManager->flush();
            }
            

            //repostory all where date >= today

        //chercher ds la table Lunch toutes ces dates pour cette enfants

        //update des champs

        return $this->redirectToRoute('admin_student_index');  
    }

   
































    // /**
    //  * @Route("/canteen/week", name="canteen_week")
    //  */
    // public function week()
    // {

    //   // Si la semaine n'est pas fournie, on utilise la semaine correspondant à la date du jour système
    //   if(!isset($_GET['week'])) {
    //     // $week = new \DateTime();
    //     $week = new Week();
    //     $week = $week->today;
    //     $actual_week = $week->format('W');
    //   } else {
    //     $week = new Week();
    //     $actual_week = $week->week;
    //     $actual_week = $_GET['week'];
    //   };

    //   if(!isset($_GET['year'])) {
    //     $year = new Week();
    //     $year = $year->today;
    //     $actual_year = $year->format('Y');
    //   } else {
    //     $year = new Week();
    //     $actual_year = $year->year;
    //     $actual_year = $_GET['year'];
    //   };

    //   // Semaine précédente
    //   if($actual_week == 1) {
    //     $previous_week_week = intval("52");
    //     $previous_week_year = $actual_year - 1;
    //   } else {
    //     $previous_week_week = $actual_week - 1;
    //     $previous_week_year = $actual_year;  
    //   }

    //   // Semaine suivante
    //   if($actual_week == 52) {
    //     $next_week_week = intval("1");
    //     $next_week_year = $actual_year + 1;
    //   } else {
    //     $next_week_week = $actual_week + 1;
    //     $next_week_year = $actual_year;  
    //   }

    //   // ***** 1er jour à afficher dans le calendrier hebdomadaire *****

    //     $base_day = new Week();
    //     $base_day = new \DateTime("{$actual_year}-01-01");  // Le 1er Janvier de l'année en cours
    //     $base_number = $base_day->format('N');        // Le numéro du jour du 1er Janvier de l'année en cours
        
    //     // Calcul du décalage de semaine
    //     if($actual_week == 1) {
    //       $shift_number = $actual_week - 1;
    //     } else {
    //       $shift_number = $actual_week - 1;
    //     }

    //     // 1er jour de la semaine recherchée
    //     if($base_number == 1) {
    //       $week_starting_day = $base_day;
    //     } else {
    //       $week_starting_day = ((clone $base_day)->modify("+" . $shift_number . "weeks"))->modify('last monday');
    //     }


    //   // Récupère les jours à afficher dans le tableau hebdomadaire

      
    //   $week_day_1 = (clone $week_starting_day)->format('d/m/Y');
    //   $week_day_2 = (clone $week_starting_day)->modify("+" . 1 . "day")->format('d/m/Y');
    //   $week_day_3 = (clone $week_starting_day)->modify("+" . 2 . "day")->format('d/m/Y');
    //   $week_day_4 = (clone $week_starting_day)->modify("+" . 3 . "day")->format('d/m/Y');
    //   $week_day_5 = (clone $week_starting_day)->modify("+" . 4 . "day")->format('d/m/Y');
    //   $week_day_6 = (clone $week_starting_day)->modify("+" . 5 . "day")->format('d/m/Y');
    //   $week_day_7 = (clone $week_starting_day)->modify("+" . 6 . "day")->format('d/m/Y');
      


    //     return $this->render('canteen/week.html.twig', [
    //         'actual_week' => $actual_week,
    //         'actual_year' => $actual_year,
    //         'previous_week_week' => $previous_week_week,
    //         'previous_week_year' => $previous_week_year,
    //         'next_week_week' => $next_week_week,
    //         'next_week_year' => $next_week_year,
    //         'week_day_1' => $week_day_1,
    //         'week_day_2' => $week_day_2,
    //         'week_day_3' => $week_day_3,
    //         'week_day_4' => $week_day_4,
    //         'week_day_5' => $week_day_5,
    //         'week_day_6' => $week_day_6,
    //         'week_day_7' => $week_day_7,

    //     ]);
    // }

}

