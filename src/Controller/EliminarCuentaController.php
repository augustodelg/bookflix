<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class EliminarCuentaController extends AbstractController
{
    /**
     * @Route("/eliminarCuenta", name="eliminar_cuenta")
     */
    public function index()
    {

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $this->get('security.token_storage')->setToken(null);

        $em->remove($user);

        $em->flush();

        return new redirectResponse('/');
        
        // return $this->render('eliminar_cuenta/index.html.twig', [
        //     'controller_name' => 'EliminarCuentaController',
        // ]);
    }
}
