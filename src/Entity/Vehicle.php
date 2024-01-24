<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle extends Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type:"string", length: 255)]
    #[Assert\NotBlank(message: "Vous devez renseigner le titre de l'annonce.")]
    private string $title;

    #[ORM\Column(type:"integer")]
    #[Assert\NotBlank(message: "Vous devez renseigner l'année du véhicule'.")]
    #[Assert\Positive]
    #[Assert\Range(min: 1000, max: 10000, minMessage:"Erreur, l'année renseignée est trop basse.", maxMessage:"Erreur, l'année renseignée est trop élevée.")]
    private int $years;

    #[ORM\Column(type:"integer")]
    #[Assert\NotBlank(message: "Vous devez renseigner le kilométrage du véhicule'.")]
    #[Assert\PositiveOrZero]
    private int $mileage;

    #[ORM\Column(type: Types::TEXT, length: 20000)]
    #[Assert\NotBlank(message: "Vous devez renseigner une description pour le véhicule.")]
    private string $description;

    #[ORM\OneToMany(mappedBy: 'vehicles', targetEntity: Picture::class, orphanRemoval: true)]
    private Collection $pictures;

    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    private ?Gearbox $gearboxes = null;

    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    private ?Brand $brands = null;

    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Energy $energies = null;

    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Model $models = null;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function gettitle(): ?string
    {
        return $this->title;
    }

    public function settitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getYears(): ?int
    {
        return $this->years;
    }

    public function setYears(int $years): static
    {
        $this->years = $years;

        return $this;
    }

    public function getMileage(): ?int
    {
        return $this->mileage;
    }

    public function setMileage(int $mileage): static
    {
        $this->mileage = $mileage;

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

    /**
     * @return Collection<int, Picture>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): static
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures->add($picture);
            $picture->setVehicles($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): static
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getVehicles() === $this) {
                $picture->setVehicles(null);
            }
        }

        return $this;
    }

    public function getGearboxes(): ?Gearbox
    {
        return $this->gearboxes;
    }

    public function setGearboxes(?Gearbox $gearboxes): static
    {
        $this->gearboxes = $gearboxes;

        return $this;
    }

    public function getBrands(): ?Brand
    {
        return $this->brands;
    }

    public function setBrands(?Brand $brands): static
    {
        $this->brands = $brands;

        return $this;
    }

    public function getEnergies(): ?energy
    {
        return $this->energies;
    }

    public function setEnergies(?energy $energies): static
    {
        $this->energies = $energies;

        return $this;
    }

    public function getModels(): ?model
    {
        return $this->models;
    }

    public function setModels(?model $models): static
    {
        $this->models = $models;

        return $this;
    }
}
