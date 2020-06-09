<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdelantoRepository")
 * @UniqueEntity(
 *      fields={"libro"},
 *      message="Ese libro ya contiene un adelanto."    
 * )
 */
class Adelanto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titulo;

    /**
     * @ORM\Column(type="string", length=99999)
     */
    private $contenido;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Libro", inversedBy="adelanto", cascade={"persist", "remove"})
     */
    private $libro;

     /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        
        if ($titulo) {

            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    public function getContenido(): ?string
    {
        return $this->contenido;
    }

    public function setContenido(string $contenido): self
    {
        $this->contenido = $contenido;

        return $this;
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

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;

    }


}
