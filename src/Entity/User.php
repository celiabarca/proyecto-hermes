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
     * @var string
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=15)
     * @var string
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=60)
     * @var string
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Valoracionusuario", mappedBy="usuario")
     * @var ArrayCollection
     */
    private $valorados;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Valoracionusuario", mappedBy="usuarioValorado")
     * @var ArrayCollection
     */
    private $valoraciones;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $destacado = false;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="autor")
     * @var ArrayCollection
     */
    private $comentarios;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Donacion", mappedBy="usuario")
     * @var ArrayCollection
     */
    private $donaciones;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Project", mappedBy="autor")
     * @var ArrayCollection
     */
    private $proyectos;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $img;

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

    /**
     * @return ArrayCollection
     */
    public function getComentarios(): ArrayCollection
    {
        return $this->comentarios;
    }

    /**
     * @param ArrayCollection $comentarios
     */
    public function setComentarios(ArrayCollection $comentarios): void
    {
        $this->comentarios = $comentarios;
    }

    /**
     * @return ArrayCollection
     */
    public function getDonaciones(): ArrayCollection
    {
        return $this->donaciones;
    }

    /**
     * @param ArrayCollection $donaciones
     */
    public function setDonaciones(ArrayCollection $donaciones): void
    {
        $this->donaciones = $donaciones;
    }

    /**
     * @return ArrayCollection
     */
    public function getProyectos(): ArrayCollection
    {
        return $this->proyectos;
    }

    /**
     * @param ArrayCollection $proyectos
     */
    public function setProyectos(ArrayCollection $proyectos): void
    {
        $this->proyectos = $proyectos;
    }

    /**
     * @return ArrayCollection
     */
    public function getValorados(): ArrayCollection
    {
        return $this->valorados;
    }

    /**
     * @param ArrayCollection $valorados
     */
    public function setValorados(ArrayCollection $valorados): void
    {
        $this->valorados = $valorados;
    }

    /**
     * @return ArrayCollection
     */
    public function getValoraciones(): ArrayCollection
    {
        return $this->valoraciones;
    }

    /**
     * @param ArrayCollection $valoraciones
     */
    public function setValoraciones(ArrayCollection $valoraciones): void
    {
        $this->valoraciones = $valoraciones;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getImg(): string
    {
        return $this->img;
    }

    /**
     * @param string $img
     */
    public function setImg(string $img): void
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
        return [
            'ROLE_USER'
        ];
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
