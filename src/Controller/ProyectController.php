<?php

namespace App\Controller;

use App\Repository\ValoracionRepository;
use App\Repository\ProjectRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Project;
use App\Form\ProjectType;
use App\Entity\User;
use App\Entity\Seguimiento;

class ProyectController extends Controller {

    private $projectRepository;
    private $valoracionRepository;
    private $uploader;

    public function __construct(ProjectRepository $repository, ValoracionRepository $valoracionRepository, FileUploader $uploader) {
        $this->projectRepository = $repository;
        $this->valoracionRepository = $valoracionRepository;
        $this->uploader = $uploader;
    }

    /**
     * Renderiza los proyectos ordenado por fecha de creación
     * @return mixed
     */
    public function indice(Request $req = null)
    {
        if($req->get("proyecto"))
        {
           $proyectos = $this->getDoctrine()->getRepository(Project::class)->createQueryBuilder('o')
                
                ->where('o.titulo LIKE :nombre')
                ->setParameter('nombre', "%".$req->get("proyecto")."%")
                ->getQuery()
                ->getResult();
        }
        else
        {
            $proyectos = $this->getDoctrine()
                        ->getRepository(Project::class)
                        ->findBy([], [
                            'fechaCreacion' => 'desc'
                        ]);
        }
    	

        return $this->render('proyect/index.html.twig', [
            'proyectos' => $proyectos,
        ]);
    }

    private function subirImagen(UploadedFile $file) {
        if($file->getClientSize() <= UploadedFile::getMaxFilesize()) {
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $path = $this->getParameter('public_img_directory');
            $file->move($path, $filename);
            return $path.'/'.$filename;
        }

        return null;
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
            if($projecto->getImg()) {
                $filepath = $this->uploader->upload($projecto->getImg());
                $path = $this->uploader->getUploadsDirectory().'/'.$filepath;
                $projecto->setImg($path);
            }

            $date = new \DateTime();
            // asigna fecha de creacion y el autor
            $projecto->setFechaCreacion($date);
            $projecto->setAutor($this->getUser());
            // crea un seguimineto inicial para el proyecto creado
            $situacion = new Seguimiento();
            $situacion->setSituacion("Proyecto Iniciado");
            $situacion->setDescripcion("Situación añadida al crear el proyecto");
            $situacion->setProyecto($projecto);
            $situacion->setUsuario($this->getUser());
            $situacion->setFecha($date);
            $projecto->addSeguimiento($situacion);
            // guardar en base de datos el objeto proyecto con su seguimiento
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
            if($proyecto->getImg()) {
                $filepath = $this->uploader->upload($proyecto->getImg());
                $path = $this->uploader->getUploadsDirectory().'/'.$filepath;
                $proyecto->setImg($path);
            }
            $situacion = new Seguimiento();
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
     * Elimina un proyecto
     * @param Project $proyecto
     * @return mixed
     */
    public function eliminarProyecto(Project $proyecto) {
        try {
            $usuario = $this->getUser();

            if(!isset($usuario)) {
                throw new \Exception('Debes iniciar sesion!');
            }

            if($proyecto->getAutor() == $usuario) {
                $manager = $this->getDoctrine()->getManager();
                $manager->remove($proyecto);
                $manager->flush();
            }

            return $this->redirectToRoute('usuario_perfil', [
               'id' => $usuario->getId()
            ]);
        } catch(\Exception $e) {
            return $this->redirectToRoute('editarProyecto', [
                'id' => $proyecto->getId(),
                'error' => $e->getMessage()
            ]);
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
            'proyectos' => $proyectos
        ]);
    }

    /**
     * Quita a un proyecto el estar destacado
     * @param Project $proyecto
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function quitarDestacado(Project $proyecto) {
        if($proyecto->getAutor() == $this->getUser()) {
            $proyecto->setDestacado(false);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($proyecto);
            $manager->flush();
        }

        return $this->redirectToRoute('editarProyecto', [
           'id' => $proyecto->getId()
        ]);
    }

    public function buscarProyectos(string $nombre) {
        $proyectos = $this->projectRepository->findByName($nombre);

        return $this->render('proyect/index.html.twig', [
            'proyectos' => $proyectos
        ]);
    }
}
