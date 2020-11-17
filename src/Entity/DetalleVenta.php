<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetalleVenta
 *
 * @ORM\Table(name="DetalleVenta", indexes={@ORM\Index(name="codProducto", columns={"codProducto"}), @ORM\Index(name="codVenta", columns={"codVenta"})})
 * @ORM\Entity(repositoryClass="App\Repository\DetalleVentaRepository")
 */
class DetalleVenta
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
     * @var string
     *
     * @ORM\Column(name="talla", type="string", length=10, nullable=false)
     */
    private $talla;

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
     * @var Venta
     *
     * @ORM\ManyToOne(targetEntity="Venta")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="codVenta", referencedColumnName="id")
     * })
     */
    private $codventa;

    /**
     * DetalleVenta constructor.
     * @param int $cantidad
     * @param string $talla
     * @param Producto $codproducto
     * @param Venta $codventa
     */
    public function __construct(int $cantidad, string $talla,Producto $codproducto, Venta $codventa)
    {
        $this->cantidad = $cantidad;
        $this->talla = $talla;
        $this->codproducto = $codproducto;
        $this->codventa = $codventa;
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
     * @return string
     */
    public function getTalla(): string
    {
        return $this->talla;
    }

    /**
     * @param string $talla
     */
    public function setTalla(string $talla): void
    {
        $this->talla = $talla;
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
     * @return Venta
     */
    public function getCodventa(): Venta
    {
        return $this->codventa;
    }

    /**
     * @param Venta $codventa
     */
    public function setCodventa(Venta $codventa): void
    {
        $this->codventa = $codventa;
    }





}
