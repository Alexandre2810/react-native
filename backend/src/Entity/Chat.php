<?php

namespace App\Entity;

use App\Repository\ChatRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


#[ORM\Entity(repositoryClass: ChatRepository::class)]
class Chat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'chat', targetEntity: Message::class, orphanRemoval: true)]
    private Collection $messages;

    #[ORM\ManyToMany(mappedBy: 'chats', targetEntity: Chat::class)]
    private Collection $participants;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->participants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        $this->messages->add($message);
        return $this;
    }

    public function removeMessage(Message $message): self
    {
        $this->messages->removeElement($message);
    }

    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(User $participant): self
    {
        $this->participants->add($participant);
    }

    public function removeParticipant(User $participant): self{
        $this->participants->remove($participant);
    }

}
