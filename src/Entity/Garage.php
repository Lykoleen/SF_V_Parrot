<?php

namespace App\Entity;

use App\Repository\GarageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: GarageRepository::class)]
#[UniqueEntity('email', message:"Cette adresse email est déjà utilisée.")]
class Garage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type:"string", length: 255)]
    #[Assert\NotBlank("Vous devez renseigner le nom du garage.")]
    private string $name;

    #[ORM\Column(type:"string", length: 255)]
    #[Assert\NotBlank("Vous devez renseigner l'email du garage.")]
    #[Assert\Regex(
        pattern:"/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/
    ",
    message:"L'adresse e-mail n'est pas valide.")]
    private string $email;

    #[ORM\Column(type:"string", length: 255)]
    #[Assert\NotBlank("Vous devez renseigner l'adresse' du garage.")]
    private string $adress;

    #[ORM\Column(type:"integer", nullable: true)]
    #[Assert\NotBlank("Vous devez renseigner le numéro de téléphone du garage.")]
    private int $tel;

    #[ORM\OneToMany(mappedBy: 'garage', targetEntity: testimonial::class, orphanRemoval: true)]
    private Collection $testimonials;

    #[ORM\OneToMany(mappedBy: 'garage', targetEntity: Schedule::class, orphanRemoval: true)]
    private Collection $schedules;

    #[ORM\ManyToMany(targetEntity: Service::class)]
    private Collection $services;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'garages')]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'garage', targetEntity: Product::class, orphanRemoval: true)]
    private Collection $products;

    public function __construct()
    {
        $this->testimonials = new ArrayCollection();
        $this->schedules = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->products = new ArrayCollection();
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

    public function getemail(): ?string
    {
        return $this->email;
    }

    public function setemail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): static
    {
        $this->adress = $adress;

        return $this;
    }

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(?int $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * @return Collection<int, testimonial>
     */
    public function getTestimonials(): Collection
    {
        return $this->testimonials;
    }

    public function addTestimonial(testimonial $testimonial): static
    {
        if (!$this->testimonials->contains($testimonial)) {
            $this->testimonials->add($testimonial);
            $testimonial->setGarage($this);
        }

        return $this;
    }

    public function removeTestimonial(testimonial $testimonial): static
    {
        if ($this->testimonials->removeElement($testimonial)) {
            // set the owning side to null (unless already changed)
            if ($testimonial->getGarage() === $this) {
                $testimonial->setGarage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Schedule>
     */
    public function getSchedules(): Collection
    {
        return $this->schedules;
    }

    public function addSchedule(Schedule $schedule): static
    {
        if (!$this->schedules->contains($schedule)) {
            $this->schedules->add($schedule);
            $schedule->setGarage($this);
        }

        return $this;
    }

    public function removeSchedule(Schedule $schedule): static
    {
        if ($this->schedules->removeElement($schedule)) {
            // set the owning side to null (unless already changed)
            if ($schedule->getGarage() === $this) {
                $schedule->setGarage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): static
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
        }

        return $this;
    }

    public function removeService(Service $service): static
    {
        $this->services->removeElement($service);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->users->removeElement($user);

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setGarage($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getGarage() === $this) {
                $product->setGarage(null);
            }
        }

        return $this;
    }
}
