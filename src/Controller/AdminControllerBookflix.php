<?php

namespace App\Controller;

use App\Entity\CalificacionComentario;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use App\Entity\Libro;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Dumper;

class AdminControllerBookflix extends EasyAdminController
{

    protected function CargarPdfAction(){
        
        $entity = $this->request->query;

        return $this-> redirectToRoute('update_book', array('id' =>  $entity->get('id'),'entity' => $entity));

    }
    protected function BorrarPdfAction(){
        
        $entity = $this->request->query;

        return $this-> redirectToRoute('borrar_capitulo', array('id' =>  $entity->get('id'),'entity' => $entity));

    }

    public function Modificar_DisponibilidadAction()
    {
        $entity = $this->request->query;
        return $this->redirectToRoute('update_fecha',array('id' =>  $entity->get('id'),'entity' => $entity));

    }

    protected function ReseñasAction(){
        $entity = $this->request->query;
        return $this->redirectToRoute('ver_opiniones_admin',array('id' =>  $entity->get('id'),'entity' => $entity));
    }

     /**
     * @Route("/opiniones/{id}", name="ver_opiniones_admin")
     */
    public function ver_opiniones($id, Libro $libro, Request $request)
    {
        return $this->render('admin/opiniones.html.twig', [
            'opiniones' => $libro->getCalificacionesComentarios(),
        ]);
    }

    /**
     * @Route("/cambiaropinion/{id}", name="cambiar_opinion_admin")
     */
    public function cambiar_estado_comentario($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $capitulo = $em->getRepository(CalificacionComentario::class)->find($id);
        $libro = $capitulo-> getLibro();
        if ($capitulo->getSpoiler() == 1) {
            $capitulo->setSpoiler(0);
        }else{
            $capitulo->setSpoiler(1);
        }
        
        $em->flush();
        return $this->redirectToRoute('ver_opiniones_admin', [
            'id' =>$libro->getId(),
            'libro' => $libro->getCalificacionesComentarios(),
        ]);
    }

    /**
     * @Route("/eliminarcomentarioadmin/{id}", name="borrar_comentario_libro_admin")
    */
    public function eliminarComentarioComoAdmin($id, Request $request){

        $em = $this->getDoctrine()->getManager();
        $comentario = $em->getRepository(CalificacionComentario::class)->findOneBy(array('id' => $id));
        $libro = $comentario->getLibro();
        $em->remove($comentario);
        $em->flush();
        return $this-> redirectToRoute('ver_opiniones_admin',['id' => $libro->getId(),'libro' => $libro->getCalificacionesComentarios()]);
        
    }
}