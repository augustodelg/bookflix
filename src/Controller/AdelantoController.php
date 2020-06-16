<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Adelanto;


class AdelantoController extends AbstractController
{
    /**
     * @Route("/adelanto", name="adelanto")
     */
    public function index(Request $request)
    {


        $data=$request->query->get('id');
        $em = $this->getDoctrine()->getManager();

        $adelanto = $em->getRepository(Adelanto::class)->findOneBy(array('id' => $data));
        
        if ($adelanto->getLibro()==null){
            $foto=null;
        }else{
            $foto = $adelanto->getLibro()->getFoto();
        }



        return $this->render('adelanto/index.html.twig', [
            'controller_name' => 'AdelantoController',
            'adelanto' => $adelanto,
            'foto' => $foto,
        ]);
    }
}
