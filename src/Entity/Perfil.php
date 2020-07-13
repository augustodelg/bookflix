<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\RegistroEventosRepository;
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RegistroLibro", mappedBy="perfil")
     */
    private $historial;

    public function __construct()
    {
        $this->favoritos = new ArrayCollection();
        $this->calificacionesComentarios = new ArrayCollection();
        $this->historial = new ArrayCollection();
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

    /**
     * @return Collection|RegistroLibro[]
     */
    public function getHistorial(): Collection
    {
        return $this->historial;
    }

    public function addHistorial(RegistroLibro $historial): self
    {
        if (!$this->historial->contains($historial)) {
            $this->historial[] = $historial;
            $historial->setPerfil($this);
        }

        return $this;
    }

    public function removeHistorial(RegistroLibro $historial): self
    {
        if ($this->historial->contains($historial)) {
            $this->historial->removeElement($historial);
            // set the owning side to null (unless already changed)
            if ($historial->getPerfil() === $this) {
                $historial->setPerfil(null);
            }
        }

        return $this;
    }

    public function contieneLibro(Libro $libro)
    {
        $historial_libros = $this->getHistorial();
        $contiene = null;
        for ($i=0; $i < count($historial_libros); $i++)
        {
            $libroHistorial = $historial_libros[$i]->getLibro();
            if ($libro->getId() == $libroHistorial->getId() )
            {
                $contiene = $historial_libros[$i];
                break;
            }
        }
        return $contiene;


    }
/**
 * 
 */
    public function cantidadCapitulosLeidos($libro_id,RegistroEventosRepository $registroEventosRepository)
    {
        $registros = $registroEventosRepository->buscarRegistros($libro_id,$this->getId(),$this->getCuenta()->getId());
        return count($registros);
    }

}
