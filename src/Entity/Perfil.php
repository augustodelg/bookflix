<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PerfilRepository")
 */
class Perfil
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
    private $nombre;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Libro", inversedBy="perfils")
     */
    private $favoritos;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cuenta", inversedBy="perfiles")
     */
    private $cuenta;

    /**
     * @ORM\Column(type="boolean")
     */
    private $activo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CalificacionComentario", mappedBy="perfil", orphanRemoval=true)
     */
    private $calificacionesComentarios;

    public function __construct()
    {
        $this->favoritos = new ArrayCollection();
        $this->calificacionesComentarios = new ArrayCollection();
    }
 
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection|Libro[]
     */
    public function getFavoritos(): Collection
    {
        return $this->favoritos;
    }

    public function addFavorito(Libro $favorito): self
    {
        if (!$this->favoritos->contains($favorito)) {
            $this->favoritos[] = $favorito;
        }

        return $this;
    }

    public function removeFavorito(Libro $favorito): self
    {
        if ($this->favoritos->contains($favorito)) {
            $this->favoritos->removeElement($favorito);
        }

        return $this;
    } 

    public function getCuenta(): ?Cuenta
    {
        return $this->cuenta;
    }

    public function setCuenta(?Cuenta $cuenta): self
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * @return Collection|CalificacionComentario[]
     */
    public function getCalificacionesComentarios(): Collection
    {
        return $this->calificacionesComentarios;
    }

    public function addCalificacionesComentario(CalificacionComentario $calificacionesComentario): self
    {
        if (!$this->calificacionesComentarios->contains($calificacionesComentario)) {
            $this->calificacionesComentarios[] = $calificacionesComentario;
            $calificacionesComentario->setPerfil($this);
        }

        return $this;
    }

    public function removeCalificacionesComentario(CalificacionComentario $calificacionesComentario): self
    {
        if ($this->calificacionesComentarios->contains($calificacionesComentario)) {
            $this->calificacionesComentarios->removeElement($calificacionesComentario);
            // set the owning side to null (unless already changed)
            if ($calificacionesComentario->getPerfil() === $this) {
                $calificacionesComentario->setPerfil(null);
            }
        }

        return $this;
    }

    public function getCalificacionesComentariosLibro(): Collection
    {

    }
}
