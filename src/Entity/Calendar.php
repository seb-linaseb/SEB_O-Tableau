<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CalendarRepository")
 */
class Calendar
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_worked;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PresenceLunch", mappedBy="calendar")
     */
    private $presenceLunches;

    public function __construct()
    {
        $this->presenceLunches = new ArrayCollection();
        $this->created_at = new DateTime();
        $this->updated_at = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIsWorked(): ?bool
    {
        return $this->is_worked;
    }

    public function setIsWorked(bool $is_worked): self
    {
        $this->is_worked = $is_worked;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection|HasStatus[]
     */
    public function getPresenceLunches(): Collection
    {
        return $this->presenceLunches;
    }

    public function addPresenceLunch(PresenceLunch $presenceLunch): self
    {
        if (!$this->presenceLunch->contains($presenceLunch)) {
            $this->presenceLunches[] = $presenceLunches;
            $presenceLunches->setCalendar($this);
        }

        return $this;
    }

    public function removePresenceLunch(PresenceLunch $presenceLunch): self
    {
        if ($this->presenceLunch->contains($presenceLunch)) {
            $this->presenceLunch->removeElement($presenceLunch);
            // set the owning side to null (unless already changed)
            if ($presenceLunch->getCalendar() === $this) {
                $presenceLunch->setCalendar(null);
            }
        }

        return $this;
    }
}
