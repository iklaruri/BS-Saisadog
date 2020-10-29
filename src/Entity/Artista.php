<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Artista
 *
 * @ORM\Table(name="Artista")
 * @ORM\Entity
 */
class Artista
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
     * @ORM\Column(name="nombre", type="string", length=30, nullable=false)
     */
    private $nombre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFundacion", type="date", nullable=false)
     */
    private $fechafundacion;

    /**
     * Artista constructor.
     * @param string $nombre
     * @param \DateTime $fechafundacion
     */
    public function __construct(string $nombre, \DateTime $fechafundacion)
    {
        $this->nombre = $nombre;
        $this->fechafundacion = $fechafundacion;
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
     * @return \DateTime
     */
    public function getFechafundacion(): \DateTime
    {
        return $this->fechafundacion;
    }

    /**
     * @param \DateTime $fechafundacion
     */
    public function setFechafundacion(\DateTime $fechafundacion): void
    {
        $this->fechafundacion = $fechafundacion;
    }




}
