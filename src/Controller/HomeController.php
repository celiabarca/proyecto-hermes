<?php
/**
 * Created by PhpStorm.
 * User: magonxesp
 * Date: 8/05/18
 * Time: 17:19
 */

namespace App\Controller;

use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Repository\UserRepository;

class HomeController extends Controller {

    private $pc;
    private $userRepository;

    /**
     * Injecta dependencias necesarias para visualizar la página de inicio
     * @param \App\Controller\ProyectController $pc
     * @param \App\Repository\UserRepository $userRepository
     */
    public function __construct(ProyectController $pc, UserRepository $userRepository) {
        $this->pc = $pc;
        $this->userRepository = $userRepository;
    }

    /**
     * Renderiza la página principal
     * @return mixed
     */
    public function index() {
        $proyectos = $this->pc->dameProyectos(2);
     
        $form = $this->createForm(RegisterType::class, null, [
            'action' => $this->generateUrl('registrarse')
        ]);

        $user = $this->userRepository->findAll();
        return $this->render('inicio/index.html.twig', [
            'usuarios' => $user,
            'proyectos' => $proyectos,
            'error' => null,
            'form' => $form->createView()
        ]);
    }

}