<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle extends Product
{
    #[ORM\Column(type:"integer")]
    #[Assert\NotBlank(message: "Vous devez renseigner l'année du véhicule'.")]
    #[Assert\Positive]
    #[Assert\Range(min: 1000, max: 10000, notInRangeMessage: "L'année doit être comprise entre {{ min }} et {{ max }}")]
    private int $years;

    #[ORM\Column(type:"integer")]
    #[Assert\NotBlank(message: "Vous devez renseigner le kilométrage du véhicule'.")]
    #[Assert\PositiveOrZero]
    private int $mileage;

    #[ORM\Column(type: Types::TEXT, length: 20000)]
    #[Assert\NotBlank(message: "Vous devez renseigner une description pour le véhicule.")]
    private string $description;

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

    public function getModels(): ?Model
    {
        return $this->models;
    }

    public function setModels(?Model $models): static
    {
        $this->models = $models;

        return $this;
    }
}
