<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RegistroEventosRepository")
 */
class RegistroEventos
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_cuenta;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_perfil;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_libro;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $id_capitulo;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCuenta(): ?int
    {
        return $this->id_cuenta;
    }

    public function setIdCuenta(int $id_cuenta): self
    {
        $this->id_cuenta = $id_cuenta;

        return $this;
    }

    public function getIdPerfil(): ?int
    {
        return $this->id_perfil;
    }

    public function setIdPerfil(int $id_perfil): self
    {
        $this->id_perfil = $id_perfil;

        return $this;
    }

    public function getIdLibro(): ?int
    {
        return $this->id_libro;
    }

    public function setIdLibro(int $id_libro): self
    {
        $this->id_libro = $id_libro;

        return $this;
    }

    public function getIdCapitulo(): ?int
    {
        return $this->id_capitulo;
    }

    public function setIdCapitulo(?int $id_capitulo): self
    {
        $this->id_capitulo = $id_capitulo;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }
}
