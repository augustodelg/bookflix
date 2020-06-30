<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Libro;
use App\Entity\Perfil;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class FavoritosController extends AbstractController
{
    /**
     * @Route("/agregar/{libro_id}", name="agregar_a_favoritos")
     */
    public function agregarFavoritoAction($libro_id)
    {
        $perfiles = $this->getUser()->getPerfiles();
        $idPerfilActivo = $this->getUser()->getPerfilActivo();
        $perfilA = $perfiles[$idPerfilActivo];
        $em = $this->getDoctrine()->getManager();
        $unLibro = $em->getRepository(Libro::class)->findOneBy(array('id' => $libro_id));
        $perfilA->addFavorito($unLibro);
        $em->persist($perfilA);
        $em->flush();
        return $this->redirectToRoute('libro',[
            'id'=>$libro_id,
            'libro'=>$unLibro,
        ]);
    }


        /**
     * @Route("/quitar/{libro_id}", name="quitar_de_favoritos")
     */
    public function quitarFavoritoAction($libro_id)
    {
        $perfiles = $this->getUser()->getPerfiles();
        $idPerfilActivo = $this->getUser()->getPerfilActivo();
        $perfilA = $perfiles[$idPerfilActivo];
        $em = $this->getDoctrine()->getManager();
        $unLibro = $em->getRepository(Libro::class)->findOneBy(array('id' => $libro_id));
        $perfilA->removeFavorito($unLibro);
        $em->persist($perfilA);
        $em->flush();
        return $this->redirectToRoute('libro',[
            'id'=>$libro_id,
            'libro'=>$unLibro,
        ]);
    }

    /**
     * @Route("/ver/favoritos/" ,name="ver_favoritos")
     */

    public function verFavoritosAction(Request $request)
    {
        $perfiles = $this->getUser()->getPerfiles();
        $idPerfilActivo = $this->getUser()->getPerfilActivo();
        $perfilA = $perfiles[$idPerfilActivo];
        $favoritos = $perfilA->getFavoritos();
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


        return $this->render('favoritos/index.html.twig',[
             'librosFavoritos'=>$favoritos,
             'perfilActivo'=>$perfilA,
             'myForm'=>$form->createView(),

        ]);
    }
}
