<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Cuenta;



class EliminarPerfilController extends AbstractController
{
    /**
     * @Route("/eliminarPerfil", name="eliminar_perfil")
     */
    public function index(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $data=$request->query->get('id');
        $user = $this->getUser();
        $activo = $user->getPerfilActivo();
        $perfiles = $user->getPerfiles();

        if ($activo == $data){
            $activo = 0;
        }

        $user->removePerfile($perfiles[$data]);
        $user->setPerfilActivo($activo);
        $em->persist($user);
        $em->flush();

        return new RedirectResponse('/perfiles');        

        return $this->render('eliminar_perfil/index.html.twig', [
            'controller_name' => 'EliminarPerfilController',
        ]);
    }
}
