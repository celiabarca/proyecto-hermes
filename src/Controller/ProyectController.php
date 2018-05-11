<?php

namespace App\Controller;

use App\Entity\Seguimiento;
use App\Entity\Valoracion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Project;
use App\Form\ProjectType;
use App\Entity\User;

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
            $projecto->setAutor($this->getUser());
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

    public function proyecto(Project $proyecto)
    {
        $formComment = $this->createForm(\App\Form\CommentType::class);

        return $this->render('proyect/proyecto.html.twig', [
            'proyecto' => $proyecto,
            'FormComentario' => $formComment->createView()
        ]);
    }
    
    public function getProyectos(User $user)
    {
        $proyetos = $this->getDoctrine()->getRepository(Project::class)->findBy(["autor"=>$this->getUser()]);
        return $this->render("Usuario/Proyecto/todos.html.twig",['Proyectos'=>$proyetos]);
    }
    
    public function getProyectosByUser(User $user)
    {
        $proyetos = $this->getDoctrine()->getRepository(Project::class)->findBy(["autor"=>$this->getUser()]);
        return $this->render("Usuario/Proyecto/todos.html.twig",['Proyectos'=>$proyetos]);
    }
    
    public function getProyectosColaborados()
    {
        $user = $this->getUser();
        $proyectos = $user->getColaboraciones();
        return $this->render("Usuario/Proyecto/todos.html.twig",['Proyectos'=>$proyetos]);
    }
    public function editarProyecto(Request $request, Project $proyecto) {
        $form = $this->createForm(ProjectType::class, $proyecto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($proyecto);
            $manager->flush();
        }

        return $this->render('project/editar.html.twig', [
           'form' => $form->createView()
        ]);
    }


    /**
     * Preparado para AJAX.
     * Elimina un proyecto
     * @param Project $proyecto
     * @return JsonResponse
     */
    public function eliminarProyecto(Project $proyecto) {
        try {
            $eliminado = false;

            if($proyecto->getAutor() == $this->getUser()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->remove($proyecto);
                $manager->flush();
                $eliminado = true;
            }

            return new JsonResponse([
                'eliminado' => $eliminado
            ]);
        } catch(\Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    

}
