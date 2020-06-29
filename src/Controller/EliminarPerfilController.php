<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Cuenta;
use App\Entity\Perfil;



class EliminarPerfilController extends AbstractController
{
    /**
     * @Route("/eliminarPerfil/{id}", name="eliminarPerfil")
     */
    public function index($id , Request $request)
    { 


        $em = $this->getDoctrine()->getManager();
        $data=$id;
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



        // $em = $this->getDoctrine()->getManager();
        // $data=$request->query->get('id');
        // $user = $this->getUser();

        // $perfil = $em->getRepository(Perfil::class)->find($id);

        

        // $activo = $user->getPerfilActivo();

        // $perfiles = $user->getPerfiles();

        // $perfil = $perfiles[$id];

        // $perfilActivo = $perfiles[$activo];

        // if ($perfilActivo === $perfil){
        //     $activo = 0;
        // }

        // echo($perfil->getNombre());

        // $user->removePerfile($perfil);
        // $user->setPerfilActivo(array_key_first($perfiles->getKeys()));
        // $em->remove($perfil);
        // $em->persist($user);
        // $em->flush();


        // return $this->redirectToRoute('ver_perfiles');

                

        // return $this->render('eliminar_perfil/index.html.twig', [
        //     'controller_name' => 'EliminarPerfilController',
        // ]);
    }
}
