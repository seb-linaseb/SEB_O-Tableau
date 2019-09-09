<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConversationRepository")
 */
class Conversation
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
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Message", mappedBy="conversation")
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="conversations")
     */
    private $user_consult;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="conversations")
     */
    private $user_participate;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->user_consult = new ArrayCollection();
        $this->user_participate = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->addConversation($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->contains($message)) {
            $this->messages->removeElement($message);
            $message->removeConversation($this);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserConsult(): Collection
    {
        return $this->user_consult;
    }

    public function addUserConsult(User $userConsult): self
    {
        if (!$this->user_consult->contains($userConsult)) {
            $this->user_consult[] = $userConsult;
        }

        return $this;
    }

    public function removeUserConsult(User $userConsult): self
    {
        if ($this->user_consult->contains($userConsult)) {
            $this->user_consult->removeElement($userConsult);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserParticipate(): Collection
    {
        return $this->user_participate;
    }

    public function addUserParticipate(User $userParticipate): self
    {
        if (!$this->user_participate->contains($userParticipate)) {
            $this->user_participate[] = $userParticipate;
        }

        return $this;
    }

    public function removeUserParticipate(User $userParticipate): self
    {
        if ($this->user_participate->contains($userParticipate)) {
            $this->user_participate->removeElement($userParticipate);
        }

        return $this;
    }
}
