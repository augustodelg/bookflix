<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Adelanto;
use App\Entity\Novedad;
use App\Entity\Libro;
use App\Repository\NovedadRepository;
use App\Repository\AdelantoRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;




class AdelantoController extends AbstractController
{
    /**
     * @Route("/adelanto", name="adelanto")
     */
    public function index(Request $request)
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





        $adelanto = $em->getRepository(Adelanto::class)->findOneBy(array('id' => $data));
        
        if ($adelanto->getLibro()==null){
            $foto=null;
        }else{
            $foto = $adelanto->getLibro()->getFoto();
        }

        //Obtener perfil actual
        $user = $this->getUser();
        $perfiles = $user->getPerfiles();
        $perfil = $user->getPerfilActivo();

        $perfilActivo = $perfiles[$perfil];

        return $this->render('adelanto/index.html.twig', [
            'controller_name' => 'AdelantoController',
            'adelanto' => $adelanto,
            'foto' => $foto,
            'myForm' => $form->createView(),
            'perfilActivo' => $perfilActivo,
        ]);
    }
}
