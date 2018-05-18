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

class HomeController extends Controller {

    private $pc;
    private $user;

    /**
     * Injecta dependencias necesarias para visualizar la página de inicio
     * @param \App\Controller\ProyectController $pc
     * @param \App\Controller\UserController $user
     */
    public function __construct(ProyectController $pc, UserController $user) {
        $this->pc = $pc;
        $this->user = $user;
    }

    /**
     * Renderiza la página principal
     * @return type
     */
    public function index() {
        $proyectos = $this->pc->dameProyectos();
        $form = $this->createForm(RegisterType::class, null, [
            'action' => '/registrarse'
        ]);
        $user = $this->user->getTopUsers();
        return $this->render('inicio/index.html.twig', [
            'usuarios' => $user,
            'proyectos' => $proyectos,
            'error' => null,
            'form' => $form->createView()
        ]);
    }

}