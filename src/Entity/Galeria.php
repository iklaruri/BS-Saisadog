<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Galeria
 *
 * @ORM\Table(name="Galeria", indexes={@ORM\Index(name="codProducto", columns={"codProducto"})})
 * @ORM\Entity
 */
class Galeria
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
     * @var string
     *
     * @ORM\Column(name="ruta", type="string", length=500, nullable=false)
     */
    private $ruta;

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
     * Galeria constructor.
     * @param string $ruta
     * @param Producto $codproducto
     */
    public function __construct(string $ruta, Producto $codproducto)
    {
        $this->ruta = $ruta;
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
     * @return string
     */
    public function getRuta(): string
    {
        return $this->ruta;
    }

    /**
     * @param string $ruta
     */
    public function setRuta(string $ruta): void
    {
        $this->ruta = $ruta;
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
