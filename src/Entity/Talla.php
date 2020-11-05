<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Talla
 *
 * @ORM\Table(name="Talla", indexes={@ORM\Index(name="codProducto", columns={"codProducto"}), @ORM\Index(name="codTallaje", columns={"codTallaje"})})
 * @ORM\Entity(repositoryClass="App\Repository\TallaRepository")
 */
class Talla
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
     * @ORM\Column(name="stock", type="integer", nullable=false)
     */
    private $stock;

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
     * @var Tallaje
     *
     * @ORM\ManyToOne(targetEntity="Tallaje")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="codTallaje", referencedColumnName="id")
     * })
     */
    private $codtallaje;

    /**
     * Talla constructor.
     * @param int $stock
     * @param Producto $codproducto
     * @param Tallaje $codtallaje
     */
    public function __construct(int $stock, Producto $codproducto, Tallaje $codtallaje)
    {
        $this->stock = $stock;
        $this->codproducto = $codproducto;
        $this->codtallaje = $codtallaje;
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
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @param int $stock
     */
    public function setStock(int $stock): void
    {
        $this->stock = $stock;
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
     * @return Tallaje
     */
    public function getCodtallaje(): Tallaje
    {
        return $this->codtallaje;
    }

    /**
     * @param Tallaje $codtallaje
     */
    public function setCodtallaje(Tallaje $codtallaje): void
    {
        $this->codtallaje = $codtallaje;
    }

}
