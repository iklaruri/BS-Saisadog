<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductoGenero
 *
 * @ORM\Table(name="ProductoGenero", indexes={@ORM\Index(name="codGenero", columns={"codGenero"}), @ORM\Index(name="codProducto", columns={"codProducto"})})
 * @ORM\Entity(repositoryClass="App\Repository\ProductoGeneroRepository")
 */
class ProductoGenero
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
     * @var Genero
     *
     * @ORM\ManyToOne(targetEntity="Genero")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="codGenero", referencedColumnName="id")
     * })
     */
    private $codgenero;

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
     * ProductoGenero constructor.
     * @param Genero $codgenero
     * @param Producto $codproducto
     */
    public function __construct(Genero $codgenero, Producto $codproducto)
    {
        $this->codgenero = $codgenero;
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
     * @return Genero
     */
    public function getCodgenero(): Genero
    {
        return $this->codgenero;
    }

    /**
     * @param Genero $codgenero
     */
    public function setCodgenero(Genero $codgenero): void
    {
        $this->codgenero = $codgenero;
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
