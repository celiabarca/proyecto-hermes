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
     * @ORM\JoinTable(name="proyectos_patrocinadores")
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="patrocinios")
     * @ORM\JoinColumn(nullable=false)
     * @var ArrayCollection
     */
    private $patrocinadores;

    /**
     * @ORM\JoinTable(name="proyectos_colaboradores")
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
     * @ORM\OneToMany(targetEntity="App\Entity\Seguimiento", mappedBy="proyecto")
     * @var ArrayCollection
     */
    private $seguimientos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Valoracion", mappedBy="proyecto")
     * @var ArrayCollection
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
     * @var float
     */
    private $meta;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitulo(): string
    {
        return $this->titulo;
    }

    /**
     * @param string $titulo
     */
    public function setTitulo(string $titulo): void
    {
        $this->titulo = $titulo;
    }

    /**
     * @return string
     */
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     */
    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return \DateTime
     */
    public function getFechaCreacion(): \DateTime
    {
        return $this->fechaCreacion;
    }

    /**
     * @param \DateTime $fechaCreacion
     */
    public function setFechaCreacion(\DateTime $fechaCreacion): void
    {
        $this->fechaCreacion = $fechaCreacion;
    }

    /**
     * @return ArrayCollection
     */
    public function getAutor(): ArrayCollection
    {
        return $this->autor;
    }

    /**
     * @param ArrayCollection $autor
     */
    public function setAutor(ArrayCollection $autor): void
    {
        $this->autor = $autor;
    }

    /**
     * @return ArrayCollection
     */
    public function getPatrocinadores(): ArrayCollection
    {
        return $this->patrocinadores;
    }

    /**
     * @param ArrayCollection $patrocinadores
     */
    public function setPatrocinadores(ArrayCollection $patrocinadores): void
    {
        $this->patrocinadores = $patrocinadores;
    }

    /**
     * @return ArrayCollection
     */
    public function getColaboradores(): ArrayCollection
    {
        return $this->colaboradores;
    }

    /**
     * @param ArrayCollection $colaboradores
     */
    public function setColaboradores(ArrayCollection $colaboradores): void
    {
        $this->colaboradores = $colaboradores;
    }

    /**
     * @return ArrayCollection
     */
    public function getEtiquetas(): ArrayCollection
    {
        return $this->etiquetas;
    }

    /**
     * @param ArrayCollection $etiquetas
     */
    public function setEtiquetas(ArrayCollection $etiquetas): void
    {
        $this->etiquetas = $etiquetas;
    }

    /**
     * @return ArrayCollection
     */
    public function getSeguimientos(): ArrayCollection
    {
        return $this->seguimientos;
    }

    /**
     * @param ArrayCollection $seguimientos
     */
    public function setSeguimientos(ArrayCollection $seguimientos): void
    {
        $this->seguimientos = $seguimientos;
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
     * @return bool
     */
    public function isDestacado(): bool
    {
        return $this->destacado;
    }

    /**
     * @param bool $destacado
     */
    public function setDestacado(bool $destacado): void
    {
        $this->destacado = $destacado;
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
     * @return float
     */
    public function getMeta(): float
    {
        return $this->meta;
    }

    /**
     * @param float $meta
     */
    public function setMeta(float $meta): void
    {
        $this->meta = $meta;
    }

}
