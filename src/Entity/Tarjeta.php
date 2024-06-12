<?php

namespace App\Entity;

use App\Repository\TarjetaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TarjetaRepository::class)]
class Tarjeta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 16)]
    private ?string $numero_Tarjeta = null;

    #[ORM\Column(length: 5)]
    private ?string $Fecha_expiracion = null;

    #[ORM\Column(length: 3)]
    private ?string $cvv = null;

    #[ORM\ManyToOne(inversedBy: 'tarjetas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroTarjeta(): ?string
    {
        return $this->numero_Tarjeta;
    }

    public function setNumeroTarjeta(string $numero_Tarjeta): static
    {
        $this->numero_Tarjeta = $numero_Tarjeta;

        return $this;
    }

    public function getFechaExpiracion(): ?string
    {
        return $this->Fecha_expiracion;
    }

    public function setFechaExpiracion(string $Fecha_expiracion): static
    {
        $this->Fecha_expiracion = $Fecha_expiracion;

        return $this;
    }

    public function getCvv(): ?string
    {
        return $this->cvv;
    }

    public function setCvv(string $cvv): static
    {
        $this->cvv = $cvv;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
