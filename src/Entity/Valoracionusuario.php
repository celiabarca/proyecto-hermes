<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ValoracionusuarioRepository")
 */
class Valoracionusuario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="valorados")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="valoraciones")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuarioValorado;

    /**
     * @ORM\Column(type="float")
     */
    private $valoracion;

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
    public function getUsuarioValorado()
    {
        return $this->usuarioValorado;
    }

    /**
     * @param mixed $usuarioValorado
     */
    public function setUsuarioValorado($usuarioValorado): void
    {
        $this->usuarioValorado = $usuarioValorado;
    }

    /**
     * @return mixed
     */
    public function getValoracion()
    {
        return $this->valoracion;
    }

    /**
     * @param mixed $valoracion
     */
    public function setValoracion($valoracion): void
    {
        $this->valoracion = $valoracion;
    }

}
