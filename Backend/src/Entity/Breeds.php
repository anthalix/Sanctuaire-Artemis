<?php

namespace App\Entity;

use App\Entity\Animals;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BreedsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BreedsRepository::class)]
class Breeds
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id = null;
    #[Groups('API')]

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Animals>
     */
    #[ORM\ManyToMany(targetEntity: Animals::class, mappedBy: 'breed')]
    private Collection $animals;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Animals>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animals $animal): static
    {
        if (!$this->animals->contains($animal)) {
            $this->animals->add($animal);
            $animal->addBreed($this);
        }

        return $this;
    }

    public function removeAnimal(Animals $animal): static
    {
        if ($this->animals->removeElement($animal)) {
            $animal->removeBreed($this);
        }

        return $this;
    }
}
