<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, DireccionDeEnvio>
     */
    #[ORM\OneToMany(targetEntity: DireccionDeEnvio::class, mappedBy: 'usuario', orphanRemoval: true)]
    private Collection $direccionDeEnvios;

    /**
     * @var Collection<int, Pedido>
     */
    #[ORM\OneToMany(targetEntity: Pedido::class, mappedBy: 'usuario', orphanRemoval: true)]
    private Collection $pedidos;

    /**
     * @var Collection<int, CarroCompra>
     */
    #[ORM\OneToMany(targetEntity: CarroCompra::class, mappedBy: 'usuario', orphanRemoval: true)]
    private Collection $carroCompras;

    public function __construct($id = null, $email = null, $password = null, $nombre = null)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->direccionDeEnvios = new ArrayCollection();
        $this->pedidos = new ArrayCollection();
        $this->carroCompras = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $pedido->setUsuario($this);
        }

        return $this;
    }

    public function removePedido(Pedido $pedido): static
    {
        if ($this->pedidos->removeElement($pedido)) {
            // set the owning side to null (unless already changed)
            if ($pedido->getUsuario() === $this) {
                $pedido->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CarroCompra>
     */
    public function getCarroCompras(): Collection
    {
        return $this->carroCompras;
    }

    public function addCarroCompra(CarroCompra $carroCompra): static
    {
        if (!$this->carroCompras->contains($carroCompra)) {
            $this->carroCompras->add($carroCompra);
            $carroCompra->setUsuario($this);
        }

        return $this;
    }

    public function removeCarroCompra(CarroCompra $carroCompra): static
    {
        if ($this->carroCompras->removeElement($carroCompra)) {
            // set the owning side to null (unless already changed)
            if ($carroCompra->getUsuario() === $this) {
                $carroCompra->setUsuario(null);
            }
        }

        return $this;
    }
}
