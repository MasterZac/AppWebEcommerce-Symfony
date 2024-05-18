<?php

namespace App\Entity;

use App\Repository\ProductosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductosRepository::class)]
class Productos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descripcion = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $precio = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\ManyToOne(inversedBy: 'productos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorias $categoria = null;

    /**
     * @var Collection<int, CarroCompra>
     */
    #[ORM\OneToMany(targetEntity: CarroCompra::class, mappedBy: 'producto', orphanRemoval: true)]
    private Collection $carroCompras;

    public function __construct()
    {
        $this->carroCompras = new ArrayCollection();
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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getPrecio(): ?string
    {
        return $this->precio;
    }

    public function setPrecio(string $precio): static
    {
        $this->precio = $precio;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getCategoria(): ?Categorias
    {
        return $this->categoria;
    }

    public function setCategoria(?Categorias $categoria): static
    {
        $this->categoria = $categoria;

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
            $carroCompra->setProducto($this);
        }

        return $this;
    }

    public function removeCarroCompra(CarroCompra $carroCompra): static
    {
        if ($this->carroCompras->removeElement($carroCompra)) {
            // set the owning side to null (unless already changed)
            if ($carroCompra->getProducto() === $this) {
                $carroCompra->setProducto(null);
            }
        }

        return $this;
    }
}
