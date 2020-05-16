<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length; 
/**
 * @ORM\Entity(repositoryClass="App\Repository\TarjetaRepository")
 */
class Tarjeta
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @Assert\Length(
     *      min = 16,
     *      max = 16,
     *      minMessage = "minNumero",
     *      maxMessage = "maxNumero",
     *      allowEmptyString = false
     * )
     * 
     * @ORM\Column(type="integer")
     */

    private $numero;

    /**
     * @ORM\Column(type="integer")
     */
    private $dni;

    /**
     * @Assert\Length(
     *      min = 3,
     *      max = 3,
     *      minMessage = "El cvv de la tarjeta debe tener {{limit}} caracteres.",
     *      maxMessage = "El cvv de la tarjeta debe tener {{limit}} caracteres.",
     *      allowEmptyString = false
     * )
     * 
     * @ORM\Column(type="integer")
     */
    private $cvv;

    /**
     * @ORM\Column(type="date")
     */
    private $vencimiento;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Cuenta", mappedBy="tarjeta", cascade={"persist", "remove"})
     */
    private $cuenta;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getDni(): ?int
    {
        return $this->dni;
    }

    public function setDni(int $dni): self
    {
        $this->dni = $dni;

        return $this;
    }

    public function getCvv(): ?int
    {
        return $this->cvv;
    }

    public function setCvv(int $cvv): self
    {
        $this->cvv = $cvv;

        return $this;
    }

    public function getVencimiento(): ?\DateTimeInterface
    {
        return $this->vencimiento;
    }

    public function setVencimiento(\DateTimeInterface $vencimiento): self
    {
        $this->vencimiento = $vencimiento;

        return $this;
    }

    public function getCuenta(): ?Cuenta
    {
        return $this->cuenta;
    }

    public function setCuenta(Cuenta $cuenta): self
    {
        $this->cuenta = $cuenta;

        // set the owning side of the relation if necessary
        if ($cuenta->getTarjeta() !== $this) {
            $cuenta->setTarjeta($this);
        }

        return $this;
    }



}
