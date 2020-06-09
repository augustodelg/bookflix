<?php

namespace App\Controller;

use App\Entity\Novedad;
use App\Entity\Libro;
use App\Repository\NovedadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $novedades = $em->getRepository(Novedad::class)->novedadesInicio();
        $librosHomePrueba = $em->getRepository(Libro::class)->librosHome();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'Home Works!',
            'novedades' => $novedades,
            'librosPrueba' => $librosHomePrueba,
        ]);
    }
    /* 
    public function allNovedades(): array 
    {
        $em = $this->getDoctrine()->getManager();
        
        $query = $em->getRepository(Novedad::class)->findAll();

        // returns an array of Product objects
        return $query;
    }
   */
}
