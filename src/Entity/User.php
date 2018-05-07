<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $password;

    /**
     * TODO
     */
    private $valoracion;

    /**
     * @ORM\Column(type="boolean")
     */
    private $destacado = false;

    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNombre(): string {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getTelefono(): string {
        return $this->telefono;
    }

    /**
     * @param string $telefono
     */
    public function setTelefono(string $telefono): void {
        $this->telefono = $telefono;
    }

    /**
     * @return mixed
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getValoracion() {
        return $this->valoracion;
    }

    /**
     * @param mixed $valoracion
     */
    public function setValoracion($valoracion): void {
        $this->valoracion = $valoracion;
    }

    /**
     * @return bool
     */
    public function getDestacado(): bool {
        return $this->destacado;
    }

    /**
     * @param bool $destacado
     */
    public function setDestacado(bool $destacado): void {
        $this->destacado = $destacado;
    }

}
