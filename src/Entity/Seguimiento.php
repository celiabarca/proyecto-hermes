<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SeguimientoRepository")
 */
class Seguimiento
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="seguimientos")
     * @var Project
     */
    private $proyecto;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $fecha;

    public function getId()
    {
        return $this->id;
    }
}
