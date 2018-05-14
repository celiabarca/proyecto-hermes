<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Seguimiento;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class SeguimientosController extends Controller
{
    /**
     * Añade una fase del seguimiento del proyecto
     * @param Project $proyecto
     */
    public function anyadirSeguimiento(Project $proyecto) {
        $seguimiento = new Seguimiento();

        // TODO implementar en formulario
        $seguimiento->setProyecto($proyecto);
        $seguimiento->setUsuario($this->getUser());
        $seguimiento->setFecha(new \DateTime());
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($seguimiento);
        $manager->flush();
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
}
