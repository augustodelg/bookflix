<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Perfil;
use Symfony\Component\HttpFoundation\RedirectResponse;





class AgregarPerfilController extends AbstractController
{
    /**
     * @Route("/agregarPerfil", name="agregar_perfil")
     */
    public function index(Request $request)
    {

        $user = $this->getUser();

        $defaultData = ['mensaje' => 'Ingrese su nombre de perfil'];
        $form = $this->createFormBuilder($defaultData)
            ->add('nombre', TextType::class)
            ->add('Crear',SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $data = $form->getData();

            $perfil = new Perfil();

            $perfil->setNombre($data['nombre']);
            $perfil->setActivo(false);

            $user->addPerfile($perfil);

            $em->persist($perfil);
            $em->persist($user);
            $em->flush();

            return new RedirectResponse('/perfiles');            

        }



        return $this->render('agregar_perfil/index.html.twig', [
            'formulario' => $form->createView(),

        ]);
    }
}
