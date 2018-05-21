<?php
/**
 * Created by PhpStorm.
 * User: magonxesp
 * Date: 11/05/18
 * Time: 19:59
 */

namespace App\Form\DataTransformer;


use App\Repository\UserRepository;
use Symfony\Component\Form\DataTransformerInterface;

class ColaboradorArrayToStringTransformer implements DataTransformerInterface {

    private $colaboradores;

    public function __construct(UserRepository $colaboradores) {
        $this->colaboradores = $colaboradores;
    }

    public function transform($colaboradores): string {
        return implode(',', $colaboradores);
    }

    public function reverseTransform($string) {
        if($string === '' || $string === null) {
            return [];
        }

        $nombres = explode(',', $string);

        $objetos = $this->colaboradores->findBy([ 'nombre' => $nombres ]);

        return $objetos;
    }

}