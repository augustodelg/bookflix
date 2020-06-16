<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Libro;
use App\Form\LibroCompletoType;
use App\Entity\CapituloLibro;

class SubirLibroCompletoController extends AbstractController
{
    /**
     * @Route("/subircompleto/{id}", name="subir_libro_completo")
     */
    public function index($id, Libro $libro, Request $request)
    {   

        $capitulo = new CapituloLibro();
        $capitulo-> setLibro($libro);
        $libro ->setCantCapitulos(2);
        $capitulo -> setNro(1);
        //Notar que es igual al de capitulo salvo que no se muestra el input para el capitulo, BUSCAR SOLUCION PARA NO TENER OTRO TYPE
        $form = $this->createForm(LibroCompletoType::class, $capitulo);


        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $libro -> setCompleto(true);

            $libro -> addCapituloLibro($capitulo);
            $em -> persist($capitulo);
            $em -> flush();

        }

        $a = 'ENTRO PARA COMPLETO';
        
        return $this->render('subir_libro_completo/index.html.twig', [
            'controller_name' => 'SubirLibroCompletoController',
            'libro' => $libro,
            'formulario' => $form->createView(),
            'debug' => $a,
            'completo'=> $libro->getCompleto(),
            'capitulos' => $libro -> getCapituloLibros(),
        ]);
    }
}
