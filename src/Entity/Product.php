<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"product_type", type:"string")]
#[ORM\DiscriminatorMap(['product' => Product::class, 'vehicle' => Vehicle::class])]
#[UniqueEntity('title', message:"Ce produit existe déjà.")]
#[Vich\Uploadable]
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

    #[ORM\Column(type:"integer")]
    #[Assert\NotBlank(message: "Veuiller renseigner la quantité du produit.")]
    #[Assert\PositiveOrZero(message: "La quantité doit être supérieure ou égale à 0")]
    private int $quantity;

    #[ORM\Column(nullable: true)]
    private ?bool $availability = null;

    #[Vich\UploadableField(mapping: 'product', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Garage $garage = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $categories = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $types = null;

    public function __construct()
    {
        
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
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

}
