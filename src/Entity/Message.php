<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
    private $read_status;

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
    private $user_receive;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="messages")
     */
    private $user_post;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Conversation", inversedBy="messages")
     */
    private $conversation;

    public function __construct()
    {
        $this->conversation = new ArrayCollection();
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

    public function getUserReceive(): ?User
    {
        return $this->user_receive;
    }

    public function setUserReceive(?User $user_receive): self
    {
        $this->user_receive = $user_receive;

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
}
