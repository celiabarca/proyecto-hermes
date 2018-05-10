<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ValoracionRepository")
 */
class Valoracion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="valoracion")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="valoraciones")
     * @ORM\JoinColumn(nullable=false)
     */
    private $proyecto;

    /**
     * @ORM\Column(type="float")
     */
    private $puntuacion;

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
    public function getPuntuacion()
    {
        return $this->puntuacion;
    }

    /**
     * @param mixed $puntuacion
     */
    public function setPuntuacion($puntuacion): void
    {
        $this->puntuacion = $puntuacion;
    }

}
