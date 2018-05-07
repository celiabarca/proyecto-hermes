<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     * @var string
     */
    private $titulo;

    /**
     * @ORM\Column(type="string", length=1024)
     * @var string
     */
    private $descripcion;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $fechaCreacion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="proyectos")
     * @ORM\JoinColumn(nullable=false)
     * @var ArrayCollection
     */
    private $autor;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="patrocinios")
     * @ORM\JoinColumn(nullable=false)
     * @var ArrayCollection
     */
    private $patrocinadores;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="colaboraciones")
     * @ORM\JoinColumn(nullable=false)
     * @var ArrayCollection
     */
    private $colaboradores;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="proyectos")
     * @ORM\JoinColumn(nullable=false)
     * @var ArrayCollection
     */
    private $etiquetas;

    /**
     * TODO seguimiento. Posible many to many
     */
    private $seguimiento;

    /**
     * TODO valoraciones
     */
    private $valoraciones;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="proyecto")
     * @var ArrayCollection
     */
    private $comentarios;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $destacado = false;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Donacion", mappedBy="proyecto")
     * @var ArrayCollection
     */
    private $donaciones;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $meta;

    public function getId()
    {
        return $this->id;
    }
}
