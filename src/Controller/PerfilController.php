<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Cuenta;
use App\Entity\Perfil;
use App\Entity\Libro;
use App\Entity\CalificacionComentario;

class PerfilController extends AbstractController
{
    /**
     * @Route("/perfil", name="perfil")
     */
    public function index(Request $request)
    {
        $user = $this->getUser();
        $email = $user->getEmail();
        $nombre = $user->getNombre();
        $apellido = $user->getApellido();
        $tarjeta = $user->getTarjeta();
        $numero = $tarjeta->getNumero();
        $cvv = $tarjeta->getCvv();
        $dni = $tarjeta->getDni();
        $vencimiento = $tarjeta->getVencimiento();
        $newDate = $vencimiento->format('Y-m-d');


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

        //Obtener perfil actual
        $user = $this->getUser();
        $perfiles = $user->getPerfiles();
        $perfil = $user->getPerfilActivo();

        $perfilActivo = $perfiles[$perfil];

        return $this->render('perfil/index.html.twig', [
            'email' => $email,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'numero' => $numero,
            'cvv' => $cvv,
            'dni' => $dni,
            'vencimiento' => $newDate,
            'myForm' => $form->createView(),
            'perfilActivo' => $perfilActivo,
        ]);
    }

    /**
     * @Route("/eliminarcomentario/{id}", name="borrar_comentario_libro")
    */
    public function eliminarcomentario($id, Request $request){

        $em = $this->getDoctrine()->getManager();
        $comentario = $em->getRepository(CalificacionComentario::class)->findOneBy(array('id' => $id));
        $libro = $comentario->getLibro();
        $em->remove($comentario);
        $em->flush();
        return $this-> redirectToRoute('libro',['id' => $libro->getId(),'libro' => $libro]);
        
    }
}
