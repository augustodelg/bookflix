<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Cuenta;
use App\Entity\Perfil;

class PerfilController extends AbstractController
{
    /**
     * @Route("/perfil", name="perfil")
     */
    public function index()
    {
        $user = $this->getUser();
        $email = $user->getEmail();
        $nombre = $user->getNombre();
        $apellido = $user->getApellido();
        $tarjeta = $user->getTarjeta();
        $numero = $tarjeta->getNumero();
        $cvv = $tarjeta->getCvv();
        $dni = $tarjeta->getDni();
        $vencimiento = $tarjeta->getVencimiento();
        $newDate = $vencimiento->format('Y-m-d');


        return $this->render('perfil/index.html.twig', [
            'email' => $email,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'numero' => $numero,
            'cvv' => $cvv,
            'dni' => $dni,
            'vencimiento' => $newDate
        ]);
    }
}
