<?php

namespace App\Controller\Backend;

use App\Utils\Calendar\Month;
use App\Utils\Calendar\Week;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCalendarController extends AbstractController
{
    /**
     * @Route("/admin/calendar/month", name="admin_calendar_month")
     */
    public function month()
    {
        // try {
          $month = new Month($_GET['month'] ?? null, $_GET['year'] ?? null);
        // } catch (\Exception $e) {
          // $month = new App\Date\Month();
        // }
        
          $start = $month->getStartingDay();
          $launch_day = $start->format('N');
          // $start = $start->format('N') === '1' ? $start_monday = $start : $start_other = $month->getStartingDay()->modify('last monday');

          $start_other = $month->getStartingDay()->modify('last monday');

          $end = $month->getEndingDay();
          $end = $end->format('d');

          $month_name = $month->toString();

          // $date = $month->getDate();

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
          
          $start_monday = $start->format('d');
          $start_other = $start_other->format('d');
    

        return $this->render('calendar/month.html.twig', [
            'month_name' => $month_name,
            'previous_month_month' => $previous_month_month,
            'previous_month_year' => $previous_month_year,
            'next_month_month' => $next_month_month,
            'next_month_year' => $next_month_year,
            'nb_weeks' => $nb_weeks,
            'month_days' => $month_days,
            'days' => $days,
            'start_monday' => $start_monday,
            'launch_day' => $launch_day,
            'start_other' => $start_other,
            'initial_start' => $start,
            'nb_days_month' => $nb_days_month,
            'nb_days_previous_month' => $nb_days_previous_month,
            'month_number' => $month_number,
            'year_number' => $year_number,
        ]);
    }


    /**
     * @Route("/admin/calendar/week", name="admin_calendar_week")
     */
    public function week()
    {

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


      // Récupère les jours à afficher dans le tableau hebdomadaire

      
      $week_day_1 = (clone $week_starting_day)->format('d/m/Y');
      $week_day_2 = (clone $week_starting_day)->modify("+" . 1 . "day")->format('d/m/Y');
      $week_day_3 = (clone $week_starting_day)->modify("+" . 2 . "day")->format('d/m/Y');
      $week_day_4 = (clone $week_starting_day)->modify("+" . 3 . "day")->format('d/m/Y');
      $week_day_5 = (clone $week_starting_day)->modify("+" . 4 . "day")->format('d/m/Y');
      $week_day_6 = (clone $week_starting_day)->modify("+" . 5 . "day")->format('d/m/Y');
      $week_day_7 = (clone $week_starting_day)->modify("+" . 6 . "day")->format('d/m/Y');
      


        return $this->render('calendar/week.html.twig', [
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

        ]);
    }

    /**
     * @Route("/admin/calendar/day/", name="admin_calendar_day")
     */
    public function day()
    {

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
      } else {
        $date_of_day = new \DateTime("{$date_year}-{$date_month}-{$date_day}");
      };

      // Date de la veille
      $date_of_yesterday = ((clone $date_of_day)->modify("-" . 1 . "day"))->format('Y-m-d');
          
      // Date du lendemain
      $date_of_tomorrow = (clone $date_of_day)->modify("+" . 1 . "day")->format('Y-m-d');

      // Date du jour (au bon format pour renvoi à la vue)
      // Ne pas remonter cet élément au dessus des calculs de dates de la veille et du lendemain
      $date_of_day = $date_of_day->format('d-m-Y');


    return $this->render('calendar/day.html.twig', [
        'date_of_day' => $date_of_day,
        'date_of_yesterday' => $date_of_yesterday,
        'date_of_tomorrow' => $date_of_tomorrow,
    ]);
    }

}
