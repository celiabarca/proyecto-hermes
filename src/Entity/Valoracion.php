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
     * @var User
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="valoraciones")
     * @var Project
     */
    private $proyecto;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private $puntuacion;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUsuario(): User
    {
        return $this->usuario;
    }

    /**
     * @param User $usuario
     */
    public function setUsuario(User $usuario): void
    {
        $this->usuario = $usuario;
    }

    /**
     * @return Project
     */
    public function getProyecto(): Project
    {
        return $this->proyecto;
    }

    /**
     * @param Project $proyecto
     */
    public function setProyecto(Project $proyecto): void
    {
        $this->proyecto = $proyecto;
    }

    /**
     * @return float
     */
    public function getPuntuacion(): float
    {
        return $this->puntuacion;
    }

    /**
     * @param float $puntuacion
     */
    public function setPuntuacion(float $puntuacion): void
    {
        $this->puntuacion = $puntuacion;
    }

}
