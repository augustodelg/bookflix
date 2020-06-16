<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Libro;

class CantidadCapitulosController extends AbstractController
{
    /**
     * @Route("/cantidad/capitulos/{id}", name="cantidad_capitulos")
     */
    public function index($id, Libro $libro, Request $request)
    {

        $cantiadadCapitulos = $libro-> getCantCapitulos();


        if ($cantiadadCapitulos === null) {
            $a='entre a defini capitulos';
            $form = $this->createFormBuilder()
            ->add('cantCapitulos', IntegerType::class)
            ->add('confirmar', SubmitType::class ,['label' => 'Confirmar'] )->getForm();
        }else{
            return $this-> redirectToRoute('subir_capitulos', array('id' =>  $id,'libro' => $libro));
        }
        //Traigo actualizacion del formulario
        $form->handleRequest($request);
        
        if ($form-> isSubmitted() && $form-> isValid()) {
            $em = $this->getDoctrine()->getManager();
            $a='entre a defini capitulos';
            $capitulos = $form-> get('cantCapitulos')->getData();
            $libro-> setCantCapitulos($capitulos);
            $em-> flush();
        }

        return $this->render('cantidad_capitulos/index.html.twig', [
            'libro' => $libro,
            'formulario' => $form->createView(),
            'debug' => $a,
            'completo' => $libro -> getCompleto(),
        ]);
    }
}
