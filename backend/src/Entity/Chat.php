<?php

namespace App\Entity;

use App\Repository\ChatRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;


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
    #[Groups(['main'])]
    private Collection $participants;

    #[ORM\Column(length: 255)]
    #[Groups(['main'])]
    private ?string $topic = null;

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
        if($this->messages->removeElement($message)){
            $message->setChat(null);
        }

        return $this;
    }

    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(User $participant): self
    {
        if (!$this->participants->contains($participant)){
            $this->participants->add($participant);
        }

        return $this;
    }

    public function removeParticipant(User $participant): self
    {
        if($this->participants->removeElement($participant)){
            $participant->removeChat($this);
        }

        return $this;
    }

    public function getTopic(): ?string
    {
        return $this->topic;
    }

    public function setTopic(string $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

}
