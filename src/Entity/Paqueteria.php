<?php

namespace App\Entity;

use App\Repository\PaqueteriaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaqueteriaRepository::class)]
class Paqueteria
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $compañia_envio = null;

    #[ORM\Column(length: 255)]
    private ?string $numero_seguimiento = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_envio = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pedido $pedido = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompañiaEnvio(): ?string
    {
        return $this->compañia_envio;
    }

    public function setCompañiaEnvio(string $compañia_envio): static
    {
        $this->compañia_envio = $compañia_envio;

        return $this;
    }

    public function getNumeroSeguimiento(): ?string
    {
        return $this->numero_seguimiento;
    }

    public function setNumeroSeguimiento(string $numero_seguimiento): static
    {
        $this->numero_seguimiento = $numero_seguimiento;

        return $this;
    }

    public function getFechaEnvio(): ?\DateTimeInterface
    {
        return $this->fecha_envio;
    }

    public function setFechaEnvio(\DateTimeInterface $fecha_envio): static
    {
        $this->fecha_envio = $fecha_envio;

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
