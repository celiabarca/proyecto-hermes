<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DonacionesController extends Controller
{
    /**
     * @Route("/donaciones", name="donaciones")
     */
    public function index()
    {
        return $this->render('donaciones/index.html.twig', [
            'controller_name' => 'DonacionesController',
        ]);
    }
}
