<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HasStatusRepository")
 */
class HasStatus
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_present;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_ordered;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_canceled;

    /**
     * @ORM\Column(type="boolean")
     */
    private $has_eated;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Calendar", inversedBy="hasStatuses")
     */
    private $calendar;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Student", inversedBy="hasStatuses")
     */
    private $student;


    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsPresent(): ?bool
    {
        return $this->is_present;
    }

    public function setIsPresent(bool $is_present): self
    {
        $this->is_present = $is_present;

        return $this;
    }

    public function getIsOrdered(): ?bool
    {
        return $this->is_ordered;
    }

    public function setIsOrdered(bool $is_ordered): self
    {
        $this->is_ordered = $is_ordered;

        return $this;
    }

    public function getIsCanceled(): ?bool
    {
        return $this->is_canceled;
    }

    public function setIsCanceled(bool $is_canceled): self
    {
        $this->is_canceled = $is_canceled;

        return $this;
    }

    public function getHasEated(): ?bool
    {
        return $this->has_eated;
    }

    public function setHasEated(bool $has_eated): self
    {
        $this->has_eated = $has_eated;

        return $this;
    }

    public function getCalendar(): ?Calendar
    {
        return $this->calendar;
    }

    public function setCalendar(?Calendar $calendar): self
    {
        $this->calendar = $calendar;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }


    
}
