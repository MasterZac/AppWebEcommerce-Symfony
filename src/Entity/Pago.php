<?php

namespace App\Entity;

use App\Repository\PagoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PagoRepository::class)]
class Pago
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $monto = null;

    #[ORM\Column(length: 255)]
    private ?string $metodo_pago = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pedido $pedido = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMonto(): ?string
    {
        return $this->monto;
    }

    public function setMonto(string $monto): static
    {
        $this->monto = $monto;

        return $this;
    }

    public function getMetodoPago(): ?string
    {
        return $this->metodo_pago;
    }

    public function setMetodoPago(string $metodo_pago): static
    {
        $this->metodo_pago = $metodo_pago;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getPedido(): ?Pedido
    {
        return $this->pedido;
    }

    public function setPedido(Pedido $pedido): static
    {
        $this->pedido = $pedido;

        return $this;
    }
}
