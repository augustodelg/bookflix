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
        if ($user->premiumNull()==true){
            return $this->render('elegir_plan/index.html.twig', [
                'controller_name' => 'ElegirPlanController',
            ]);
        }else{
            return new RedirectResponse('home');
        }

    }
}
