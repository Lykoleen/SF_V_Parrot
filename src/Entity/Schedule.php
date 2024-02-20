<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type:"string", length: 255)]
    private string $day;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $opening_morning = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $closing_morning = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $opening_afternoon = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $closing_afternoon = null;

    #[ORM\Column(nullable: true)]
    private ?bool $close = null;

    #[ORM\ManyToOne(inversedBy: 'schedules')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Garage $garage = null;

    #[ORM\Column(nullable: true)]
    private ?bool $closedAtLunchtime = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function getOpeningMorning(): ?\DateTimeInterface
    {
        return $this->opening_morning;
    }

    public function setOpeningMorning(?\DateTimeInterface $opening_morning): static
    {
        $this->opening_morning = $opening_morning;

        return $this;
    }

    public function getClosingMorning(): ?\DateTimeInterface
    {
        return $this->closing_morning;
    }

    public function setClosingMorning(?\DateTimeInterface $closing_morning): static
    {
        $this->closing_morning = $closing_morning;

        return $this;
    }

    public function isClose(): ?bool
    {
        return $this->close;
    }

    public function setClose(?bool $close): static
    {
        $this->close = $close;

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

    public function getOpeningAfternoon(): ?\DateTimeInterface
    {
        return $this->opening_afternoon;
    }

    public function setOpeningAfternoon(?\DateTimeInterface $opening_afternoon): static
    {
        $this->opening_afternoon = $opening_afternoon;

        return $this;
    }

    public function getClosingAfternoon(): ?\DateTimeInterface
    {
        return $this->closing_afternoon;
    }

    public function setClosingAfternoon(?\DateTimeInterface $closing_afternoon): static
    {
        $this->closing_afternoon = $closing_afternoon;

        return $this;
    }

    public function isClosedAtLunchtime(): ?bool
    {
        return $this->closedAtLunchtime;
    }

    public function setClosedAtLunchtime(?bool $closedAtLunchtime): static
    {
        $this->closedAtLunchtime = $closedAtLunchtime;

        return $this;
    }
}
