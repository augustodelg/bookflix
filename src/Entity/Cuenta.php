<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CuentaRepository")
 */
class Cuenta implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

     /**
     * @ORM\Column(type="string")
     */

    private $nombre;

     /**
     * @ORM\Column(type="string")
     */

    private $apellido;

    /**
     * @ORM\Column(type="json")
     */

    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */

    private $password;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Perfil", mappedBy="cuenta")
     */
    private $perfiles;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $premium;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Tarjeta", inversedBy="cuenta", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $tarjeta;

    public function __construct()
    {
        $this->perfiles = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
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


    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): self
    {
        $this->apellido = $apellido;

        return $this;
    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Perfil[]
     */
    public function getPerfiles(): Collection
    {
        return $this->perfiles;
    }

    public function addPerfile(Perfil $perfile): self
    {
        if (!$this->perfiles->contains($perfile)) {
            $this->perfiles[] = $perfile;
            $perfile->setCuenta($this);
        }

        return $this;
    }

    public function removePerfile(Perfil $perfile): self
    {
        if ($this->perfiles->contains($perfile)) {
            $this->perfiles->removeElement($perfile);
            // set the owning side to null (unless already changed)
            if ($perfile->getCuenta() === $this) {
                $perfile->setCuenta(null);
            }
        }

        return $this;
    }

    public function premiumNull (): ?bool
    {
        if ($this->getPremium()==null){
            return true;
        }else{
            return false;
        }
    }

    public function getPremium(): ?bool
    {
        return $this->premium;
    }

    public function setPremium(?bool $premium): self
    {
        $this->premium = $premium;

        return $this;
    }

    public function getTarjeta(): ?Tarjeta
    {
        return $this->tarjeta;
    }

    public function setTarjeta(Tarjeta $tarjeta): self
    {
        $this->tarjeta = $tarjeta;

        return $this;
    }
}
 