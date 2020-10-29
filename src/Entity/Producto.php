<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Producto
 *
 * @ORM\Table(name="Producto", indexes={@ORM\Index(name="codArtista", columns={"codArtista"})})
 * @ORM\Entity
 */
class Producto
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
     * @ORM\Column(name="nombre", type="string", length=80, nullable=false)
     */
    private $nombre;

    /**
     * @var int
     *
     * @ORM\Column(name="stock", type="integer", nullable=false)
     */
    private $stock;

    /**
     * @var Artista
     *
     * @ORM\ManyToOne(targetEntity="Artista")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="codArtista", referencedColumnName="id")
     * })
     */
    private $codartista;

    /**
     * @var TipoProducto
     *
     * @ORM\ManyToOne(targetEntity="TipoProducto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="codTipoProducto", referencedColumnName="id")
     * })
     */
    private $codtipoProducto;

    /**
     * Producto constructor.
     * @param string $nombre
     * @param int $stock
     * @param Artista $codartista
     * @param TipoProducto $codtipoProducto
     */
    public function __construct(string $nombre, int $stock, Artista $codartista, TipoProducto $codtipoProducto)
    {
        $this->nombre = $nombre;
        $this->stock = $stock;
        $this->codartista = $codartista;
        $this->codtipoProducto = $codtipoProducto;
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
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
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
     * @return Artista
     */
    public function getCodartista(): Artista
    {
        return $this->codartista;
    }

    /**
     * @param Artista $codartista
     */
    public function setCodartista(Artista $codartista): void
    {
        $this->codartista = $codartista;
    }

    /**
     * @return TipoProducto
     */
    public function getCodtipoProducto(): TipoProducto
    {
        return $this->codtipoProducto;
    }

    /**
     * @param TipoProducto $codtipoProducto
     */
    public function setCodtipoProducto(TipoProducto $codtipoProducto): void
    {
        $this->codtipoProducto = $codtipoProducto;
    }




}
