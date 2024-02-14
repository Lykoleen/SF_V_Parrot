<?php

namespace App\Entity;

use App\Repository\GearboxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GearboxRepository::class)]
class Gearbox
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type:"string", length: 255)]
    #[Assert\NotBlank(message: "Vous devez renseigner le type de la boîte de vitesse.")]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'gearboxes', targetEntity: Vehicle::class)]
    private Collection $vehicles;

    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
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
     * @return Collection<int, Vehicle>
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle): static
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles->add($vehicle);
            $vehicle->setGearboxes($this);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): static
    {
        if ($this->vehicles->removeElement($vehicle)) {
            // set the owning side to null (unless already changed)
            if ($vehicle->getGearboxes() === $this) {
                $vehicle->setGearboxes(null);
            }
        }

        return $this;
    }
}
