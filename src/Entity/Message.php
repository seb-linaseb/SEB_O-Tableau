<?php

namespace App\Entity;

use \DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $read_status = false;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $document_url;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="messages")
     */
    private $user_post;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Conversation", inversedBy="messages")
     */
    private $conversation;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="messages")
     */
    private $users;

    public function __construct()
    {
        $this->conversation = new ArrayCollection();
        $this->created_at = new DateTime();
        $this->updated_at = new DateTime();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getReadStatus(): ?bool
    {
        return $this->read_status;
    }

    public function setReadStatus(bool $read_status): self
    {
        $this->read_status = $read_status;

        return $this;
    }

    public function getDocumentUrl(): ?string
    {
        return $this->document_url;
    }

    public function setDocumentUrl(?string $document_url): self
    {
        $this->document_url = $document_url;

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


    public function getUserPost(): ?User
    {
        return $this->user_post;
    }

    public function setUserPost(?User $user_post): self
    {
        $this->user_post = $user_post;

        return $this;
    }

    /**
     * @return Collection|Conversation[]
     */
    public function getConversation(): Collection
    {
        return $this->conversation;
    }

    public function addConversation(Conversation $conversation): self
    {
        if (!$this->conversation->contains($conversation)) {
            $this->conversation[] = $conversation;
        }

        return $this;
    }

    public function removeConversation(Conversation $conversation): self
    {
        if ($this->conversation->contains($conversation)) {
            $this->conversation->removeElement($conversation);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }
}
