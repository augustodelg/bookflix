<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Perfil;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Libro;

class HistorialController extends AbstractController
{
    /**
     * @Route("/historial", name="historial")
     */
    public function index()
    {
        return $this->render('historial/index.html.twig', [
            'controller_name' => 'HistorialController',
        ]);
    }

        /**
     * @Route("/ver/historial/{perfilActivo_id}", name="ver_historial")
     */

    public function verHistorial($perfilActivo_id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();    
        $perfilActivo = $em->getRepository(Perfil::class)->find($perfilActivo_id);
        $historial = $perfilActivo->getHistorial();

        // /////////////////////////FORMULARIO DE BUSQUEDA

$defaultData = ['mensaje' => 'Busque su libro aqui'];
$form = $this->createFormBuilder($defaultData)
    ->add('textoBusqueda', TextType::class)
     ->add('ElegirCriterio', ChoiceType::class,[
        'choices'=> [
            'Autor'=>'autor',
            'Genero'=>'genero',
            'Editorial'=>'editorial',
            'Titulo'=>'titulo',
            ],
        ])
->add('Buscar',SubmitType::class)
->getForm();
$form->handleRequest($request);
if ($form->isSubmitted() && $form->isValid())
{
   $busqueda = $form->getData();
    return $this->redirectToRoute('buscando_libro',[
        'texto'=>$busqueda['textoBusqueda'],
        'criterio'=>$busqueda['ElegirCriterio']
        ]);
    }

///////////////////////////////////////////////////


        return $this->render('historial/index.html.twig',[
            'historial'=>$historial,
            'perfilActivo'=>$perfilActivo,
            'myForm'=>$form->createView()
        ]);
    }

}
