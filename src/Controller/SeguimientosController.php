<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SeguimientosController extends Controller
{
    /**
     * Añade una fase del seguimiento del proyecto
     * @param Project $proyecto
     */
    public function anyadirSeguimiento(Project $proyecto) {
        $seguimiento = new Seguimiento();
        // TODO mirar que no tenga mas de tres fases y añadir el seguimiento
    }
}
