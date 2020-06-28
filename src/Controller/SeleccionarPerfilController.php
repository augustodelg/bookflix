<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


class SeleccionarPerfilController extends AbstractController
{
    /**
     * @Route("/seleccionar/perfil", name="seleccionar_perfil")
     */
    public function index(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $data=$request->query->get('id');

        $user = $this->getUser();

        $user->setPerfilActivo($data);

        $em->persist($user);
        $em->flush();

        return new RedirectResponse('/home');        


        return $this->render('seleccionar_perfil/index.html.twig', [
            'controller_name' => 'SeleccionarPerfilController',
        ]);
    }
}
