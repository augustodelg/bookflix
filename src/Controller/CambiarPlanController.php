<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;



class CambiarPlanController extends AbstractController
{
    /**
     * @Route("/cambiar/plan", name="cambiar_plan")
     */
    public function index(Request $request)
    {        
        $em = $this->getDoctrine()->getManager();

        $data=$request->query->get('tipo');

        $user = $this->getUser();

        if ($data == false){
            $user->setPremium(true);
        }else{
            $user->setPremium(false);
        }

        $em->persist($user);
        $em->flush();

        return new RedirectResponse('/perfiles');

        return $this->render('cambiar_plan/index.html.twig', [
            'controller_name' => 'CambiarPlanController',
        ]);
    }
}
 