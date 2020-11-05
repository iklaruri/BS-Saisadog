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
    public function __construct(\DateTime $fecha, Usuario $codusuario)
    {
        $this->fecha = $fecha;
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
