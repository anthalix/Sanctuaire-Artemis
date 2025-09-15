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

    #[ORM\ManyToOne(inversedBy: 'contactMessages')]
    private ?Message $message = null;

    #[ORM\ManyToOne(inversedBy: 'contactMessages')]
    private ?FrontUser $frontUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(?Message $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getFrontUser(): ?FrontUser
    {
        return $this->frontUser;
    }

    public function setFrontUser(?FrontUser $frontUser): static
    {
        $this->frontUser = $frontUser;

        return $this;
    }
}
