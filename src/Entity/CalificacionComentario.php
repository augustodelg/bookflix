<?php

namespace App\Entity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use ProxyManager\ProxyGenerator\ValueHolder\MethodGenerator\Constructor;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CalificacionComentarioRepository")
 * 
 * @UniqueEntity(
 *      fields={"perfil", "libro"},
 *      message="Ya realizaste un comentario y/o calificacion para este libro."    
 * )
 */
class CalificacionComentario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $texto;

    /**
     * @ORM\Column(type="integer")
     * @Assert\LessThanOrEqual(5)
     */
    private $calificacion;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $spoiler;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Perfil", inversedBy="calificacionesComentarios")
     * @ORM\JoinColumn(nullable=false)
     */
    private $perfil;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Libro", inversedBy="calificacionesComentarios")
     * @ORM\JoinColumn(nullable=false)
     */
    private $libro;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;


    public function __construct()
    {
        $this->setUpdatedAt(new \DateTime('now'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTexto(): ?string
    {
        return $this->texto;
    }

    public function setTexto(?string $texto): self
    {
        $this->texto = $texto;

        return $this;
    }

    public function getCalificacion(): ?int
    {
        return $this->calificacion;
    }

    public function setCalificacion(int $calificacion): self
    {
        $this->calificacion = $calificacion;

        return $this;
    }

    public function getSpoiler(): ?bool
    {
        return $this->spoiler;
    }

    public function setSpoiler(?bool $spoiler): self
    {
        $this->spoiler = $spoiler;

        return $this;
    }

    public function getPerfil(): ?Perfil
    {
        return $this->perfil;
    }

    public function setPerfil(?Perfil $perfil): self
    {
        $this->perfil = $perfil;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
