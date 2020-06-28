<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Novedad;
use App\Entity\Libro;
use App\Entity\Adelanto;
use App\Repository\NovedadRepository;
use App\Repository\AdelantoRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VerPerfilesController extends AbstractController
{
    /**
     * @Route("perfiles", name="ver_perfiles")
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine()->getManager();


        $user = $this->getUser();
        $perfiles = $user->getPerfiles();
        $cantPerfiles = 0;
        $plan = $user->getPremium();

        foreach ($user->getPerfiles() as $perfil){
            if ($perfil->getActivo()==true){
                $perfilActivo=$perfil;
            }
            $cantPerfiles=$cantPerfiles+1;
        }

        $posActivo = $user->getPerfilActivo();   //Me traigo la posicion en la coleccion del perfil activo

        $coleccionPerfilActivo = $user->getPerfiles();
        $perfilActivo = $coleccionPerfilActivo[$posActivo];



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



        return $this->render('ver_perfiles/index.html.twig', [
            'controller_name' => 'VerPerfilesController',
            'perfiles' => $perfiles,
            'myForm'=>$form->createView(),
            'posActivo'=>$posActivo,
            'perfilActivo' => $perfilActivo,
            'cantPerfiles' => $cantPerfiles,
            'plan' => $plan,

        ]);
    }
}
