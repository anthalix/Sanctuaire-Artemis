<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AnimalsRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[UniqueEntity(fields: ['name'], message: 'Un animal avec ce nom existe déjà')]
#[ORM\Entity(repositoryClass: AnimalsRepository::class)]
#[Vich\Uploadable()]
class Animals
{
    #[Groups('API')]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups('API')]
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le nom de l\'animal est requis')]
    private ?string $name = null;

    #[Groups('API')]
    #[ORM\Column]
    private ?int $age = null;

    #[Groups('API')]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;


    #[Groups('API')]
    #[ORM\Column(length: 255)]
    private ?string $sex = null;

    #[Groups('API')]
    #[ORM\Column]
    private ?bool $child = null;

    #[Groups('API')]
    #[ORM\Column]
    private ?bool $cat = null;

    #[Groups('API')]
    #[ORM\Column]
    private ?bool $dog = null;


    #[Groups('API')]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $thumbnail = null;


    #[Vich\UploadableField(mapping: 'animals', fileNameProperty: 'thumbnail')]
    #[Assert\Image()]
    private ?File $thumbnailFile = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[Groups('API')]
    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Species $specie = null;

    /**
     * @var Collection<int, Breeds>
     */
    #[Groups('API')]
    #[ORM\ManyToMany(targetEntity: Breeds::class, inversedBy: 'animals')]
    private Collection $breeds;

    #[Groups('API')]
    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[Groups('API')]
    #[ORM\Column(length: 255)]
    private ?string $taille = null;

    public function __construct()
    {
        $this->breeds = new ArrayCollection();
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

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): static
    {
        $this->sex = $sex;

        return $this;
    }

    public function isChild(): ?bool
    {
        return $this->child;
    }

    public function setChild(bool $child): static
    {
        $this->child = $child;

        return $this;
    }

    public function isCat(): ?bool
    {
        return $this->cat;
    }

    public function setCat(bool $cat): static
    {
        $this->cat = $cat;

        return $this;
    }

    public function isDog(): ?bool
    {
        return $this->dog;
    }

    public function setDog(bool $dog): static
    {
        $this->dog = $dog;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?string $thumbnail): static
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
        /**
         * Set the value of taille
         *
         * @return  self
         */
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getSpecie(): ?Species
    {
        return $this->specie;
    }

    public function setSpecie(?Species $specie): static
    {
        $this->specie = $specie;

        return $this;
    }

    /**
     * Get the value of thumbnailFile
     */
    public function getThumbnailFile(): ?File
    {
        return $this->thumbnailFile;
    }

    /**
     * Set the value of thumbnailFile
     *
     * @return  self
     */
    public function setThumbnailFile(?file $thumbnailFile): static
    {
        $this->thumbnailFile = $thumbnailFile;

        return $this;
        return $this->child;
    }

    /**
     * @return Collection<int, Breeds>
     */
    public function getBreeds(): Collection
    {
        return $this->breeds;
    }

    public function addBreed(Breeds $breed): static
    {
        if (!$this->breeds->contains($breed)) {
            $this->breeds->add($breed);
        }

        return $this;
    }

    public function removeBreed(Breeds $breed): static
    {
        $this->breeds->removeElement($breed);

        return $this;
    }

    /**
     * Get the value of status
     */

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): static
    {
        $this->taille = $taille;

        return $this;
    }
}
