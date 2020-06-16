<?php

namespace App\Controller;

use App\Entity\CapituloLibro;
use App\Entity\Libro;
use App\Form\CapituloType;
use App\Form\LibroCompletoType;
use Doctrine\Common\Collections\ArrayCollection;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;



use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class UpdateBookController extends AbstractController
{
    /**
     * @Route("/bookUpdate/{id}", name="update_book")
     */
    public function index($id, Libro $libro, Request $request)
    {   
        //Obtengo el Entity manager
        $em = $this->getDoctrine()->getManager();

        //Obtengo tipo de carga del libro
        $condicion = $libro-> getTipoDeCarga();
        
        
        // Formulario cuando no se definio como se desea subir el libro.
        $form = $this->createFormBuilder()
        ->add('completo', SubmitType::class ,['label' => 'SUBIR LIBRO COMPLETO'] )
        ->add('porCapitulo', SubmitType::class ,['label' => 'SUBIR LIBRO POR CAPITULO'])->getForm();
        



        //Traigo actualizacion del formulario
        $form->handleRequest($request);
        

        
        //Condicion para elejir que formulario mostrar

            if (($condicion) !== null) {
                
                // Entro si se quiere subir el capitulo COMPLETO
                if (($condicion) == true){

                   
                    
                    return $this-> redirectToRoute('subir_libro_completo', array('id' =>  $id,'libro' => $libro));


                }else{

                    return $this-> redirectToRoute('cantidad_capitulos', array('id' =>  $id,'libro' => $libro));

                }
                
            }else {

                        // CONTROLAMOS LOS SUBMITS
                if ($form->isSubmitted() && $form->isValid()) {
                    if($form->get('completo')->isClicked()){
                        $libro->setTipoDeCarga(true);
                        $em -> flush();
                    }
                    if($form->get('porCapitulo')->isClicked()){
                        $libro-> setTipoDeCarga(false);
                        $em -> flush();
                    $em -> flush();
                    
                    }
                }

                // Formulario cuando no se definio como se desea subir el libro.

                $a = 'ES NUL';
                return $this->render('update_book/index.html.twig', [
                    'controller_name' => 'UpdateBookController',
                    'libro' => $libro,
                    'formulario' => $form->createView(),
                    'debug' => $a,
                    'view_capitulo' => false,
                ]);
                
                
            }
        $a='Entro a elejir tipo de subida';

        //$formL = $form->getForm();
        return $this->render('update_book/index.html.twig', [
            'controller_name' => 'UpdateBookController',
            'libro' => $libro,
            'formulario' => $form->createView(),
            'debug' => $a,
            'view_capitulo' => false,
        ]);
    }
}

/*  FORMULARIOS:

    

    Libro completo
        -Un solo pdf
        -Poner automatico el libro en completo
        -Fecha lanzamineto
        -Fecha vencimiento
    
    Carga capitulos
        -Cantidad maxima de capitulos 
        -Cargar capitulo 
            -Numero capitulo
            -PDF
            -Fecha lanzamineto
            -Fecha vencimiento
            
*/