<?php

namespace App\Utils\Calendar;

Class Week {

  // public $days = [
    // 'Lundi',
    // 'Mardi',
    // 'Mercredi',
    // 'Jeudi',
    // 'Vendredi',
    // 'Samedi',
    // 'Dimanche',
  // ];

  // private $months = [
    // 'Janvier',
    // 'Février',
    // 'Mars',
    // 'Avril',
    // 'Mai',
    // 'Juin',
    // 'Juillet',
    // 'Août',
    // 'Septembre',
    // 'Octobre',
    // 'Novembre',
    // 'Décembre',
  // ];

  public $month;

  public $year;

  public $week;
  
  public $today;

  public $today_number;
  public $week_starting_day;
  public $week_ending_day;

  /**
   * Calendar constructor
   * @param int $month Le mois compris entre 1 et 12
   * @param int $year L'année
   * @throws Exception
   */
  public function __construct(?int $week=null, ?int $day=null, ?int $month=null, ?int $year=null) 
  {
    if($week === null || $week < 1 || $week > 52) {
      $week = intval(date('W'));
    }
    if($day === null || $day < 1 || $day > 31) {
      $day = intval(date('d'));
    }
    if($month === null || $month < 1 || $month > 12) {
      $month = intval(date('m'));
    }
    if($year === null) {
      $year = intval(date('Y'));
    }
    $this->week = $week;
    $this->day = $day;
    $this->month = $month;
    $this->year = $year;
    $this->today = new \DateTime("{$this->year}-{$this->month}-{$this->day}");
    $this->base_day = new \DateTime("{$this->year}-01-01");
    $this->base_number = $this->base_day->format('N');
  }

  /**
   * Récupère la date du jour
   * @return DateTime
   */
  // public function getToday() {
  //   $this->today = new \DateTime("{$this->year}-{$this->month}-{$this->day}");
  //   return $this->$today;
  // }

  /**
   * Récupère le numéro du jour (Lundi = 1 ...... Dimanche = 7)
   * @return DateTime
   */
  // public function getTodayNumber() {
  //   //$today = $this->today;
  //   $today_number = $this->today->format('N');
  //   return $this->today_number = $today_number;
  // }

  /**
   * Renvoie le 1er jour de la semaine
   */
  public function getWeekStartingDay() {
    $week = $this->week;
    $base_day = $this->base_day;
    $base_number = $this->base_number;
    // $week_number = $week->format('W');
    
    // Calcul du décalage de semaine
    if($base_number == 1) {
      $shift_number = $week - 1;
    } else {
      $shift_number = $week - 1;
    }

    // 1er jour de la semaine recherchée
    if($base_number == 1) {
      $week_starting_day = $base_day;
    } else {
      $week_starting_day = ((clone $base_day)->modify("+" . $shift_number . "weeks"))->modify('last monday');
    }

    return $week_starting_day;
  }

  /**
   * Renvoie le dernier jour de la semaine
   */
  public function getWeekEndingDay() {
    $week = $this->week;
    $base_day = $this->base_day;
    $base_number = $this->base_number;
    // $week_number = $week->format('W');
    
    // Calcul du décalage de semaine
    if($base_number == 1) {
      $shift_number = $week - 1;
    } else {
      $shift_number = $week - 1;
    }

    // Dernier jour de la semaine recherchée
    if($base_number == 1) {
      $week_ending_day = $base_day;
    } else {
      $week_ending_day = ((clone $base_day)->modify("+" . $shift_number . "weeks"))->modify('next sunday');
    }

    return $week_ending_day;
  }


/*
  /**
   * Renvoie le premier jour du mois
   * @return \DateTime
   */
/*  public function getStartingDay(): \DateTime {
    return new \DateTime("{$this->year}-{$this->month}-01");
  }

  /**
   * Renvoie le dernier jour du mois
   * @return \DateTime
   */
/*  public function getEndingDay(): \DateTime {
    $first_day_of_month = new \DateTime("{$this->year}-{$this->month}-01");
    return (clone $first_day_of_month)->modify("+" . 1 . "month" . - 1 . "days");
  }

  /**
   * Retourne le mois en toutes lettres (ex : Mars 2018)
   * @return string
   */
/*  public function toString(): string {
    return $this->months[$this->month - 1] . ' ' . $this->year; // Pour obtenir le mois "1", il faut l'index "0"
  }

  /**
   * Renvoie le nombre de semaines dans le mois
   * @return int
   */
/*  public function getWeeks(): int {
    $start = new \DateTime("{$this->year}-{$this->month}-01");
    $end = (clone $start)->modify('+1 month -1 day'); // On applique la modification sur le clone de la variable "start"
    // var_dump($start); // 2019-12-01
    // var_dump($end); // 2012-12-31
    // var_dump($start->format('W')); // 48
    // var_dump($end->format('W')); // 1

    $weeks = intval($end->format('W')) - intval($start->format('W')) + 1;
    // var_dump($weeks);

    if ($weeks < 0) {
      $weeks = intval($end->format('W'));
    }
    if ($weeks == 1) {
      $weeks = 6;
    }
    return $weeks;
  }

  /**
   * Est-ce que le jour est dans le mois en cours ?
   * @param \DateTime $date
   * @return bool
   */
/*  public function withinMonth (\DateTime $date): bool {
    return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
  }

  /**
   * Renvoie la semaine suivante
   * @return Week
   */
  public function getNextWeek() : Week
  {
    $week = $this->week + 1;
    // $month = $this->month + 1;
    $year = $this->year;
    if ($week > 52) {
      $week = 1;
      $year = $year + 1;
    }
    return new Week($week, /*$month,*/ $year);
  }

  /**
   * Renvoie la semaine précédente
   * @return Week
   */
  public function getPreviousWeek() : Week
  {
    $week = $this->week - 1;

    // $month = $this->month;
    $year = $this->year;
    if ($week < 1) {
      $week = 52;
      $year = $year - 1;
    }
    return new Week($week, /*$month,*/ $year);
  }

}