<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Historial
 *
 * @ORM\Table(name="Historial", indexes={@ORM\Index(name="codProducto", columns={"codProducto"})})
 * @ORM\Entity
 */
class Historial
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
     * @var float
     *
     * @ORM\Column(name="precio", type="float", precision=10, scale=0, nullable=false)
     */
    private $precio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    private $fecha;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_fin", type="datetime", nullable=true)
     */
    private $fechafin;

    /**
     * @var bool
     *
     * @ORM\Column(name="esOferta", type="boolean", nullable=false)
     */
    private $esoferta;

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
     * Historial constructor.
     * @param float $precio
     * @param \DateTime $fecha
     * @param bool $esoferta
     * @param Producto $codproducto
     */
    public function __construct(float $precio, \DateTime $fecha, bool $esoferta,Producto $codproducto)
    {
        $this->precio = $precio;
        $this->fecha = $fecha;
        $this->esoferta = $esoferta;
        $this->codproducto = $codproducto;
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
     * @return float
     */
    public function getPrecio(): float
    {
        return $this->precio;
    }

    /**
     * @param float $precio
     */
    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
    }

    /**
     * @return \DateTime
     */
    public function getFecha(): \DateTime
    {
        return $this->fecha;
    }

    /**
     * @param \DateTime $fecha
     */
    public function setFecha(\DateTime $fecha): void
    {
        $this->fecha = $fecha;
    }

    /**
     * @return \DateTime
     */
    public function getFechafin(): \DateTime
    {
        return $this->fechafin;
    }

    /**
     * @param \DateTime $fechafin
     */
    public function setFechafin(\DateTime $fechafin): void
    {
        $this->fechafin = $fechafin;
    }

    /**
     * @return bool
     */
    public function getEsoferta(): bool
    {
        return $this->esoferta;
    }

    /**
     * @param bool $esoferta
     */
    public function setEsoferta(bool $esoferta): void
    {
        $this->esoferta = $esoferta;
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

}
