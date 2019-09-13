<?php

namespace App\Utils\Calendar;

Class Week {

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
    // La date du jour
    $this->today = new \DateTime("{$this->year}-{$this->month}-{$this->day}");
    // Le 1er Janvier de l'année
    $this->base_day = new \DateTime("{$this->year}-01-01");

  }

}