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
        $a= 'Subir por capitulos';

        $em = $this->getDoctrine()->getManager();

        $cap= new CapituloLibro();
        $cap->setLibro($libro);
        $form = $this->createForm(CapituloType::class, $cap);


        //Obtengo cantidad de capitulos
        $cantiadadCapitulos = $libro-> getCantCapitulos();
        $cantCapitulosDefinidos = true;

        //Traigo actualizacion del formulario
        $form->handleRequest($request);

        if ($form-> isSubmitted() && $form-> isValid()) {
            if ($form->get('completo')) {
                $libro-> setCompleto(true);
            }
            $em-> persist($cap);
            $em-> flush();
        }




        return $this->render('subir_capitulos/index.html.twig', [
            'libro' => $libro,
            'formulario' => $form->createView(),
            'debug' => $a,
            'completo' => $libro -> getCompleto(),
            'capitulosDefinidos' => $cantCapitulosDefinidos,
            'capitulos' => $libro-> getCapituloLibros() ,
        ]);
    }
}
