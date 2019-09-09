<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 */
class Student
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $firstname;

    /**
     * @ORM\Column(type="datetime")
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="boolean")
     */
    private $image_rights;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="students")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\LunchType", inversedBy="students")
     */
    private $lunchtype;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Person", inversedBy="students")
     */
    private $person;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Classroom", inversedBy="studentss")
     */
    private $classroom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PresenceLunch", mappedBy="student")
     */
    private $presenceLunches;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Document", mappedBy="student")
     */
    private $documents;


    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->lunchtype = new ArrayCollection();
        $this->person = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->presenceLunches = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImageRights(): ?bool
    {
        return $this->image_rights;
    }

    public function setImageRights(bool $image_rights): self
    {
        $this->image_rights = $image_rights;

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
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
        }

        return $this;
    }

    /**
     * @return Collection|LunchType[]
     */
    public function getLunchType(): Collection
    {
        return $this->lunchtype;
    }

    public function addLunchType(LunchType $lunchType): self
    {
        if (!$this->lunchtype->contains($lunchType)) {
            $this->lunchtype[] = $lunchType;
        }

        return $this;
    }

    public function removeLunchType(LunchType $lunchType): self
    {
        if ($this->lunchtype->contains($lunchType)) {
            $this->lunchtype->removeElement($lunchType);
        }

        return $this;
    }

    /**
     * @return Collection|Person[]
     */
    public function getPerson(): Collection
    {
        return $this->person;
    }

    public function addPerson(Person $person): self
    {
        if (!$this->person->contains($person)) {
            $this->person[] = $person;
        }

        return $this;
    }

    public function removePerson(Person $person): self
    {
        if ($this->person->contains($person)) {
            $this->person->removeElement($person);
        }

        return $this;
    }

    

    public function getClassroom(): ?Classroom
    {
        return $this->classroom;
    }

    public function setClassroom(?Classroom $classroom): self
    {
        $this->classroom = $classroom;

        return $this;
    }

    /**
     * @return Collection|PresenceLunch[]
     */
    public function getPresenceLunches(): Collection
    {
        return $this->presenceLunches;
    }

    public function addPresenceLunch(PresenceLunch $presenceLunch): self
    {
        if (!$this->presenceLunches->contains($presenceLunch)) {
            $this->presenceLunches[] = $presenceLunch;
            $presenceLunch->setStudent($this);
        }

        return $this;
    }

    public function removePresenceLunch(PresenceLunch $presenceLunch): self
    {
        if ($this->presenceLunches->contains($presenceLunch)) {
            $this->presenceLunches->removeElement($presenceLunch);
            // set the owning side to null (unless already changed)
            if ($presenceLunch->getStudent() === $this) {
                $presenceLunch->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Document[]
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setStudent($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->contains($document)) {
            $this->documents->removeElement($document);
            // set the owning side to null (unless already changed)
            if ($document->getStudent() === $this) {
                $document->setStudent(null);
            }
        }

        return $this;
    }

    
}
