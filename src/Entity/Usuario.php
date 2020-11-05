<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usuario
 *
 * @ORM\Table(name="Usuario")
 * @ORM\Entity
 */
class Usuario
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
     * @ORM\Column(name="usuario", type="string", length=30, nullable=false)
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=30, nullable=false)
     */
    private $direccion;

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
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=8, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="string", length=155, nullable=false)
     */
    private $foto;

    /**
     * Usuario constructor.
     * @param string $usuario
     * @param string $direccion
     * @param string $email
     * @param string $tlf
     * @param string $password
     * @param string $foto
     */
    public function __construct(string $usuario, string $direccion, string $email, string $tlf, string $password, string $foto)
    {
        $this->usuario = $usuario;
        $this->direccion = $direccion;
        $this->email = $email;
        $this->tlf = $tlf;
        $this->password = $password;
        $this->foto = $foto;
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
    public function getUsuario(): string
    {
        return $this->usuario;
    }

    /**
     * @param string $usuario
     */
    public function setUsuario(string $usuario): void
    {
        $this->usuario = $usuario;
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

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getFoto(): string
    {
        return $this->foto;
    }

    /**
     * @param string $foto
     */
    public function setFoto(string $foto): void
    {
        $this->foto = $foto;
    }




}
