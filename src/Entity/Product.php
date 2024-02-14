<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"product_type", type:"string")]
#[ORM\DiscriminatorMap(['product' => Product::class, 'vehicle' => Vehicle::class])]
#[UniqueEntity('title', message:"Ce produit existe déjà.")]

class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"IDENTITY")] // Spécifie le générateur d'identifiant pour Product et Vehicle ici.
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type:"string", length: 255, unique: true)]
    #[Assert\NotBlank(message: "Veuillez renseigner le nom du produit.")]
    private string $title;

    #[ORM\Column(type:"float")]
    #[Assert\NotBlank(message: "Veuiller renseigner le prix du produit.")]
    #[Assert\PositiveOrZero(message: "Le prix doit être supérieur ou égal à 0")]
    private float $price;

    #[ORM\Column(type:"integer", nullable: true)]
    #[Assert\NotBlank(message: "Veuiller renseigner la quantité du produit.")]
    #[Assert\PositiveOrZero(message: "La quantité doit être supérieure ou égale à 0")]
    private int $quantity;

    #[ORM\Column(nullable: true)]
    private ?bool $availability = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Garage $garage = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $categories = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $types = null;

    #[ORM\OneToMany(mappedBy: 'products', targetEntity: Picture::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $pictures;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
    }

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
            $picture->setProducts($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): static
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getProducts() === $this) {
                $picture->setProducts(null);
            }
        }

        return $this;
    }

}
