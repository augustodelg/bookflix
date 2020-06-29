<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ElegirPlanController extends AbstractController
{
    /**
     * @Route("/elegir-plan", name="elegir_plan")
     */
    public function index()
    {
        $user = $this->getUser();
        $plan = $user->getPremium();
        if (is_null($plan)){                                     // Si el usuario nunca eligio un plan
            return $this->render('elegir_plan/index.html.twig', [
                'controller_name' => 'ElegirPlanController',
            ]);
        }
        $perfiles = $user->getPerfiles();
        return $this->render('seleccionar_perfil/index.html.twig', [
            'perfiles' => $perfiles,
        ]);
    }
} 
