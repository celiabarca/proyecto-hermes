<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RespuestaRepository")
 */
class Respuesta implements CommentInterface {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Comment", inversedBy="respuestas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $comentario;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="respuestas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $autor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contenido;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechacreacion;

    public function getId() {
        return $this->id;
    }

    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * @param mixed $comentario
     */
    public function setComentario($comentario): void
    {
        $this->comentario = $comentario;
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
    public function getFechacreacion()
    {
        return $this->fechacreacion;
    }

    /**
     * @param mixed $fechacreacion
     */
    public function setFechacreacion($fechacreacion): void
    {
        $this->fechacreacion = $fechacreacion;
    }

}
