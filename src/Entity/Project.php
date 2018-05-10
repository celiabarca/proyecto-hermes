<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Yaml\Tests\A;

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
     */
    private $titulo;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", length=2048)
     */
    private $contenido;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaCreacion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="proyectos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $autor;

    /**
     * @ORM\JoinTable(name="proyectos_patrocinadores")
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="patrocinios")
     */
    private $patrocinadores;

    /**
     * @ORM\JoinTable(name="proyectos_colaboradores")
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="colaboraciones")
     */
    private $colaboradores;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="proyectos", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $etiquetas;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Seguimiento", mappedBy="proyecto")
     */
    private $seguimientos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Valoracion", mappedBy="proyecto")
     */
    private $valoraciones;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="proyecto")
     */
    private $comentarios;

    /**
     * @ORM\Column(type="boolean")
     */
    private $destacado = false;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Donacion", mappedBy="proyecto")
     */
    private $donaciones;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $meta;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Actividad", mappedBy="proyecto")
     */
    private $actividades;

    public function __construct() {
        $this->comentarios = new ArrayCollection();
        $this->donaciones = new ArrayCollection();
        $this->valoraciones = new ArrayCollection();
        $this->etiquetas = new ArrayCollection();
        $this->colaboradores = new ArrayCollection();
        $this->actividades = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitulo()
    {
        if (!$this->titulo)
        {
            return "";
        }
        return $this->titulo;
    }

    /**
     * @param mixed $titulo
     */
    public function setTitulo($titulo): void
    {
        $this->titulo = $titulo;
    }

    /**
     * @return mixed
     */
    public function getDescripcion()
    {
        if (!$this->descripcion)
        {
            return "";
        }
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getContenido()
    {
        if (!$this->contenido)
        {
            return "";
        }
        return $this->contenido;
    }

    /**
     * @param mixed $contenido
     */
    public function setContenido($contenido): void
    {
        $this->contenido = $contenido;
    }

    /**
     * @return mixed
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * @param mixed $fechaCreacion
     */
    public function setFechaCreacion($fechaCreacion): void
    {
        $this->fechaCreacion = $fechaCreacion;
    }


    /**
     * @return mixed
     */
    public function getPatrocinadores()
    {
        return $this->patrocinadores;
    }

    /**
     * @param mixed $patrocinadores
     */
    public function setPatrocinadores($patrocinadores): void
    {
        $this->patrocinadores = $patrocinadores;
    }

    /**
     * @return mixed
     */
    public function getColaboradores()
    {
        return $this->colaboradores;
    }

    /**
     * @param mixed $colaboradores
     */
    public function setColaboradores($colaboradores): void
    {
        $this->colaboradores = $colaboradores;
    }

    /**
     * @return mixed
     */
    public function getEtiquetas()
    {
        return $this->etiquetas;
    }

    /**
     * @param mixed $etiquetas
     */
    public function setEtiquetas($etiquetas): void
    {
        $this->etiquetas = $etiquetas;
    }

    /**
     * @return mixed
     */
    public function getSeguimientos()
    {
        return $this->seguimientos;
    }

    /**
     * @param mixed $seguimientos
     */
    public function setSeguimientos($seguimientos): void
    {
        $this->seguimientos = $seguimientos;
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
    public function getMeta()
    {
        if(!$this->meta)
        {
            return 0;
        }
        return $this->meta;
    }

    /**
     * @param mixed $meta
     */
    public function setMeta($meta): void
    {
        $this->meta = $meta;
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        if(!$this->img)
        {
            return "";
        }
        return $this->img;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img): void
    {
        $this->img = $img;
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
     * @return mixed
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * @param mixed $autor
     */
    public function setAutor($autor): void
    {
        $this->autor = $autor;
    }

    /**
     * @return mixed
     */
    public function getActividades()
    {
        return $this->actividades;
    }

    /**
     * @param mixed $actividades
     */
    public function setActividades($actividades): void
    {
        $this->actividades = $actividades;
    }

}
