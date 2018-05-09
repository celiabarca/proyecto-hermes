<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
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
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $empresa;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $sector;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Valoracionusuario", mappedBy="usuario")
     */
    private $valorados;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Valoracionusuario", mappedBy="usuarioValorado")
     */
    private $valoraciones;

    /**
     * @ORM\Column(type="boolean")
     */
    private $destacado = false;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="autor")
     */
    private $comentarios;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Donacion", mappedBy="usuario")
     */
    private $donaciones;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Project", mappedBy="autor")
     */
    private $proyectos;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $rol = 'ROLE_USER';

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img = '/assets/img/mi_imagen.png';

    public function __construct() {
        $this->proyectos = new ArrayCollection();
        $this->donaciones = new ArrayCollection();
        $this->comentarios = new ArrayCollection();
        $this->valoraciones = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @param mixed $telefono
     */
    public function setTelefono($telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * @param mixed $empresa
     */
    public function setEmpresa($empresa): void
    {
        $this->empresa = $empresa;
    }

    /**
     * @return mixed
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * @param mixed $sector
     */
    public function setSector($sector): void
    {
        $this->sector = $sector;
    }

    /**
     * @return mixed
     */
    public function getValorados()
    {
        return $this->valorados;
    }

    /**
     * @param mixed $valorados
     */
    public function setValorados($valorados): void
    {
        $this->valorados = $valorados;
    }

    /**
     * @return mixed
     */
    public function getValoraciones()
    {
        return $this->valoraciones;
    }

    /**
     * @param mixed $valoraciones
     */
    public function setValoraciones($valoraciones): void
    {
        $this->valoraciones = $valoraciones;
    }

    /**
     * @return mixed
     */
    public function getDestacado()
    {
        return $this->destacado;
    }

    /**
     * @param mixed $destacado
     */
    public function setDestacado($destacado): void
    {
        $this->destacado = $destacado;
    }

    /**
     * @return mixed
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * @param mixed $comentarios
     */
    public function setComentarios($comentarios): void
    {
        $this->comentarios = $comentarios;
    }

    /**
     * @return mixed
     */
    public function getDonaciones()
    {
        return $this->donaciones;
    }

    /**
     * @param mixed $donaciones
     */
    public function setDonaciones($donaciones): void
    {
        $this->donaciones = $donaciones;
    }

    /**
     * @return mixed
     */
    public function getProyectos()
    {
        return $this->proyectos;
    }

    /**
     * @param mixed $proyectos
     */
    public function setProyectos($proyectos): void
    {
        $this->proyectos = $proyectos;
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img): void
    {
        $this->img = $img;
    }


    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return [$this->rol];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}
