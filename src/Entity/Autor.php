<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AutorRepository")
 */
class Autor
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
     * @ORM\OneToMany(targetEntity="App\Entity\libro", mappedBy="autor")
     */
    private $libro;

    public function __construct()
    {
        $this->libro = new ArrayCollection();
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
     * @return Collection|libro[]
     */
    public function getLibro(): Collection
    {
        return $this->libro;
    }

    public function addLibro(libro $libro): self
    {
        if (!$this->libro->contains($libro)) {
            $this->libro[] = $libro;
            $libro->setAutor($this);
        }

        return $this;
    }

    public function removeLibro(libro $libro): self
    {
        if ($this->libro->contains($libro)) {
            $this->libro->removeElement($libro);
            // set the owning side to null (unless already changed)
            if ($libro->getAutor() === $this) {
                $libro->setAutor(null);
            }
        }

        return $this;
    }
}
