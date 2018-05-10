<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\CommentController;
use App\Entity\Project;
use App\Form\ProjectType;

class ProyectController extends Controller
{
    public function indice()
    {
    	$proyectos = $this->getDoctrine()->getRepository(ProyectRepository::class)->findAll();
        return $this->render('proyect/index.html.twig', 
                [
                    'proyectos' => $proyectos,
                ]);
    }
    
    public function altaProyecto(Request $peticion)
    {
        $projecto = new Project();
        $formularioProyecto = $this->createForm(ProjectType::class, $projecto);
        
        $formularioProyecto->handleRequest($peticion);
        if($formularioProyecto->isSubmitted()&& $formularioProyecto->isValid())
        {
            $projecto->setFechaCreacion(new \Datetime());
            if(!$projecto->getImg())
            {
                $projecto->setImg("");
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projecto);
            $entityManager->flush();
            
            return $this->redirectToRoute("");
        }
        return $this->render('project/nuevo.html.twig',['FormularioProyecto'=>$formularioProyecto->createView()]);
    }
    
    static public function dameProyectos($total)
    {
        $proyectos = [];
        if (total == 0)
        {
            $proyectos = $this->getDoctrine()->getRepository(ProyectRepository::class)->findAll();
        }
        else
        {
            $proyectos = $this->getDoctrine()->getRepository(ProyectRepository::class)->findBy(['id'=> $total],null,$total);
        }
        
        return $proyectos;
    }
}
