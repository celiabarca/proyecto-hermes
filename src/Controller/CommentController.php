<?php

namespace App\Controller;

use App\Entity\Respuesta;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Project;
use App\Entity\Comment;
use App\Form\CommentType;

class CommentController extends Controller {

    /**
     * Publica un comentario en un proyecto
     * @param Project $proyecto
     * @param Request $peticion
     * @return mixed
     */
    public function Comentar(Project $proyecto, Request $peticion)
    {
        $comentario = new Comment();
        $FormularioComentar = $this->createForm(CommentType::class, $comentario, [
            'action' => '/proyecto/'.$proyecto->getId().'/comentar'
        ]);

        $FormularioComentar->handleRequest($peticion);

        if($FormularioComentar->isSubmitted() && $FormularioComentar->isValid())
        {
            $comentario->setFechaCreacion(new \DateTime());
            $comentario->setProyecto($proyecto);
            $comentario->setAutor($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comentario);
            $entityManager->flush();

            return $this->redirectToRoute("proyecto",[
                'id' => $proyecto->getId()
            ]);
        }

        return $this->render('comentario/index.html.twig', [
            'form' => $FormularioComentar->createView()
        ]);
    }

    /**
     * Responde un comentario
     * @param Request $request
     * @param Comment $comment
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function responder(Request $request, Comment $comment) {
        $respuesta = new Respuesta();

        $form = $this->createForm(CommentType::class, $respuesta, [
            'action' => '/comentario/'.$comment->getId().'/responder'
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $respuesta->setFechacreacion(new \DateTime());
            $respuesta->setAutor($this->getUser());
            $respuesta->setComentario($comment);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($respuesta);
            $manager->flush();

            return $this->redirectToRoute("proyecto",[
                'id' => $comment->getProyecto()->getId()
            ]);
        }

        return $this->render('comentario/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
