<?php

namespace App\Controller;
use App\Entity\Libro;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class UpdateBookController extends AbstractController
{
    /**
     * @Route("/bookUpdate/{id}", name="update_book")
     */
    public function index($id)
    {   
       $em = $this->getDoctrine()->getManager();
       $libro =$em->getRepository(Libro::class)->find($id);
        return $this->render('update_book/index.html.twig', [
            'controller_name' => 'UpdateBookController',
            'libro' => $libro,
        ]);
    }
}
