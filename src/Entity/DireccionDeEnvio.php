<?php

namespace App\Entity;

use App\Repository\DireccionDeEnvioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DireccionDeEnvioRepository::class)]
class DireccionDeEnvio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'direccionDeEnvios')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $usuario = null;

    #[ORM\Column(length: 255)]
    private ?string $Calle = null;

    #[ORM\Column(length: 255)]
    private ?string $Ciudad = null;

    #[ORM\Column]
    private ?int $codigoPostal = null;

    #[ORM\Column(length: 255)]
    private ?string $Pais = null;
    
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $informacion_adicional = null;

    /**
     * @var Collection<int, Pedido>
     */
    #[ORM\OneToMany(targetEntity: Pedido::class, mappedBy: 'direccion_envio', orphanRemoval: true)]
    private Collection $pedidos;

    public function __construct()
    {
        $this->pedidos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getCalle(): ?string
    {
        return $this->Calle;
    }

    public function setCalle(string $Calle): static
    {
        $this->Calle = $Calle;

        return $this;
    }

    public function getCiudad(): ?string
    {
        return $this->Ciudad;
    }

    public function setCiudad(string $Ciudad): static
    {
        $this->Ciudad = $Ciudad;

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
        return $this->Pais;
    }

    public function setPais(string $Pais): static
    {
        $this->Pais = $Pais;

        return $this;
    }

    public function getInformacionAdicional(): ?string
    {
        return $this->informacion_adicional;
    }

    public function setInformacionAdicional(?string $informacion_adicional): static
    {
        $this->informacion_adicional = $informacion_adicional;

        return $this;
    }

    /**
     * @return Collection<int, Pedido>
     */
    public function getPedidos(): Collection
    {
        return $this->pedidos;
    }

    public function addPedido(Pedido $pedido): static
    {
        if (!$this->pedidos->contains($pedido)) {
            $this->pedidos->add($pedido);
            $pedido->setDireccionEnvio($this);
        }

        return $this;
    }

    public function removePedido(Pedido $pedido): static
    {
        if ($this->pedidos->removeElement($pedido)) {
            // set the owning side to null (unless already changed)
            if ($pedido->getDireccionEnvio() === $this) {
                $pedido->setDireccionEnvio(null);
            }
        }

        return $this;
    }
}
