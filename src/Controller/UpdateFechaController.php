<?php

namespace App\Controller;

use App\Entity\CapituloLibro;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Libro;
use App\Form\CapituloType;
use App\Form\UpdateFechaType;
use DateTime;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Mime\Message;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class UpdateFechaController extends AbstractController
{
    /**
     * @Route("/update/fecha/{id}", name="update_fecha")
     */
    public function index($id, Libro $libro, Request $request)
    {
  
        return $this->render('update_fecha/index.html.twig', [
            'libro' => $libro,
        ]);
    }

    /**
     * @Route ("/admin/cambiarFechaLanzamiento/{id}", name="cambiar_fecha_disponibilidad")
     */

    public function cambiarFechaLanzamiento($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $capitulo = $em->getRepository(CapituloLibro::class)->find($id);


        $defaultData = ['mensaje' => 'Busque su libro aqui'];
        $form = $this->createFormBuilder($defaultData)
            ->add('fechaDisponible', DateType::class,[
                'data'=> $capitulo->getFechaDisponible(),
            ])
            ->add('fechaVencimiento', DateType::class,[
                'data'=> $capitulo->getFechaVencimiento(),
            ])
            ->add('guardar',SubmitType::class)

        ->getForm();
        
        //$form = $this->createForm(UpdateFechaType::class);
        //$form = $this->createForm(CapituloLibroType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $fecha_lanzamiento_nueva = $form->get('fechaDisponible')->getData();
            $fecha_vencimiento_nueva = $form->get('fechaVencimiento')->getData();
            $fecha_hoy = new DateTime();
            if ($fecha_vencimiento_nueva <= $fecha_lanzamiento_nueva || $fecha_lanzamiento_nueva < $fecha_hoy || $fecha_vencimiento_nueva < $fecha_hoy)
            {
                if ($fecha_lanzamiento_nueva < $fecha_hoy || $fecha_vencimiento_nueva < $fecha_hoy )
                {
                    $this->addFlash('error','Las fechas ingresadas deben ser posteriores a la fecha de hoy');
                    return $this->redirectToRoute('cambiar_fecha_disponibilidad',[
                        'id'=>$id
                    ]);
    
                }
                else 
                {
                    $this->addFlash('error','La fecha de vencimiento debe ser posterior a la fecha de lanzamiento');
                    return $this->redirectToRoute('cambiar_fecha_disponibilidad',[
                        'id' =>$id
                    ]);
                }

            }            
           $capitulo->setFechaDisponible($fecha_lanzamiento_nueva);
           $capitulo->setFechaVencimiento($fecha_vencimiento_nueva);
           $em->flush($capitulo);
            $this->addFlash('sucess','Los cambios se realizaron correctamente');
            return $this->redirectToRoute('easyadmin') ;
            }
        return $this->render('update_fecha/actualizar_fecha.html.twig',[
            'capitulo' => $capitulo,
            'formulario'=>$form->createView()
        ]);
    }


     /**
     * @Route ("/admin/cambiarFechaLanzamiento/{id}", name="cambiar_fecha_vencimiento")
     */

    /*public function cambiarFechaVencimiento($id,Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $capitulo = $em->getRepository(CapituloLibro::class)->find($id);

        $defaultData = ['mensaje' => 'Cambiar Fecha'];
        $form = $this->createForm(UpdateFechaType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            echo "Fue submiteado";
           $fecha_nueva = $form->get('fecha')->getdate();
           $capitulo->setFechaVencimiento($fecha_nueva);
           $em->flush($capitulo);
            $this->addFlash('sucess','La fecha se actualizo correctamente');
            return $this->redirectToRoute('easyadmin') ;
            }
        return $this->render('update_fecha/actualizar_fecha.html.twig',[
            'formulario'=>$form->createView()
        ]);
    }*/


}
