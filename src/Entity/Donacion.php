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
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $usuario;

    /**
     * @ORM\Column(type="float")
     */
    private $cantidad;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="donaciones")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $proyecto;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaDonacion;

    public function __construct() {
        $this->fechaDonacion = new \DateTime();
    }
    
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
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad): void
    {
        $this->cantidad = $cantidad;
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
    public function getFechaDonacion()
    {
        return $this->fechaDonacion;
    }

    /**
     * @param mixed $fechaDonacion
     */
    public function setFechaDonacion($fechaDonacion): void
    {
        $this->fechaDonacion = $fechaDonacion;
    }

}
