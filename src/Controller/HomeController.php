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

    public function __construct(ProyectController $pc) {
        $this->pc = $pc;
    }

    public function index() {
        $proyectos = $this->pc->dameProyectos();

        $form = $this->createForm(RegisterType::class, null, [
            'action' => '/registrarse'
        ]);

        return $this->render('inicio/index.html.twig', [
            'usuarios' => [],
            'proyectos' => $proyectos,
            'error' => null,
            'form' => $form->createView()
        ]);
    }

}