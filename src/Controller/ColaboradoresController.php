<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ColaboradoresController extends Controller
{
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
