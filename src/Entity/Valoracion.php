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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="valoracion")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $usuario;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="valoraciones")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $proyecto;

    /**
     * @ORM\Column(type="boolean")
     */
    private $megusta;
    
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
    public function getMegusta()
    {
        return $this->megusta;
    }

    /**
     * @param mixed $megusta
     */
    public function setMegusta($megusta): void
    {
        $this->megusta = $megusta;
    }

}
