<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\User;
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
