<?php

namespace App\Entity;

use App\Repository\DireccionDeEnvioRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DireccionDeEnvioRepository::class)]
class DireccionDeEnvio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $calle = null;

    #[ORM\Column(length: 255)]
    private ?string $ciudad = null;

    #[ORM\Column]
    private ?int $codigoPostal = null;

    #[ORM\Column(length: 255)]
    private ?string $pais = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $informacionAdicional = null;

    #[ORM\ManyToOne(inversedBy: 'direccionDeEnvios')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuarios $usuario = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCalle(): ?string
    {
        return $this->calle;
    }

    public function setCalle(string $calle): static
    {
        $this->calle = $calle;

        return $this;
    }

    public function getCiudad(): ?string
    {
        return $this->ciudad;
    }

    public function setCiudad(string $ciudad): static
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    public function getCodigoPostal(): ?int
    {
        return $this->codigoPostal;
    }

    public function setCodigoPostal(int $codigoPostal): static
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    public function getPais(): ?string
    {
        return $this->pais;
    }

    public function setPais(string $pais): static
    {
        $this->pais = $pais;

        return $this;
    }

    public function getInformacionAdicional(): ?string
    {
        return $this->informacionAdicional;
    }

    public function setInformacionAdicional(?string $informacionAdicional): static
    {
        $this->informacionAdicional = $informacionAdicional;

        return $this;
    }

    public function getUsuario(): ?Usuarios
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuarios $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }
}
