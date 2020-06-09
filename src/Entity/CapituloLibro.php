<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CapituloLibroRepository")
 */
class CapituloLibro
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
    private $nro;

    /**
     * @ORM\Column(type="date")
     */
    private $fechaDisponible;

    /**
     * @ORM\Column(type="date")
     */
    private $fechaVencimiento;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Libro", inversedBy="capituloLibros")
     * @ORM\JoinColumn(nullable=false)
     */
    private $libro;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNro(): ?int
    {
        return $this->nro;
    }

    public function setNro(int $nro): self
    {
        $this->nro = $nro;

        return $this;
    }

    public function getFechaDisponible(): ?\DateTimeInterface
    {
        return $this->fechaDisponible;
    }

    public function setFechaDisponible(\DateTimeInterface $fechaDisponible): self
    {
        $this->fechaDisponible = $fechaDisponible;

        return $this;
    }

    public function getFechaVencimiento(): ?\DateTimeInterface
    {
        return $this->fechaVencimiento;
    }

    public function setFechaVencimiento(\DateTimeInterface $fechaVencimiento): self
    {
        $this->fechaVencimiento = $fechaVencimiento;

        return $this;
    }
    public function __toString()
    {
        return $this->nro;
    }

    public function getLibro(): ?Libro
    {
        return $this->libro;
    }

    public function setLibro(?Libro $libro): self
    {
        $this->libro = $libro;

        return $this;
    }
}
