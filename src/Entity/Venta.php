<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Venta
 *
 * @ORM\Table(name="Venta", indexes={@ORM\Index(name="codUsuario", columns={"codUsuario"})})
 * @ORM\Entity(repositoryClass="App\Repository\VentaRepository")
 */
class Venta
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=50, nullable=false)
     */
    private $direccion;

    /**
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="codUsuario", referencedColumnName="id")
     * })
     */
    private $codusuario;

    /**
     * Venta constructor.
     * @param \DateTime $fecha
     * @param Usuario $codusuario
     */
    public function __construct(\DateTime $fecha, string $direccion, Usuario $codusuario)
    {
        $this->fecha = $fecha;
        $this->direccion = $direccion;
        $this->codusuario = $codusuario;
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
     * @return string
     */
    public function getDireccion(): string
    {
        return $this->direccion;
    }

    /**
     * @param string $direccion
     */
    public function setDireccion(string $direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return Usuario
     */
    public function getCodusuario(): Usuario
    {
        return $this->codusuario;
    }

    /**
     * @param Usuario $codusuario
     */
    public function setCodusuario(Usuario $codusuario): void
    {
        $this->codusuario = $codusuario;
    }





}
