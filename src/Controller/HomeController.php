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

    public function index() {
        $form = $this->createForm(RegisterType::class, null, [
            'action' => '/registrarse'
        ]);

        return $this->render('inicio/index.html.twig', [
            'usuarios' => [],
            'proyectos' => [],
            'error' => null,
            'form' => $form->createView()
        ]);
    }

}