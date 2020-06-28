<?php
namespace App\Controller;

use App\Entity\Novedad;
use App\Entity\Libro;
use App\Repository\NovedadRepository;
use App\Entity\Adelanto;
use App\Repository\AdelantoRepository;
use App\Repository\LibroRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BuscarLibroController extends AbstractController
{
    /**
     * @Route ("/home/buscar/{texto}/{criterio}", name="buscando_libro")
     * @param LibroRepository $libroRepository
     */
    public function buscarLibro(LibroRepository $libroRepository, $texto, $criterio , Request $request)
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




        $libros = $libroRepository->buscarLibro($texto,$criterio);
        $cantidad = count($libros);


        //Obtener perfil actual
        $user = $this->getUser();
        $perfiles = $user->getPerfiles();
        $perfil = $user->getPerfilActivo();

        $perfilActivo = $perfiles[$perfil];

        return $this->render('resultadosBusqueda.html.twig',[
            'libros'=>$libros,
            'myForm' => $form->createView(),
            'cantidad'=>$cantidad,
            'perfilActivo' => $perfilActivo,
        ]);

    }

}