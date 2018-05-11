<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ValoracionesController extends Controller
{
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
            ], 405);
        }
    }
}
