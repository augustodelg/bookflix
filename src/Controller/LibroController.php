<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Libro;

use App\Entity\Adelanto;
use App\Entity\CalificacionComentario;
use App\Entity\CapituloLibro;
use App\Entity\RegistroLibro;
use App\Entity\RegistroEventos;
use App\Repository\RegistroEventosRepository;

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

use App\Form\CalificacionComentarioType;
use DateTime;

class LibroController extends AbstractController
{
    /**
     * @Route("/libro/{id}", name="libro")
     */
    public function index($id, Libro $libro,  Request $request )
    {


        $em = $this->getDoctrine()->getManager();

        //$novedades = $em->getRepository(Novedad::class)->NovedadesInicio();
        //$adelantos = $em->getRepository(Adelanto::class)->AdelantosInicio();
        //$librosHomePrueba = $em->getRepository(Libro::class)->librosHome();

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

        $comentario = new CalificacionComentario ();
        $comentarioForm= $this->createForm(CalificacionComentarioType::class,$comentario);
        

         //Obtener perfil actual
         $user = $this->getUser();
         $perfiles = $user->getPerfiles();
         $perfil = $user->getPerfilActivo();
 
         $perfilActivo = $perfiles[$perfil];

         $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {  
            $busqueda = $form->getData();
           
            return $this->redirectToRoute('buscando_libro',[
                'texto'=>$busqueda['textoBusqueda'],
                'criterio'=>$busqueda['ElegirCriterio']
                ]);
            }
        //Obtengo comentario (si exite) del perfil en el libro actual
        $comentarioLibro= $perfilActivo->getCalificacionesComentarios()-> filter(function($com) use ($libro){
            return $com->getLibro() === $libro;
        });

        //actualizo formulario de comentarios
        $comentarioForm->handleRequest($request);
        
        if ( $comentarioForm->isSubmitted() &&  $comentarioForm->isValid())
        {   
            $comentario->setPerfil($perfilActivo);
            $libro->addCalificacionesComentario( $comentario);
            $perfilActivo->addCalificacionesComentario( $comentario);
            $em-> persist($comentario);
            $em-> flush();
            return $this->redirectToRoute('libro', [
                'libro' => $libro,
                'id' => $id,
            ]);
        }
       

        //Pregunto si los libros favoritos del perfil activo, contienen al libro que se está buscando    

        $favoritos = $perfilActivo->getFavoritos();
        $estaEnFavoritos = false;
        foreach ($favoritos as $unLibro)
            {
                if ($unLibro->getId() == $libro->getId())
                   {
                       $estaEnFavoritos = true;
                        break;
                   }
            }
       
    
        

        return $this->render('libro/index.html.twig', [
            'libro' => $libro,
            'myForm' => $form->createView(),
            'perfilActivo' => $perfilActivo,
            'comentario' =>  $comentarioForm->createView(),
            'comentarUsuarioExistente' => $comentarioLibro->isEmpty(),
            'comentarioDelPerfil' => $comentarioLibro->first(),
            'estaEnFavoritos'=>$estaEnFavoritos,
        ]);
    }

     /**
     * @Route("/libro/pdf/{id}/{capitulo}", name="libro_pdf")
     * @param RegistroEventosRepository $registroEventosRepository
     */
    public function pdf($id ,$capitulo ,Request $request, RegistroEventosRepository $registroEventosRepository )
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
        $valor_capitulo_aux = $capitulo;
        
        if ($capitulo == -1 ) {
            $capitulos = $libro->getCapituloLibros();
        }else {
            $capitulos = array($em->getRepository(CapituloLibro::class)->find($capitulo));
        }
        
        $user = $this->getUser();
        $perfiles = $user->getPerfiles();
        $perfil = $user->getPerfilActivo();

        $perfilActivo = $perfiles[$perfil];
        
        $registroHistorial = $perfilActivo->contieneLibro($libro); //pregunto si el perfil activo leyo el libro

        $fecha_actual = new DateTime();

        if ($valor_capitulo_aux == -1) // significa que se apretó en Leer Libro Completo
            {
                if( $registroHistorial != null)
                    {
                    
                    $registroHistorial->setUltimoAcceso($fecha_actual);
                    $em->flush();
                    }
                else
                    {
                    $registroHistorialNuevo = new RegistroLibro();
                    $registroHistorialNuevo->setLibro($libro);
                    $registroHistorialNuevo->setUltimoAcceso($fecha_actual);
                    $perfilActivo->addHistorial($registroHistorialNuevo);
                    $em->persist($registroHistorialNuevo);
                    $em->flush();

                    }
            }
        else // significa que se apretó en Leer Capitulo
            {
                $registroEventoNuevo = new RegistroEventos; // registro el evento
                $registroEventoNuevo->setIdCuenta($user->getId());
                $registroEventoNuevo->setIdPerfil($perfilActivo->getId());
                $registroEventoNuevo->setIdLibro($id);
                $registroEventoNuevo->setIdCapitulo($valor_capitulo_aux);
                $registroEventoNuevo->setFecha($fecha_actual);
                $em->persist($registroEventoNuevo);
                $em->flush();

                if( $registroHistorial != null) // si el perfil leyó el libro, actualizo ultimo acceso
                    {
                        $registroHistorial->setUltimoAcceso($fecha_actual);
                        $em->flush();
                    }
                else  // si no lo leyó, consulto en los registros si leyó todos los capítulos
                    {
                        $cantidadCapitulosLeidos = $perfilActivo->cantidadCapitulosLeidos($id,$registroEventosRepository);
                        $cantidadCapitulosLibro = count($libro->getCapituloLibros());
                        if ($cantidadCapitulosLeidos == $cantidadCapitulosLibro)
                            {
                                $registroHistorialNuevo = new RegistroLibro();
                                $registroHistorialNuevo->setLibro($libro);
                                $registroHistorialNuevo->setUltimoAcceso($fecha_actual);
                                $perfilActivo->addHistorial($registroHistorialNuevo);
                                $em->persist($registroHistorialNuevo);
                                $em->flush();
                            }
                    }
            }

        

    

       

        return $this->render('libro/verLibro.html.twig', [
            'libro' => $libro,
            'myForm' => $form->createView(),
            'capitulo' => $capitulos,
            'perfilActivo' => $perfilActivo,
            'registroHistorial'=>$registroHistorial
        ]);
    }



}
