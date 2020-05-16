<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PerfilNormalController extends AbstractController
{
    /**
     * @Route("/perfil-normal", name="perfil_normal")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user->setPremium(false);
        $em->persist($user);
        $em->flush();
        return new RedirectResponse('home');
        // return $this->render('perfil_normal/index.html.twig', [
        //     'controller_name' => 'PerfilNormalController',
        // ]);
    }
}
