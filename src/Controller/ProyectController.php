<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\CommentController;
use App\Entity\Project;
use App\Form\ProjectType;

class ProyectController extends Controller {

    public function indice()
    {
    	$proyectos = $this->getDoctrine()
                        ->getRepository(Project::class)
                        ->findBy([], [
                            'fechaCreacion' => 'desc'
                        ]);

        return $this->render('proyect/index.html.twig', [
            'proyectos' => $proyectos,
        ]);
    }
    
    public function altaProyecto(Request $peticion)
    {
        $projecto = new Project();
        $formularioProyecto = $this->createForm(ProjectType::class, $projecto);
        
        $formularioProyecto->handleRequest($peticion);
        if($formularioProyecto->isSubmitted() && $formularioProyecto->isValid())
        {
            $projecto->setFechaCreacion(new \Datetime());
            if(!$projecto->getImg())
            {
                $projecto->setImg("");
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projecto);
            $entityManager->flush();
            
            return $this->redirectToRoute("index");
        }
        return $this->render('project/nuevo.html.twig', [
            'FormularioProyecto' => $formularioProyecto->createView()
        ]);
    }
    
    public function dameProyectos($total = null)
    {
        if (isset($total) && $total > 0) {
            $proyectos = $this->getDoctrine()
                            ->getRepository(Project::class)
                            ->findBy([], null, $total);
        } else {
            $proyectos = $this->getDoctrine()->getRepository(Project::class)->findAll();
        }
        
        return $proyectos;
    }

    public function proyecto(Project $proyecto) {
        return $this->render('project/index.html.twig', [
            'proyecto' => $proyecto
        ]);
    }
}
