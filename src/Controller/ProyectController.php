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

    public function proyecto(Project $proyecto) {
        return $this->render('project/index.html.twig', [
            'proyecto' => $proyecto
        ]);
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
     * Añade una fase del seguimiento del proyecto
     * @param Project $proyecto
     */
    public function anyadirSeguimiento(Project $proyecto) {
        $seguimiento = new Seguimiento();
        // TODO mirar que no tenga mas de tres fases y añadir el seguimiento
    }

    /**
     * Preparado para AJAX
     * añade un "me gusta" a un proyecto con el usuario actual
     * @param Project $proyecto
     * @return JsonResponse
     */
    public function valorarProyecto(Project $proyecto) {
        try {
            $usuario = $this->getUser();

            if(!isset($usuario)) {
                throw new \Exception('Debes iniciar sesion!');
            }

            $valoracion = $this->getDoctrine()
                                ->getRepository(Valoracion::class)
                                ->findOneBy([
                                    'proyecto' => $proyecto,
                                    'usuario' => $usuario
                                ]);
            $valorado = false;

            if(!isset($valoracion)) {
                $valoracion = new Valoracion();
                $valoracion->setProyecto($proyecto);
                $valoracion->setUsuario($usuario);
                $valoracion->setMegusta(true);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($valoracion);
                $manager->flush();
                $valorado = true;
            }

            return new JsonResponse([
                'valorado' => $valorado
            ]);
        } catch(\Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], 500);
        }
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

    /**
     * Preparado para AJAX
     * Elimina un colaborador de un proyecto
     * @param Project $proyect
     * @param User $user
     */
    public function eliminarColaborador(Project $proyecto, User $user) {
        try {
            $eliminado = false;

            if($proyecto->getColaboradores()->contains($user)) {
                $proyecto->removeColaborador($user);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($proyecto);
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

    public function anyadirColaboradores(Project $proyecto) {

    }

}
