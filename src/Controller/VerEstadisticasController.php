<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Repository\CuentaRepository;
use App\Repository\LibroRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VerEstadisticasController extends AbstractController
{
    /**
     * @Route("/ver/estadisticas", name="ver_estadisticas")
     */
    public function index()
    {
        return $this->render('ver_estadisticas/index.html.twig', [
            'controller_name' => 'VerEstadisticasController',
        ]);
    }


/**
 * @Route("/ver/estadisticas/libros", name="ver_libros")
 * @param LibroRepository
 */
    public function verLibros(LibroRepository $libroRepository, Request $request)
    {
        $libros = $libroRepository->devolverLibros();
        return $this->render('ver_estadisticas/resultadoLibros.html.twig',[
            'libros'=>$libros
        ]);
    }

/**
 * @Route("/ver/estadisticas/usuarios", name="ver_usuarios")
 * @param CuentaRepository
 */

    public function verUsuarios(CuentaRepository $cuentaRepository, Request $request)
    {
        $defaultData = ['mensaje' => 'Buscar usuarios'];
        $form = $this->createFormBuilder($defaultData)
            ->add('fechaInicio',DateType::class)
            ->add('fechaFin',DateType::class)
            ->add('buscar',SubmitType::class)

        ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $fechaInicio = $form->getData()['fechaInicio'];
            $fechaFin = $form->getData()['fechaFin'];
            if ($fechaFin < $fechaInicio)
            {
                $this->addFlash('error','La fecha de inicio debe ser superior a la fecha de fin');
                return $this->redirectToRoute('ver_usuarios');
            }

            $usuarios = $cuentaRepository->buscarUsuarios($fechaInicio,$fechaFin);
            $cantidad = count($usuarios);
            return $this->render('ver_estadisticas/resultadoUsuarios.html.twig',[
                'usuarios' => $usuarios,
                'cantidad' => $cantidad
            ]);

    
        }

        return $this->render('ver_estadisticas/buscarUsuarios.html.twig',[
            'formulario' => $form->createView()
        ]);

    }



}
