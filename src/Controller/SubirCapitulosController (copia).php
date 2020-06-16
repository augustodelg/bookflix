<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\CapituloLibro;
use App\Entity\Libro;
use App\Form\CapituloType;
use App\Form\LibroPorCapitulosType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;




use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Doctrine\Common\Collections\ArrayCollection;

class SubirCapitulosController extends AbstractController
{
    /**
     * @Route("/subircapitulos/{id}", name="subir_capitulos")
     */
    public function index($id, Libro $libro, Request $request)
    {
        $a= 'Subir por capituloos';

        $em = $this->getDoctrine()->getManager();

        //$cap= new CapituloLibro();
        //$libro->addCapituloLibro($cap);
        $form = $this->createForm(LibroPorCapitulosType::class, $libro);


        //Obtengo cantidad de capitulos
        $cantiadadCapitulos = $libro-> getCantCapitulos();
        $cantCapitulosDefinidos = true;

        /*$orignalExp = new ArrayCollection();
        foreach ($libro->getCapituloLibros() as $capitulo) {
            $orignalExp->add($capitulo);
        }
        */


        //Traigo actualizacion del formulario
        $form->handleRequest($request);

        /*if ($cantiadadCapitulos === null) {
            return $this-> redirectToRoute('cantidad_capitulos', array('id' =>  $id,'libro' => $libro));
        }*/

        if ($form-> isSubmitted() && $form-> isValid()) {
            $em-> flush();
        }

        return $this->render('subir_capitulos/index.html.twig', [
            'libro' => $libro,
            'formulario' => $form->createView(),
            'debug' => $a,
            'completo' => $libro -> getCompleto(),
            'capitulosDefinidos' => $cantCapitulosDefinidos,
            //'cantidadCapitulosLibro' => $cantMaxCapitulos ,
        ]);
    }
}
