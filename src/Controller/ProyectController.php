<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\CommentController;
use App\Entity\Project;
use App\Form\ProjectType;


    public function indice()
    {
    }
    
    public function altaProyecto(Request $peticion)
    {
        $projecto = new Project();
        $formularioProyecto = $this->createForm(ProjectType::class, $projecto);
        
        $formularioProyecto->handleRequest($peticion);
        {
            $projecto->setFechaCreacion(new \Datetime());
            if(!$projecto->getImg())
            {
                $projecto->setImg("");
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projecto);
            $entityManager->flush();
            
        }
    }
    
<<<<<<< HEAD
    static public function dameProyectos($total)
=======
>>>>>>> bf9316992ad9f7ef0c555e7a6c73d78cbf3076db
    {
        }
        
        return $proyectos;
    }
}
