<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Seguimiento;
use App\Form\SeguimientoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SeguimientosController extends Controller
{
    /**
     * Renderiza la plantilla que muestra los seguimientos
     * @param Project $proyecto
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function seguimientos(Project $proyecto) {
        return $this->render('seguimientos/index.html.twig', [
            'proyecto' => $proyecto,
        ]);
    }

    /**
     * Añade una fase del seguimiento del proyecto
     * @param Request $request
     * @param Project $proyecto
     * @return mixed
     */
    public function anyadirSeguimiento(Request $request, Project $proyecto) {
        $seguimiento = new Seguimiento();

        $form = $this->createForm(SeguimientoType::class, $seguimiento, [
            'action' => '/proyecto/'.$proyecto->getId().'/seguimiento/nuevo'
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $seguimiento->setProyecto($proyecto);
            $seguimiento->setUsuario($this->getUser());
            $seguimiento->setFecha(new \DateTime());
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($seguimiento);
            $manager->flush();

            return $this->redirectToRoute('Seguimientos', [
                'id' => $proyecto->getId()
            ]);
        }

        return $this->render('seguimientos/seguimiento-form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Preparado para AJAX
     * elimina un seguimiento de un proyecto
     * @param Seguimiento $seguimiento
     * @param Project $project
     * @return JsonResponse
     */
    public function eliminarSeguimiento(Project $project, Seguimiento $seguimiento) {
        try {
            $eliminado = false;

            $usuario = $this->getUser();

            if($project->getAutor() !== $usuario) {
                throw new \Exception('Este proyecto no es tuyo!');
            }

            if($project->getSeguimientos()->contains($seguimiento)) {
                $manager = $this->getDoctrine()->getManager();
                $manager->remove($seguimiento);
                $manager->flush();
                $eliminado = true;
            }

            return new JsonResponse([
                'eliminado' => $eliminado
            ]);
        } catch(\Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], 405);
        }
    }

    public function actualizarSeguimiento(Request $request, Project $project, Seguimiento $seguimiento) {
        $form = $this->createForm(SeguimientoType::class, $seguimiento, [
            'action' => '/proyecto/'.$project->getId().'/seguimiento/'.$seguimiento->getId().'/actualizar'
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if($project->getSeguimientos()->contains($seguimiento)) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($seguimiento);
                $manager->flush();

                return $this->redirectToRoute('seguimientos', [
                    'id' => $project->getId()
                ]);
            }
        }

        return $this->render('seguimientos/editar-form.html.twig', [
            'form' => $form->createView()
        ]);
    }
    
}
