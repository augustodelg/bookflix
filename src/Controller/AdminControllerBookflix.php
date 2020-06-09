<?php

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use App\Entity\Libro;



class AdminControllerBookflix extends EasyAdminController
{

    protected function contenidoAction(){
        
        $id = $this->request->query->get('id');
        $entity = $this->em->getRepository(Libro::class)->find($id);

        return $this-> redirectToRoute('update_book', array('id' => $id));

    }
}