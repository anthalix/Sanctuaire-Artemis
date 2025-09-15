<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
#[ORM\Table(name: "message")] // nom exact de la table
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;


    #[ORM\ManyToMany(targetEntity: FrontUser::class, inversedBy: "messages")]
    #[ORM\JoinTable(
        name: "contact_message",
        joinColumns: [new ORM\JoinColumn(name: "message_id", referencedColumnName: "id")],
        inverseJoinColumns: [new ORM\JoinColumn(name: "frontUser_id", referencedColumnName: "id")]
    )]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }


    /**
     * @return Collection<int, ContactMessage>
     */

}
