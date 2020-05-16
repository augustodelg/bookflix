<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PerfilPremiumController extends AbstractController
{
    /**
     * @Route("/perfil-premium", name="perfil_premium")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user->setPremium(true);
        $em->persist($user);
        $em->flush();
        return new RedirectResponse('home');


        // return $this->render('perfil_premium/index.html.twig', [
        //     'controller_name' => 'PerfilPremiumController',
        // ]);
    }
}
