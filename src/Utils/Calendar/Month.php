<?php

namespace App\Utils\Calendar;

Class Month {

  public $days = [
    'Lundi',
    'Mardi',
    'Mercredi',
    'Jeudi',
    'Vendredi',
    'Samedi',
    'Dimanche',
  ];

  private $months = [
    'Janvier',
    'Février',
    'Mars',
    'Avril',
    'Mai',
    'Juin',
    'Juillet',
    'Août',
    'Septembre',
    'Octobre',
    'Novembre',
    'Décembre',
  ];

  public $month;

  public $year;

  /**
   * Calendar constructor
   * @param int $month Le mois compris entre 1 et 12
   * @param int $year L'année
   * @throws Exception
   */
  public function __construct(?int $month=null, ?int $year=null) 
  {
    if($month === null || $month < 1 || $month > 12) {
      $month = intval(date('m'));
    }
    if($year === null) {
      $year = intval(date('Y'));
    }
    $this->month = $month;
    $this->year = $year;
  }

  /**
   * Renvoie le premier jour du mois
   * @return \DateTime
   */
  public function getStartingDay(): \DateTime {
    return new \DateTime("{$this->year}-{$this->month}-01");
  }

  /**
   * Renvoie le dernier jour du mois
   * @return \DateTime
   */
  public function getEndingDay(): \DateTime {
    $first_day_of_month = new \DateTime("{$this->year}-{$this->month}-01");
    return (clone $first_day_of_month)->modify("+" . 1 . "month" . - 1 . "days");
  }

  /**
   * Retourne le mois en toutes lettres (ex : Mars 2018)
   * @return string
   */
  public function toString(): string {
    return $this->months[$this->month - 1] . ' ' . $this->year; // Pour obtenir le mois "1", il faut l'index "0"
  }

  /**
   * Renvoie le nombre de semaines dans le mois
   * @return int
   */
  public function getWeeks(): int {
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
  public function withinMonth (\DateTime $date): bool {
    return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
  }

  /**
   * Renvoie le mois suivant
   * @return Month
   */
  public function nextMonth() : Month
  {
    $month = $this->month + 1;
    $year = $this->year;
    if ($month > 12) {
      $month = 1;
      $year = $year + 1;
    }
    return new Month($month, $year);
  }

  /**
   * Renvoie le mois précédent
   * @return Month
   */
  public function previousMonth() : Month
  {
    $month = $this->month - 1;
    $year = $this->year;
    if ($month < 1) {
      $month = 12;
      $year = $year - 1;
    }
    return new Month($month, $year);
  }

}