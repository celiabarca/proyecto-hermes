<?php

namespace App\Controller;

use App\Entity\Valoracion;
use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;


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
            } else {
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

    /**
     * Valora un proyecto con un no me gusta
     * @param Project $proyecto
     * @return JsonResponse
     */
    public function desvalorarProyecto(Project $proyecto) {
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
                $valoracion->setMegusta(false);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($valoracion);
                $manager->flush();
                $valorado = true;
            } else {
                $valoracion->setMegusta(false);
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

    /**
     * Quita la valoracion de un proyecto
     * @param Project $proyecto
     * @return JsonResponse
     */
    public function quitarValoracion(Project $proyecto) {
        try {
            $usuario = $this->getUser();

            if(!isset($usuario)) {
                throw new \Exception("Debes iniciar sesion!");
            }

            $valoracion = $this->getDoctrine()
                                ->getRepository(Valoracion::class)
                                ->findOneBy([
                                    'proyecto' => $proyecto,
                                    'usuario' => $usuario
                                ]);

            $valoracionEliminada = false;

            if(isset($valoracion)) {
                $manager = $this->getDoctrine()->getManager();
                $manager->remove($valoracion);
                $manager->flush();
                $valoracionEliminada = true;
            }

            return new JsonResponse([
                'valoracionEliminada' => $valoracionEliminada
            ]);
        } catch(\Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], 405);
        }
    }
}
