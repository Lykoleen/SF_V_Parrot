<?php

namespace App\Entity;

use App\Repository\PictureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: PictureRepository::class)]
#[Vich\Uploadable]
class Picture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: 'product', fileNameProperty: 'name')]
    private ?File $path = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'pictures')]
    #[ORM\JoinColumn(nullable: True)]
    private ?Service $services = null;

    #[ORM\ManyToOne(inversedBy: 'pictures')]
    #[ORM\JoinColumn(nullable: True)]
    private ?Product $products = null;

    public function setPath(?File $path = null): void
    {
        $this->path = $path;

        if (null !== $path) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function __toString()
    {
        $nomImage = $this->getName();

        $nomFormate = preg_replace('/-\w{22}\.jpg$/', '.jpg', $nomImage);
        
        return $nomFormate;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?File
    {
        return $this->path;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getServices(): ?Service
    {
        return $this->services;
    }

    public function setServices(?Service $services): static
    {
        $this->services = $services;

        return $this;
    }

    public function getProducts(): ?Product
    {
        return $this->products;
    }

    public function setProducts(?Product $products): static
    {
        $this->products = $products;

        return $this;
    }
}
