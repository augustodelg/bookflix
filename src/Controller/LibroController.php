<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Libro;

use App\Entity\Adelanto;
use App\Entity\CapituloLibro;
use App\Entity\Novedad;
use App\Repository\NovedadRepository;
use App\Repository\AdelantoRepository;
use App\Repository\CapituloLibroRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\DependencyInjection\Argument\ServiceLocator;

use Symfony\Component\Finder\Finder;



class LibroController extends AbstractController
{
    /**
     * @Route("/libro", name="libro")
     */
    public function index( Request $request )
    {

        $data=$request->query->get('id');

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

        $libro = $em->getRepository(Libro::class)->findOneBy(array('id' => $data));

        //Obtener perfil actual
        $user = $this->getUser();
        $perfiles = $user->getPerfiles();
        $perfil = $user->getPerfilActivo();

        $perfilActivo = $perfiles[$perfil];
    


        return $this->render('libro/index.html.twig', [
            'libro' => $libro,
            'myForm' => $form->createView(),
            'perfilActivo' => $perfilActivo,
        ]);
    }

     /**
     * @Route("/libro/pdf/{id}/{capitulo}", name="libro_pdf")
     */
    public function pdf($id ,$capitulo ,Request $request )
    {


        $em = $this->getDoctrine()->getManager();    
        $libro = $em->getRepository(Libro::class)->find($id);


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
        if ($capitulo == -1 ) {
            $capitulos = $libro->getCapituloLibros();
        }else {
            $capitulos = array($em->getRepository(CapituloLibro::class)->find($capitulo));
        }
        
        $user = $this->getUser();
        $perfiles = $user->getPerfiles();
        $perfil = $user->getPerfilActivo();

        $perfilActivo = $perfiles[$perfil];
    
        return $this->render('libro/verLibro.html.twig', [
            'libro' => $libro,
            'myForm' => $form->createView(),
            'capitulo' => $capitulos,
            'perfilActivo' => $perfilActivo,
        ]);
    }
}
