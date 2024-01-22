<?php

namespace App\Entity;

use App\Repository\TestimonialRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TestimonialRepository::class)]
#[UniqueEntity(fields: ['name', 'surname'])]
class Testimonial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type:"string", length: 255)]
    #[Assert\NotBlank("Vous devez renseigner votre nom.")]
    #[Assert\Regex("^[a-zA-ZÀ-ÿ- ']+$
    ")]
    private string $name;

    #[ORM\Column(type:"string", length: 255)]
    #[Assert\NotBlank("Vous devez renseigner votre prénom.")]
    #[Assert\Regex("^[a-zA-ZÀ-ÿ- ']+$
    ")]
    private string $surname;

    #[ORM\Column(type: Types::TEXT, length: 20000)]
    #[Assert\Length(min: 5, max: 20000, minMessage:"Votre commentaire doit avoir au moins {{ limit }} caractères", maxMessage:"Votre commentaire ne doit pas dépasser les {{ limit }} caractères.")]
    private string $message;

    #[ORM\Column(type:"integer")]
    #[Assert\Positive]
    #[Assert\Range(min: 1, max: 5)]
    private int $score;

    #[ORM\Column(nullable: true)]
    private ?bool $is_actif = null;

    #[ORM\ManyToOne(inversedBy: 'testimonials')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Garage $garage = null;

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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function isIsActif(): ?bool
    {
        return $this->is_actif;
    }

    public function setIsActif(?bool $is_actif): static
    {
        $this->is_actif = $is_actif;

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
}
