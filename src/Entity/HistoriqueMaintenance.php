<?php

namespace App\Entity;

use App\Repository\HistoriqueMaintenanceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoriqueMaintenanceRepository::class)]
class HistoriqueMaintenance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Machines $machine = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $heureMaintenance = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $finMaintenance = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMachine(): ?Machines
    {
        return $this->machine;
    }

    public function setMachine(?Machines $machine): static
    {
        $this->machine = $machine;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getHeureMaintenance(): ?\DateTimeInterface
    {
        return $this->heureMaintenance;
    }

    public function setHeureMaintenance(\DateTimeInterface $heureMaintenance): static
    {
        $this->heureMaintenance = $heureMaintenance;

        return $this;
    }

    public function getFinMaintenance(): ?\DateTimeInterface
    {
        return $this->finMaintenance;
    }

    public function setFinMaintenance(?\DateTimeInterface $finMaintenance): static
    {
        $this->finMaintenance = $finMaintenance;

        return $this;
    }
}
