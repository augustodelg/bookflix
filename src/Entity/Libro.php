<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use DateTime;


/**
 * @ORM\Entity(repositoryClass="App\Repository\LibroRepository")
 * @UniqueEntity(
 *      fields={"isbn"},
 *      message="Ese ISBN ya se encuentra registrado."    
 * )
 * @Vich\Uploadable
 */
class Libro
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
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Autor", inversedBy="libro")
     * @ORM\JoinColumn(nullable=false)
     */
    private $autor;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Genero", inversedBy="libros")
     */
    private $generos;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Perfil", mappedBy="favoritos")
     */
     private $perfiles;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Editorial", inversedBy="libros")
     * @ORM\JoinColumn(nullable=false)
     */
    private $editorial;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ano;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Isbn(
     *      type = "isbn10",
     *      message = "Este valor no es valido."
     * )
     */
    private $isbn;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $foto;

    /**
     * @Vich\UploadableField(mapping="libros_images", fileNameProperty="foto")
     * @var File
     */
    private $fotoFile;

     /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Adelanto", mappedBy="libro", cascade={"persist", "remove"})
     */
    private $adelanto;

    /**
     * @ORM\Column(type="boolean")
     */
    private $completo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CapituloLibro", mappedBy="libro", orphanRemoval=true, cascade={"persist"})
     */
    private $capituloLibros;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cantCapitulos;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $tipoDeCarga;
    // INDICA COMO SE SUBE EL LIBRO true = libro completo  --  false = por capitulo
 

    public function __construct()
    {
        $this->generos = new ArrayCollection();
        $this->perfiles = new ArrayCollection();
        $this->capituloLibros = new ArrayCollection();
        $this->completo=false ;
    }

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

        return $this;
    }


    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getAutor(): ?Autor
    {
        return $this->autor;
    }

    public function setAutor(?Autor $autor): self
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * @return Collection|genero[]
     */
    public function getGeneros(): Collection
    {
        return $this->generos;
    }

    public function addGenero(genero $genero): self
    {
        if (!$this->generos->contains($genero)) {
            $this->generos[] = $genero;
        }

        return $this;
    }

    public function removeGenero(genero $genero): self
    {
        if ($this->generos->contains($genero)) {
            $this->generos->removeElement($genero);
        }

        return $this;
    }

    /**
     * @return Collection|Perfil[]
     */
    public function getPerfiles(): Collection
    {
        return $this->perfiles;
    }

    public function addPerfil(Perfil $perfil): self
    {
        if (!$this->perfiles->contains($perfil)) {
            $this->perfiles[] = $perfil;
            $perfil->addFavorito($this);
        }

        return $this;
    }

    public function removePerfil(Perfil $perfil): self
    {
        if ($this->perfiles->contains($perfil)) {
            $this->perfiles->removeElement($perfil);
            $perfil->removeFavorito($this);
        }

        return $this;
    }

    public function getEditorial(): ?Editorial
    {
        return $this->editorial;
    }

    public function setEditorial(?Editorial $editorial): self
    {
        $this->editorial = $editorial;

        return $this;
    }

    public function getAno(): ?int
    {
        return $this->ano;
    }

    public function setAno(?int $ano): self
    {
        $this->ano = $ano;

        return $this;
    }

    public function __toString()
    {
        return $this->titulo;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }
    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(?string $foto): self
    {
        $this->foto = $foto;

        return $this;
    }

    public function getFotoFile()
    {
        return $this->fotoFile;
    }

    public function setFotoFile(File $foto = null)
    {
        $this->fotoFile = $foto;

        if ($foto) {

            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;

    }

    public function getAdelanto(): ?Adelanto
    {
        return $this->adelanto;
    }

    public function setAdelanto(?Adelanto $adelanto): self
    {
        $this->adelanto = $adelanto;

        // set (or unset) the owning side of the relation if necessary
        $newLibro = null === $adelanto ? null : $this;
        if ($adelanto->getLibro() !== $newLibro) {
            $adelanto->setLibro($newLibro);
        }

        return $this;
    }

    public function getCompleto(): ?bool
    {
        return $this->completo;
    }

    public function setCompleto(bool $completo): self
    {
        $this->completo = $completo;

        return $this;
    }

    public function getAnCapitulo(int $nro): CapituloLibro
    {
        
        return $this->capituloLibros->get($nro);
    }

    /**
     * @return Collection|CapituloLibro[]
     */
    public function getCapituloLibros(): Collection
    {
        return $this->capituloLibros;
    }

    public function addCapituloLibro(CapituloLibro $capituloLibro): self
    {
        if (!$this->capituloLibros->contains($capituloLibro)) {
            $this->capituloLibros[] = $capituloLibro;
            $capituloLibro->setLibro($this);
        }

        return $this;
    }

    public function removeCapituloLibro(CapituloLibro $capituloLibro): self
    {
        if ($this->capituloLibros->contains($capituloLibro)) {
            $this->capituloLibros->removeElement($capituloLibro);
            // set the owning side to null (unless already changed)
            if ($capituloLibro->getLibro() === $this) {
                $capituloLibro->setLibro(null);
            }
        }

        return $this;
    }

    public function getCantCapitulos(): ?int
    {
        return $this->cantCapitulos;
    }

    public function setCantCapitulos(?int $cantCapitulos): self
    {
        $this->cantCapitulos = $cantCapitulos;

        return $this;
    }

    public function getTipoDeCarga(): ?bool
    {
        return $this->tipoDeCarga;
    }

    public function setTipoDeCarga(?bool $tipoDeCarga): self
    {
        $this->tipoDeCarga = $tipoDeCarga;

        return $this;
    }



}
