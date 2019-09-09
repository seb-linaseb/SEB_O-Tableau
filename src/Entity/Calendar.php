<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\OneToMany(targetEntity="App\Entity\HasStatus", mappedBy="calendar")
     */
    private $hasStatuses;

    public function __construct()
    {
        $this->hasStatuses = new ArrayCollection();
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
    public function getHasStatuses(): Collection
    {
        return $this->hasStatuses;
    }

    public function addHasStatus(HasStatus $hasStatus): self
    {
        if (!$this->hasStatuses->contains($hasStatus)) {
            $this->hasStatuses[] = $hasStatus;
            $hasStatus->setCalendar($this);
        }

        return $this;
    }

    public function removeHasStatus(HasStatus $hasStatus): self
    {
        if ($this->hasStatuses->contains($hasStatus)) {
            $this->hasStatuses->removeElement($hasStatus);
            // set the owning side to null (unless already changed)
            if ($hasStatus->getCalendar() === $this) {
                $hasStatus->setCalendar(null);
            }
        }

        return $this;
    }
}
