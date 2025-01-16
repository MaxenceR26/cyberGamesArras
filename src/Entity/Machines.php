<?php

namespace App\Entity;

use App\Repository\MachinesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MachinesRepository::class)]
#[UniqueEntity('name')]
#[UniqueEntity('address')]
class Machines
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\Length(min: 2, max: 50)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(length: 75)]
    #[Assert\Length(min: 2, max: 75)]
    #[Assert\NotBlank]
    private ?string $games = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotNull]
    private ?string $address = null;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $createdAt;

    /*
    * Constructor
    */
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
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

    public function getGames(): ?string
    {
        return $this->games;
    }

    public function setGames(string $games): static
    {
        $this->games = $games;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
