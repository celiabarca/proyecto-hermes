<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SeguimientoRepository")
 */
class Seguimiento
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="seguimientos")
     * @var Project
     */
    private $proyecto;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="seguimientos")
     * @var User
     */
    private $usuario;

    /**
     * @ORM\Column(type="string", length=60)
     * @var string
     */
    private $situacion;

    public function getId()
    {
        return $this->id;
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
     * @return \DateTime
     */
    public function getFecha(): \DateTime
    {
        return $this->fecha;
    }

    /**
     * @param \DateTime $fecha
     */
    public function setFecha(\DateTime $fecha): void
    {
        $this->fecha = $fecha;
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
     * @return string
     */
    public function getSituacion(): string
    {
        return $this->situacion;
    }

    /**
     * @param string $situacion
     */
    public function setSituacion(string $situacion): void
    {
        $this->situacion = $situacion;
    }

}
