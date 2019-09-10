<?php

namespace App\Controller\Backend;

use App\Utils\Month;
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
          $start = $start->format('N') === '1' ? $start : $month->getStartingDay()->modify('last monday');

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
          $start = $start->format('d');

    

        return $this->render('calendar/month.html.twig', [
            'month_name' => $month_name,
            'previous_month_month' => $previous_month_month,
            'previous_month_year' => $previous_month_year,
            'next_month_month' => $next_month_month,
            'next_month_year' => $next_month_year,
            'nb_weeks' => $nb_weeks,
            'month_days' => $month_days,
            'days' => $days,
            'start' => $start,
            'initial_start' => $start,
            'nb_days_month' => $nb_days_month,
            'nb_days_previous_month' => $nb_days_previous_month,
            'month_number' => $month_number,
            'year_number' => $year_number,
        ]);
    }
}
