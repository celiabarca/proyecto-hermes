<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActividadRepository")
 */
class Actividad
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="actividades")
<<<<<<< HEAD
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
=======
     * @ORM\JoinColumn(nullable=false, onDelete="cascade")
>>>>>>> e52575a634a68d652f841f4c42caa027c2377b15
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="actividades")
<<<<<<< HEAD
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
=======
     * @ORM\JoinColumn(nullable=false, onDelete="cascade")
>>>>>>> e52575a634a68d652f841f4c42caa027c2377b15
     */
    private $proyecto;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $tipo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $actividad;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario): void
    {
        $this->usuario = $usuario;
    }

    /**
     * @return mixed
     */
    public function getProyecto()
    {
        return $this->proyecto;
    }

    /**
     * @param mixed $proyecto
     */
    public function setProyecto($proyecto): void
    {
        $this->proyecto = $proyecto;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo): void
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getActividad()
    {
        return $this->actividad;
    }

    /**
     * @param mixed $actividad
     */
    public function setActividad($actividad): void
    {
        $this->actividad = $actividad;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha): void
    {
        $this->fecha = $fecha;
    }

}
