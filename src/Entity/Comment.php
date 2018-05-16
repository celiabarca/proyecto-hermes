<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment implements CommentInterface {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contenido;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="comentarios")
     * @ORM\JoinColumn(nullable=false)
     */
    private $proyecto;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comentarios")
     * @ORM\JoinColumn(nullable=false)
     */
    private $autor;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechacreacion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Respuesta", mappedBy="comentario")
     */
    private $respuestas;

    public function __construct() {
        $this->respuestas = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * @param mixed $contenido
     */
    public function setContenido($contenido): void
    {
        $this->contenido = $contenido;
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
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * @param mixed $autor
     */
    public function setAutor($autor): void
    {
        $this->autor = $autor;
    }

    /**
     * @return mixed
     */
    public function getFechacreacion()
    {
        return $this->fechacreacion->format("d/m/y");
    }

    /**
     * @param mixed $fechacreacion
     */
    public function setFechacreacion($fechacreacion): void
    {
        $this->fechacreacion = $fechacreacion;
    }

    /**
     * @return mixed
     */
    public function getRespuestas()
    {
        return $this->respuestas;
    }

    /**
     * @param mixed $respuestas
     */
    public function setRespuestas($respuestas): void
    {
        $this->respuestas = $respuestas;
    }

}
