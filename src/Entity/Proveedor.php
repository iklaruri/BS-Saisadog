<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proveedor
 *
 * @ORM\Table(name="Proveedor")
 * @ORM\Entity
 */
class Proveedor
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
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=30, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="tlf", type="string", length=9, nullable=false)
     */
    private $tlf;

    /**
     * Proveedor constructor.
     * @param string $nombre
     * @param string $email
     * @param string $tlf
     */
    public function __construct(string $nombre, string $email, string $tlf)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->tlf = $tlf;
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
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getTlf(): string
    {
        return $this->tlf;
    }

    /**
     * @param string $tlf
     */
    public function setTlf(string $tlf): void
    {
        $this->tlf = $tlf;
    }

}
