<?php

namespace App\Entity;

use App\Repository\PictureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: PictureRepository::class)]
#[UniqueEntity('name')]
class Picture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type:"string", length: 255)]
    private string $name;

    #[ORM\Column(type:"string", length: 255)]
    #[Assert\Regex("^\/?([a-zA-Z0-9_\-]+\/)*[a-zA-Z0-9_\-]+\.[a-zA-Z0-9]+$
    ")]
    private string $path;

    #[ORM\ManyToOne(inversedBy: 'pictures')]
    private ?Service $services = null;

    #[ORM\ManyToOne(inversedBy: 'pictures')]
    private ?Product $product = null;

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

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
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


    /**
     * Get the value of products
     */ 
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * Set the value of products
     *
     * @return  self
     */ 
    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }
}
