<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 */
class Tag
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Project", mappedBy="etiquetas")
     * @var ArrayCollection
     */
    private $proyectos;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
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
    
}
