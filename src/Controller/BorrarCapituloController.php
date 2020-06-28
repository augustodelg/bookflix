<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;

use App\Entity\CapituloLibro;
use App\Entity\Libro;

class BorrarCapituloController extends AbstractController
{
    /**
     * @Route("/borrarcapitulo/libro{id}", name="borrar_capitulo")
     */
    public function index($id, Libro $libro, Request $request)
    {


        
        return $this->render('borrar_capitulo/index.html.twig', [
            'controller_name' => 'BorrarCapituloController',
            'capitulos' => $libro->getCapituloLibros(),
        ]);
    }


    /**
     * @Route("/borrarcapitulo/{id}", name="borrar_capitulo_basedatos")
     */
    public function borrarCapitulo($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $capitulo = $em->getRepository(CapituloLibro::class)->find($id);
        $libro = $capitulo -> getLibro();
        $em->remove($capitulo);
        $libro->setCompleto(false);
        $em->flush();
        return $this-> redirectToRoute('borrar_capitulo', array('id' =>  $libro->getId(),'entity' => $libro));
        ;
    }
}
