<?php

namespace App\Entity;

use App\Repository\ContactMessageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactMessageRepository::class)]
class ContactMessage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Messages::class)]
    private ?Messages $message = null;

    #[ORM\ManyToOne(targetEntity: FrontUser::class)]
    private ?FrontUser $frontUser = null;



    public function getMessage(): ?Messages
    {
        return $this->message;
    }
    public function setMessage(Messages $message): static
    {
        $this->message = $message;
        return $this;
    }

    public function getFrontUser(): ?FrontUser
    {
        return $this->frontUser;
    }
    public function setFrontUser(FrontUser $user): static
    {
        $this->frontUser = $user;
        return $this;
    }
}
