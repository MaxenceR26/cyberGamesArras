<?php

namespace App\Entity;

use App\Repository\TokenRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TokenRepository::class)]
class Token
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $token = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $hours;

    #[ORM\Column]
    private ?int $machineId = null;

    #[ORM\Column]
    private ?int $idUser = null;

    #[ORM\Column(length: 255)]
    private ?string $machine_name = null;

    /*
    *
    *  Constructeur
    *
    */

    public function __construct()
    {
        $this->hours = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function getHours(): ?\DateTimeInterface
    {
        return $this->hours;
    }

    public function setHours(\DateTimeInterface $hours): static
    {
        $this->hours = $hours;

        return $this;
    }

    public function getMachineId(): ?int
    {
        return $this->machineId;
    }

    public function setMachineId(int $machineId): static
    {
        $this->machineId = $machineId;

        return $this;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getMachineName(): ?string
    {
        return $this->machine_name;
    }

    public function setMachineName(string $machine_name): static
    {
        $this->machine_name = $machine_name;

        return $this;
    }

}
