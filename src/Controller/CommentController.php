<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\CommentController;
use App\Entity\Project;
use App\Entity\Comment;
use App\Form\ProjectType;
use App\Form\CommentType;

class CommentController extends Controller {
    
    public function Comentar($id, Request $peticion)
    {
        $comentario = new Comment();
        $FormularioComentar = $this->createForm(CommentType::class, $comentario);
        $Proyecto = $this->getDoctrine()->getRepository(Project::class)->find($id);
        $FormularioComentar->handleRequest($peticion);
        if($FormularioComentar->isSubmitted() && $FormularioComentar->isValid())
        {
            $comentario->setFechaCreacion(new \DateTime());
            $comentario->setProyecto($Proyecto);
            $comentario->setAutor($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comentario);
            $entityManager->flush();
            
            return $this->redirectToRoute("proyecto",['id'=>$id]);
            
        }
        return $this->redirectToRoute("index");
    }
}
