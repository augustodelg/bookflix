<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



/**
 * @ORM\Entity(repositoryClass="App\Repository\CapituloLibroRepository")
 * @Vich\Uploadable
 * 
 * @UniqueEntity(
 *      fields={"nro", "libro"},
 *      message="Este capitulo ya se encuentra cargado."    
 * )
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
     * @Assert\Expression(
     *      "this.checkRangoCapitulos()",
     *      message =  "El numero de capitulo no es valido "
     * )
     */
    private $nro;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThanOrEqual("today",message= "Fecha de lanzamiento invalida")
     */
    private $fechaDisponible;

    /**
     * @ORM\Column(type="date")
     * @Assert\Expression("this.getFechaVencimiento() > this.getFechaDisponible() ",message= "Fecha de vencimiento invalida")
     */
    private $fechaVencimiento;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Libro", inversedBy="capituloLibros")
     * @ORM\JoinColumn(nullable=false)
     */
    private $libro;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $archivo;

    /**
     * @Vich\UploadableField(mapping="capitulo_file", fileNameProperty="archivo")
     * @var File
     * @Assert\NotNull
     * @Assert\File(
     *      mimeTypes ={"application/pdf", "application/x-pdf"}, mimeTypesMessage = "Por favor ingrese un archivo pdf" 
     * )
     */
    
    private $archivoFile;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;



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
        return (string)$this->nro;
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
    public function getArchivo(): ?string
    {
        return $this->archivo;
    }

    public function setArchivo(?string $archivo): self
    {
        $this->archivo = $archivo;

        return $this;
    }

    public function getArchivoFile()
    {
        return $this->archivoFile;
    }

    public function setArchivoFile(File $archivo = null)
    {
        $this->archivoFile = $archivo;

        if ($archivo) {

            $this->updatedAt = new \DateTime('now');
            $this->archivoFile = $archivo;
        }
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function checkRangoCapitulos()
    {
        $max=$this->libro->getCantCapitulos();

        if ($this->nro >= 1 && $this->nro <= $max) {
            return true;
        }
        return false;
    }


    
}

