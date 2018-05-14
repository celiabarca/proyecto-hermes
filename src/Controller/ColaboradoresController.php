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

    public function anadirColaboradores(Project $proyecto) {
        if($proyecto)
        {
            $colaboracion = $this->getDoctrine()->getRepository(Colaboracion::class)->findOneBy(["proyecto"=>$proyecto,"usuario"=>$this->getUser()]);
            if(!$colaboracion)
            {
                $colaborador = new Colaboracion();
                $colaborador->setProyecto($proyecto);
                $colaborador->setUsuario($this->getUser());
                $colaborador->setEstado("Pendiente");
                $em = $this->getDoctrine()->getManager();
                $em->persist($colaborador);
                $em->flush();  
            } 
            return $this->redirectToRoute("proyecto",["id"=>$proyecto->getId()]);
        }
        return $this->redirectToRoute("index");
    }
}
