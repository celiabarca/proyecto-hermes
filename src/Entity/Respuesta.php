<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RespuestaRepository")
 */
class Respuesta extends Comment {

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Comment", inversedBy="respuestas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $comentario;

    /**
     * @return mixed
     */
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

}
