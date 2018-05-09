<?php

namespace App\Entity;

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
     * @ORM\Column(type="string", length=250)
     * @var string
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", length=2048)
     * @var string
     */
    private $contenido;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $fechaCreacion;

    /**
     * @ORM\JoinTable(name="proyectos_autores")
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="proyectos")
     * @ORM\JoinColumn(nullable=false)
     * @var ArrayCollection
     */
    private $autores;

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
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="proyectos", cascade={"persist"})
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

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $img;

    public function __construct() {
        $this->autores = new ArrayCollection();
        $this->comentarios = new ArrayCollection();
        $this->donaciones = new ArrayCollection();
        $this->valoraciones = new ArrayCollection();
        $this->etiquetas = new ArrayCollection();
        $this->colaboradores = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitulo(): string
    {
        if (!$this->titulo)
        {
            return "";
        }
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
        if (!$this->descripcion)
        {
            return "";
        }
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
     * @return string
     */
    public function getContenido(): string
    {
        if (!$this->contenido)
        {
            return "";
        }
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
     * @return ArrayCollection
     */
    public function getAutores(): ArrayCollection
    {
        return $this->autores;
    }

    /**
     * @param ArrayCollection $autores
     */
    public function setAutores(ArrayCollection $autores): void
    {
        $this->autores = $autores;
    }

    /**
     * @return \DateTime
     */
    public function getFechaCreacion(): \DateTime
    {
        if (!$this->titulo)
        {
            return new Datetime();
        }
        
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

    public function addEtiquetas(Tag $etiquetas) {
        foreach($etiquetas as $etiqueta) {
            if(!$this->etiquetas->contains($etiqueta)) {
                $this->etiquetas->add($etiqueta);
            }
        }
    }

    public function removeEtiqueta(Tag $etiqueta) {
        $this->etiquetas->removeElement($etiqueta);
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
        if(!$this->meta)
        {
            return 0;
        }
        return $this->meta;
    }

    /**
     * @param float $meta
     */
    public function setMeta(float $meta): void
    {
        $this->meta = $meta;
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

}
