<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProveedorArticulo
 *
 * @ORM\Table(name="ProveedorArticulo", indexes={@ORM\Index(name="codProducto", columns={"codProducto"}), @ORM\Index(name="codProveedor", columns={"codProveedor"})})
 * @ORM\Entity
 */
class ProveedorArticulo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="cantidad", type="integer", nullable=false)
     */
    private $cantidad;

    /**
     * @var Producto
     *
     * @ORM\ManyToOne(targetEntity="Producto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="codProducto", referencedColumnName="id")
     * })
     */
    private $codproducto;

    /**
     * @var Proveedor
     *
     * @ORM\ManyToOne(targetEntity="Proveedor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="codProveedor", referencedColumnName="id")
     * })
     */
    private $codproveedor;

    /**
     * ProveedorArticulo constructor.
     * @param int $cantidad
     * @param Producto $codproducto
     * @param Proveedor $codproveedor
     */
    public function __construct(int $cantidad, Producto $codproducto, Proveedor $codproveedor)
    {
        $this->cantidad = $cantidad;
        $this->codproducto = $codproducto;
        $this->codproveedor = $codproveedor;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    /**
     * @param int $cantidad
     */
    public function setCantidad(int $cantidad): void
    {
        $this->cantidad = $cantidad;
    }

    /**
     * @return Producto
     */
    public function getCodproducto(): Producto
    {
        return $this->codproducto;
    }

    /**
     * @param Producto $codproducto
     */
    public function setCodproducto(Producto $codproducto): void
    {
        $this->codproducto = $codproducto;
    }

    /**
     * @return Proveedor
     */
    public function getCodproveedor(): Proveedor
    {
        return $this->codproveedor;
    }

    /**
     * @param Proveedor $codproveedor
     */
    public function setCodproveedor(Proveedor $codproveedor): void
    {
        $this->codproveedor = $codproveedor;
    }

}
