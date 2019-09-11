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

          $month = new Month($_GET['month'] ?? null, $_GET['year'] ?? null);

          $week = new Week($_GET['week'] ?? null, $_GET['day'] ?? null, $_GET['month'] ?? null, $_GET['year'] ?? null);

          $start = $month->getStartingDay();
          
          $launch_day = $start->format('N');
          // $start = $start->format('N') === '1' ? $start_monday = $start : $start_other = $month->getStartingDay()->modify('last monday');

          $start_other = $month->getStartingDay()->modify('last monday');
          // var_dump($start_other);

          
          

          // $end = $month->getEndingDay();
          // $end = $end->format('d');

          $month_name = $month->toString();

          // $date = $month->getDate();


          $previous_month_year = $month->previousMonth()->year;

          $next_month_month = $month->nextMonth()->month;
          $next_month_year = $month->nextMonth()->year;


          $month_days = $month->days;
          
          



          $days = $month->days;


          $nb_days_previous_month = (clone $start)->modify("-" . 1 . "day")->format('t');
          
          $start_monday = $start->format('d');
          $start_other = $start_other->format('d');
    
          $week_starting_day = $week->getWeekStartingDay()->format('d');
          $week_ending_day = $week->getWeekEndingDay()->format('d');
          
          var_dump($week_ending_day);

          if($week_ending_day > $week_starting_day) {
            $month_number = $week->getWeekStartingDay()->format('m');
            $week_number = $week->getWeekStartingDay()->format('W');
            $year_number = $week->getWeekStartingDay()->format('Y');
          } else {
            $month_number = ((clone $week->getWeekEndingDay())->modify("-" . 1 . "month"))->format('m');
            $week_number = ((clone $week->getWeekStartingDay())->modify("+" . 7 . "days"))->format('W');
            $year_number = ((clone $week->getWeekStartingDay())->modify("+" . 7 . "days"))->format('Y');
          }

          $nb_days_month = $week->getWeekStartingDay()->format('t');

          if($week_ending_day > $week_starting_day) {
            $previous_month_month = ((clone $week->getWeekStartingDay())->modify("-" . 1 . "month"))->format('m');  
          } else {
            $previous_month_month = ((clone $week->getWeekStartingDay())->modify("+" . 7 . "days"));
            $previous_month_month = ((clone $week->getWeekStartingDay())->modify("-" . 1 . "month"))->format('m');
          }
          

          $previous_week_number = $week->getPreviousWeek()->week;
          $next_week_number = $week->getNextWeek()->week;
          



        return $this->render('calendar/week.html.twig', [
            'month_name' => $month_name,
            'previous_month_month' => $previous_month_month,
            'previous_month_year' => $previous_month_year,
            'next_month_month' => $next_month_month,
            'next_month_year' => $next_month_year,
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
            'week_number' => $week_number,
            'previous_week_number' => $previous_week_number,
            'next_week_number' => $next_week_number,
            'week_starting_day' => $week_starting_day,
            'week_ending_day' => $week_ending_day,
        ]);
    }

  }
