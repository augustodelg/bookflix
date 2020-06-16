<?php

namespace App\Controller;

use App\Entity\Novedad;
use App\Entity\Libro;
use App\Repository\NovedadRepository;
use App\Entity\Adelanto;
use App\Repository\AdelantoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine()->getManager();


        $novedades = $em->getRepository(Novedad::class)->NovedadesInicio();
        $adelantos = $em->getRepository(Adelanto::class)->AdelantosInicio();
        $librosHomePrueba = $em->getRepository(Libro::class)->librosHome();
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

        return $this->render('home/index.html.twig', [
            'controller_name' => 'Home Works!',
            'novedades' => $novedades,
            'adelantos' => $adelantos,
            'librosPrueba' => $librosHomePrueba,
            'myForm'=>$form->createView()
            ]);
    }

    // <!--{{ //include('prueba/formulario-prueba.html.twig',{myForm:myForm}) }}-->
    /* 
    public function allNovedades(): array 
    {
        $em = $this->getDoctrine()->getManager();
        
        $query = $em->getRepository(Novedad::class)->findAll();

        // returns an array of Product objects
        return $query;
    }
   */
}
