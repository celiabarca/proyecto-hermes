<?php
/**
 * Created by PhpStorm.
 * User: magonxesp
 * Date: 16/05/18
 * Time: 17:27
 */

namespace App\Entity;


interface CommentInterface {
    public function setContenido($contenido);
    public function getContenido();
    public function setAutor($autor);
    public function getAutor();
    public function setFechacreacion($fechacreacion);
    public function getFechacreacion();
}