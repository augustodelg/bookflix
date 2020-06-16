<?php
namespace App\Controller;

use App\Entity\Novedad;
use App\Entity\Libro;
use App\Repository\NovedadRepository;
use App\Entity\Adelanto;
use App\Repository\AdelantoRepository;
use App\Repository\LibroRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class BuscarLibroController extends AbstractController
{
    /**
     * @Route ("/home/buscar/{texto}/{criterio}", name="buscando_libro")
     * @param LibroRepository $libroRepository
     */
    public function buscarLibro(LibroRepository $libroRepository, $texto, $criterio)
    {
        $libros = $libroRepository->buscarLibro($texto,$criterio);
        return $this->render('resultadosBusqueda.html.twig',[
            'libros'=>$libros
        ]);

    }
}