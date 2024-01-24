<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('email', message:"Cette adresse e-mail est déjà utilisée.")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(name:"email", type:"string", length: 180, unique: true)]
    #[Assert\NotBlank(message:"Vous devez saisir une adresse e-mail")]
    #[Assert\Regex(
        pattern:"/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/
    ",
    message:"L'adresse e-mail n'est pas valide.")]
    private string $email;

    /**
     * @var string The hashed password
     */
    #[ORM\Column(type:"string")]
    #[Assert\NotBlank("Vous devez saisir un mot de passe avec au minimum 12 caractères contenant au moins des minuscules, majuscules, chiffres et caractères spéciaux (@, $, !, %, *, ?, &)")]
    #[Assert\Regex("^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$
    ", message:"Vous devez saisir un mot de passe avec au minimum 12 caractères contenant au moins des minuscules, majuscules, chiffres et caractères spéciaux (@, $, !, %, *, ?, &)")]
    #[Assert\EqualTo(propertyPath:"confirmPassword", message:"Les mots de passe ne sont pas identiques")]
    private string $password;

    #[ORM\Column(type:"string")]
    #[Assert\NotBlank("Vous devez confirmer votre mot de passe.")]
    private string $confirmPassword;

    #[ORM\Column(type:"string", length: 255)]
    #[Assert\NotBlank("Vous devez renseigner votre prénom.")]
    private string $firstname;

    #[ORM\Column(type:"string", length: 255)]
    #[Assert\NotBlank("Vous devez renseigner votre nom.")]
    private string $lastname;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\ManyToMany(targetEntity: Garage::class, mappedBy: 'users')]
    private Collection $garages;

    public function __construct()
    {
        $this->garages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

/**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return Collection<int, Garage>
     */
    public function getGarages(): Collection
    {
        return $this->garages;
    }

    public function addGarage(Garage $garage): static
    {
        if (!$this->garages->contains($garage)) {
            $this->garages->add($garage);
            $garage->addUser($this);
        }

        return $this;
    }

    public function removeGarage(Garage $garage): static
    {
        if ($this->garages->removeElement($garage)) {
            $garage->removeUser($this);
        }

        return $this;
    }

    /**
     * Get the value of confirmPassword
     */ 
    public function getConfirmPassword(): string
    {
        return $this->confirmPassword;
    }

    /**
     * Set the value of confirmPassword
     *
     * @return  self
     */ 
    public function setConfirmPassword(string $confirmPassword): static
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
}
