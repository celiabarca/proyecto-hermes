<?php

namespace App\Controller;

use App\Repository\ValoracionRepository;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Project;
use App\Form\ProjectType;
use App\Entity\User;

class ProyectController extends Controller {

    private $projectRepository;
    private $valoracionRepository;

    public function __construct(ProjectRepository $repository, ValoracionRepository $valoracionRepository) {
        $this->projectRepository = $repository;
        $this->valoracionRepository = $valoracionRepository;
    }

    /**
     * Renderiza los proyectos ordenado por fecha de creación
     * @return mixed
     */
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

    /**
     * Crea un proyecto nuevo
     * @param Request $peticion
     * @return mixed
     */
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
        return $this->render('proyect/nuevo.html.twig', [
            'FormularioProyecto' => $formularioProyecto->createView()
        ]);
    }
    /**
     * Devuelve el numero de proyectos que se solicitan
     * @param int $total
     * @return Project[]
     */
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
    /**
     * Renderiza la pagina del proyecto
     * @param Project $proyecto
     * @return mixed
     */
    public function proyecto(Project $proyecto)
    {
        $formComment = $this->createForm(\App\Form\CommentType::class);
        if($this->getUser()) {
            $valoracion = $this->valoracionRepository->getValoracionDelUsuario($this->getUser(), $proyecto);
        } else {
            $valoracion = null;
        }

        return $this->render('proyect/proyecto.html.twig', [
            'proyecto' => $proyecto,
            'valoracion' => $valoracion,
            'FormComentario' => $formComment->createView()
        ]);
    }
    /**
     * Render de los proyectos de un usuario
     * @param User $user
     * @return mixed
     */
    
    public function getProyectosByUser(User $user)
    {
        $proyetos = $this->getDoctrine()->getRepository(Project::class)->findBy(["autor"=>$this->getUser()]);
        return $this->render("Usuario/Proyecto/todos.html.twig",['Proyectos'=>$proyetos]);
    }
    
    /**
     * Proyectos en los que colaboro
     * @return mixed
     */
    public function getProyectosColaborados()
    {
        $user = $this->getUser();
        $proyectos = $user->getColaboraciones();
        return $this->render("Usuario/Proyecto/todos.html.twig",['Proyectos'=>$proyectos]);
    }

    /**
     * Página de edicion de usuario renderizada.
     * @param Request $request
     * @param Project $proyecto
     * @return mixed
     */
    public function editarProyecto(Request $request, Project $proyecto) {
        $form = $this->createForm(ProjectType::class, $proyecto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($proyecto);
            $manager->flush();
            return $this->redirectToRoute("proyecto",["id"=>$proyecto->getId()]);
        }

        return $this->render('proyect/editar.html.twig', [
           'form' => $form->createView(),
            'proyecto' => $proyecto
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
            $usuario = $this->getUser();

            if(!isset($usuario)) {
                throw new \Exception('Debes iniciar sesion!');
            }

            $eliminado = false;

            if($proyecto->getAutor() == $usuario) {
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
     * Filtra proyectos por campo y orden
     * @param string $filtro
     * @param string $orden
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getProyectorByFiltro(string $filtro, string $orden) {
        switch($filtro) {
            case 'valoracion':
                $proyectos = $this->projectRepository->findByValoracion($orden);
                break;
            case 'donaciones':
                $proyectos = $this->projectRepository->findByDonaciones($orden);
                break;
            default:
                $proyectos = $this->getDoctrine()
                    ->getRepository(Project::class)
                    ->findBy([], [
                        $filtro => $orden
                    ]);
                break;
        }

        return $this->render('proyect/index.html.twig', [
            'proyectos' => $proyectos,
        ]);
    }
}
