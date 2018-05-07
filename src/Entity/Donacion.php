<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DonacionRepository")
 */
class Donacion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="donaciones")
     * @var User
     */
    private $usuario;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private $cantidad;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="donaciones")
     * @var Project
     */
    private $proyecto;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $fechaDonacion;

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
     * @return float
     */
    public function getCantidad(): float
    {
        return $this->cantidad;
    }

    /**
     * @param float $cantidad
     */
    public function setCantidad(float $cantidad): void
    {
        $this->cantidad = $cantidad;
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
    public function getFechaDonacion(): \DateTime
    {
        return $this->fechaDonacion;
    }

    /**
     * @param \DateTime $fechaDonacion
     */
    public function setFechaDonacion(\DateTime $fechaDonacion): void
    {
        $this->fechaDonacion = $fechaDonacion;
    }

}
