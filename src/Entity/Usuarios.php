<?php

namespace App\Entity;

use App\Repository\UsuariosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsuariosRepository::class)]
class Usuarios
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\ManyToOne(inversedBy: 'usuarios')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Roles $rol = null;

    /**
     * @var Collection<int, DireccionDeEnvio>
     */
    #[ORM\OneToMany(targetEntity: DireccionDeEnvio::class, mappedBy: 'usuario', orphanRemoval: true)]
    private Collection $direccionDeEnvios;

    public function __construct()
    {
        $this->direccionDeEnvios = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRol(): ?Roles
    {
        return $this->rol;
    }

    public function setRol(?Roles $rol): static
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * @return Collection<int, DireccionDeEnvio>
     */
    public function getDireccionDeEnvios(): Collection
    {
        return $this->direccionDeEnvios;
    }

    public function addDireccionDeEnvio(DireccionDeEnvio $direccionDeEnvio): static
    {
        if (!$this->direccionDeEnvios->contains($direccionDeEnvio)) {
            $this->direccionDeEnvios->add($direccionDeEnvio);
            $direccionDeEnvio->setUsuario($this);
        }

        return $this;
    }

    public function removeDireccionDeEnvio(DireccionDeEnvio $direccionDeEnvio): static
    {
        if ($this->direccionDeEnvios->removeElement($direccionDeEnvio)) {
            // set the owning side to null (unless already changed)
            if ($direccionDeEnvio->getUsuario() === $this) {
                $direccionDeEnvio->setUsuario(null);
            }
        }

        return $this;
    }
}
