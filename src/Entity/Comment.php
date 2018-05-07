<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $contenido;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="comentarios")
     * @var Project
     */
    private $proyecto;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comentarios")
     * @var User
     */
    private $autor;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $fechacreacion;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getContenido(): string
    {
        return $this->contenido;
    }

    /**
     * @param string $contenido
     */
    public function setContenido(string $contenido): void
    {
        $this->contenido = $contenido;
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
     * @return User
     */
    public function getAutor(): User
    {
        return $this->autor;
    }

    /**
     * @param User $autor
     */
    public function setAutor(User $autor): void
    {
        $this->autor = $autor;
    }

    /**
     * @return \DateTime
     */
    public function getFechacreacion(): \DateTime
    {
        return $this->fechacreacion;
    }

    /**
     * @param \DateTime $fechacreacion
     */
    public function setFechacreacion(\DateTime $fechacreacion): void
    {
        $this->fechacreacion = $fechacreacion;
    }

}
