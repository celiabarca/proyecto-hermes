<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\User;
use App\Entity\Colaboracion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;


class ColaboradoresController extends Controller
{
    /**
     * Preparado para AJAX
     * Elimina un colaborador de un proyecto
     * @param Project $proyecto
     * @param User $user
     * @return JsonResponse
     */
    public function eliminarColaborador(Project $proyecto, User $user)
    {
        try {
            $eliminado = false;

            $colaboracion = $this->getDoctrine()
                ->getRepository(Colaboracion::class)
                ->findOneBy([
                    'proyecto' => $proyecto,
                    'usuario' => $user
                ]);

            if(!isset($colaboracion)) {
                throw new \Exception('No has colaborado en este proyecto!');
            }

            if ($proyecto->getColaboradores()->contains($colaboracion)) {
                $manager = $this->getDoctrine()->getManager();
                $manager->remove($colaboracion);
                $manager->flush();
                $eliminado = true;
            }

            return new JsonResponse([
                'eliminado' => $eliminado
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], 405);
        }
    }

    public function anadirColaboradores(Project $proyecto)
    {
        if ($proyecto) {
            $colaboracion = $this->getDoctrine()->getRepository(Colaboracion::class)->findOneBy(["proyecto" => $proyecto, "usuario" => $this->getUser()]);
            if (!$colaboracion) {
                $colaborador = new Colaboracion();
                $colaborador->setProyecto($proyecto);
                $colaborador->setUsuario($this->getUser());
                $colaborador->setEstado("Pendiente");
                $em = $this->getDoctrine()->getManager();
                $em->persist($colaborador);
                $em->flush();
            }
            return $this->redirectToRoute("proyecto", ["id" => $proyecto->getId()]);
        }
        return $this->redirectToRoute("index");
    }

    /**
     * Preparado para ajax
     * El usuario quita su colaboarion en un proyecto
     * @param Project $project
     * @return JsonResponse
     */
    public function eliminarColaboracion(Project $project)
    {
        try {
            $colaboracionEiminada = false;

            $colaboracion = $this->getDoctrine()
                            ->getRepository(Colaboracion::class)
                            ->findOneBy([
                                'proyecto' => $project,
                                'usuario' => $this->getUser()
                            ]);

            if(!isset($colaboracion)) {
                throw new \Exception('No has colaborado en este proyecto!');
            }

            if ($project->getColaboradores()->contains($colaboracion)) {
                $manager = $this->getDoctrine()->getManager();
                $manager->remove($colaboracion);
                $manager->flush();
                $colaboracionEiminada = true;
            }

            return new JsonResponse([
                'colaboracion_eliminada' => $colaboracionEiminada
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], 405);
        }
    }

}
