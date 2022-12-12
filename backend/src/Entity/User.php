<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: 'json')]
    #[Groups(['usable'])]
    private array $roles = [];

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: Message::class, orphanRemoval: true)]
    private Collection $messages;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy:"participants")]
    private Collection $chats;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        $this->messages->add($message);
        $message->setAuteur($this);

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if($this->messages->removeElement($message)){
            $message->setAuteur(null);            
        }

        return $this;
    }

    public function getChats(): Collection
    {
        return $this->chats;
    }

    public function addChat(Chat $chat): self
    {
        if(!$this->chats->contains($chat)) {
            $this->chats->add($chat);
            $chat->addAuteur($this);
        }
       
        return $this;
    }

    public function removeChat(Chat $chat): self
    {
        if($this->chats->removeElement($chat)) {
            $chat->removeAuteur($this);
        }

        return $this;
    }


}
