<?php

namespace App\Entity;

use \DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @ORM\ManyToMany(targetEntity="App\Entity\Message", mappedBy="conversation" )
     */
    private $messages;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="conversations")
     */
    private $user_consult;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="conversations")
     */
    private $user_participate;


    public function __construct()
    {
        $this->created_at = new DateTime();
        $this->updated_at = new DateTime();
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

    public function getUserConsult(): ?User
    {
        return $this->user_consult;
    }

    public function setUserConsult(?User $user_consult): self
    {
        $this->user_consult = $user_consult;

        return $this;
    }

    public function getUserParticipate(): ?User
    {
        return $this->user_participate;
    }

    public function setUserParticipate(?User $user_participate): self
    {
        $this->user_participate = $user_participate;

        return $this;
    }

    

    
    
}
