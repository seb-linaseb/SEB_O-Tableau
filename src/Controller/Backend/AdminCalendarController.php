<?php

namespace App\Controller\Backend;

use App\Entity\Student;
use App\Entity\Calendar;
use App\Entity\Classroom;
use App\Utils\Calendar\Week;
use App\Utils\Calendar\Month;
use App\Repository\CalendarRepository;
use App\Repository\ClassroomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCalendarController extends AbstractController
{
public $daynumber;
    

    /**
     * @Route("admin/calendar/read", name="admin_calendar_read", methods={"GET","POST"} )
     */
    public function read(CalendarRepository $calendarRepository)
    {
        //*******************************Affichage calendrier********************************************************** */
              $month = new Month($_GET['month'] ?? null, $_GET['year'] ?? null);
              
                
              $start = $month->getStartingDay();
              $launch_day = $start->format('N');
        
              $end = $month->getEndingDay();
        
              $end = $end->format('d');
        
              $month_name = $month->toString();
        
              $previous_month_month = $month->previousMonth()->month;
              $previous_month_year = $month->previousMonth()->year;
        
              $next_month_month = $month->nextMonth()->month;
              $next_month_year = $month->nextMonth()->year;
        
              $nb_weeks = $month->getWeeks();
        
              $month_days = $month->days;
              $month_number = $month->getEndingDay()->format('m');
        
              $year_number = $start->format('Y');
        
              $days = $month->days;
              $nb_days_month = $month->getStartingDay()->format('t');
        
              $nb_days_previous_month = (clone $start)->modify("-" . 1 . "day")->format('t');
             

              

              //$days_of_month = [];
              $starting_day = $start->format('d/m/Y');
        
              $launch_day = $start->format('N');
              // dump($launch_day);die();
        
              //  $days_of_month[$i] = [];
               for ($i = 1; $i <= $nb_days_month; $i++) {
                $y = $i;
                $days_of_month[$y][] = [];
                
                $dayname = (clone $start)->format('N');
                $daynumber = (clone $start)->format('d/m/Y');
                $days_of_month[$y]['dayname'] = $dayname;
                $days_of_month[$y]['daynumber']= $daynumber;
                $start = $start->modify("+" . 1 . "day");
               }
        //*******************************Gestion BDD********************************************************** */
       
               $datesOfMonth = $calendarRepository->findAll();
               $currentDates = [];
            
               foreach ($datesOfMonth as $key => $date) {
                $month =  $date->getDate()->format('m');
                $year =  $date->getDate()->format('Y');
                if ($month == $month_number && $year == $year_number){
                    $currentDates [$date->getDate()->format('d/m/Y')]= $date->getIsWorked();
                   
                }
               
               }
                  
        
            return $this->render('backend/calendar/read.html.twig', [
                'month_name' => $month_name,
                'previous_month_month' => $previous_month_month,
                'previous_month_year' => $previous_month_year,
                'next_month_month' => $next_month_month,
                'next_month_year' => $next_month_year,
                'nb_weeks' => $nb_weeks,
                'month_days' => $month_days,
                'days' => $days,
                'starting_day' => $starting_day,
                'days_of_month' => $days_of_month,
                'dayname' => $dayname,
                'daynumber' => $daynumber, // date d/m/Y
                'launch_day' => $launch_day,
                'initial_start' => $start,
                'nb_days_month' => $nb_days_month,
                'currentDates' => $currentDates,
                
            ]);
    }


    /**
     * @Route("admin/calendar/create", name="admin_calendar_create", methods={"GET","POST"} )
     */
    public function create()
    {
//*******************************Affichage calendrier********************************************************** */
      $month = new Month($_GET['month'] ?? null, $_GET['year'] ?? null);
        
        
      $start = $month->getStartingDay();
      $launch_day = $start->format('N');

      $end = $month->getEndingDay();

      $end = $end->format('d');

      $month_name = $month->toString();

      $previous_month_month = $month->previousMonth()->month;
      $previous_month_year = $month->previousMonth()->year;

      $next_month_month = $month->nextMonth()->month;
      $next_month_year = $month->nextMonth()->year;

      $nb_weeks = $month->getWeeks();

      $month_days = $month->days;
      $month_number = $month->getEndingDay()->format('m');

      $year_number = $start->format('Y');

      $days = $month->days;
      $nb_days_month = $month->getStartingDay()->format('t');

      $nb_days_previous_month = (clone $start)->modify("-" . 1 . "day")->format('t');
      

      //$days_of_month = [];
      $starting_day = $start->format('d/m/Y');

      $launch_day = $start->format('N');
      // dump($launch_day);die();

      //  $days_of_month[$i] = [];
       for ($i = 1; $i <= $nb_days_month; $i++) {
        $y = $i;
        $days_of_month[$y][] = [];
        
        $dayname = (clone $start)->format('N');
        $daynumber = (clone $start)->format('d/m/Y');
        $days_of_month[$y]['dayname'] = $dayname;
        $days_of_month[$y]['daynumber']= $daynumber;
        $start = $start->modify("+" . 1 . "day");
       }

      

    return $this->render('backend/calendar/create.html.twig', [
        'month_name' => $month_name,
        'previous_month_month' => $previous_month_month,
        'previous_month_year' => $previous_month_year,
        'next_month_month' => $next_month_month,
        'next_month_year' => $next_month_year,
        'nb_weeks' => $nb_weeks,
        'month_days' => $month_days,
        'days' => $days,
        'starting_day' => $starting_day,
        'days_of_month' => $days_of_month,
        'dayname' => $dayname,
        'daynumber' => $daynumber,
        'launch_day' => $launch_day,
        'initial_start' => $start,
        'nb_days_month' => $nb_days_month,
        
    ]);         
    }

    /**
     * @Route("admin/calendar/save", name="admin_calendar_save", methods={"GET","POST"} )
     */
    public function save()
    {
      
      $dates = $_POST;
      // dump($dates);
      // die();

      foreach ($dates as $key => $value) {
        if($value == 'on'){
          //dump($key);
          $calendar = new Calendar();
          $calendar->setDate(\DateTime::createFromFormat('d/m/Y', $key));
          $calendar->setIsWorked(true);
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($calendar);
          $entityManager->flush();
          //dump($calendar);
        }
        else if($value == $key){
            //dump($key);
            $calendar = new Calendar();
            $calendar->setDate(\DateTime::createFromFormat('d/m/Y', $key));
            $calendar->setIsWorked(false);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($calendar);
            $entityManager->flush();
            //dump($calendar);
          }
      
      }
      $this->addFlash(
        'success',
        'Enregistrement effectué'
    );


      return $this->redirectToRoute('admin_calendar_read');
    }

}
