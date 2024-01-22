<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[UniqueEntity('title', message:"Ce produit existe déjà.")]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type:"string", length: 255, unique: true)]
    #[Assert\NotBlank("Veuillez renseigner le nom du produit.")]
    private string $title;

    #[ORM\Column(type:"integer")]
    #[Assert\NotBlank("Veuiller renseigner le prix du produit.")]
    #[Assert\PositiveOrZero("Le prix doit être supérieur ou égal à 0")]
    private float $price;

    #[ORM\Column(type:"integer")]
    #[Assert\NotBlank("Veuiller renseigner la quantité du produit.")]
    #[Assert\PositiveOrZero("La quantité doit être supérieure ou égale à 0")]
    private int $quantity;

    #[ORM\Column(nullable: true)]
    private ?bool $availability = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Garage $garage = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?category $categories = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?type $types = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function isAvailability(): ?bool
    {
        return $this->availability;
    }

    public function setAvailability(?bool $availability): static
    {
        $this->availability = $availability;

        return $this;
    }

    public function getGarage(): ?Garage
    {
        return $this->garage;
    }

    public function setGarage(?Garage $garage): static
    {
        $this->garage = $garage;

        return $this;
    }

    public function getCategories(): ?category
    {
        return $this->categories;
    }

    public function setCategories(?category $categories): static
    {
        $this->categories = $categories;

        return $this;
    }

    public function getTypes(): ?type
    {
        return $this->types;
    }

    public function setTypes(?type $types): static
    {
        $this->types = $types;

        return $this;
    }
}
