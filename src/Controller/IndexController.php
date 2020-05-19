<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Repository\LibroRepository;
use App\Entity\Libro;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $arrayPortada = $em->getRepository(Libro::class)->portadasIndex();
        $user = $this->getUser();
        if ($user){
            return new RedirectResponse('/home');
        }
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'arrayPortadas' => $arrayPortada,
        ]);
    }
}
