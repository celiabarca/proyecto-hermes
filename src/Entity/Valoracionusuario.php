<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ValoracionusuarioRepository")
 */
class ValoracionUsuario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="valorados")
     * @var User
     */
    private $usuario;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="valoraciones")
     * @var User
     */
    private $usuarioValorado;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    private $valoracion;

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
     * @return mixed
     */
    public function getUsuarioValorado(): User
    {
        return $this->usuarioValorado;
    }

    /**
     * @param mixed $usuarioValorado
     */
    public function setUsuarioValorado(User $usuarioValorado): void
    {
        $this->usuarioValorado = $usuarioValorado;
    }

    /**
     * @return float
     */
    public function getValoracion(): float
    {
        return $this->valoracion;
    }

    /**
     * @param float $valoracion
     */
    public function setValoracion(float $valoracion): void
    {
        $this->valoracion = $valoracion;
    }

}
