<?php
/**
 * Created by PhpStorm.
 * User: magonxesp
 * Date: 15/05/18
 * Time: 19:04
 */

namespace App\Controller;

use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class TagController extends Controller {

    private $tagrepository;

    public function __construct(TagRepository $repository) {
        $this->tagrepository = $repository;
    }

    /**
     * Preparado para AJAX
     * Devuelve todos los tags con un nombre parecido
     * @param string $nombre
     * @return JsonResponse
     */
    public function getTags(string $nombre) {
        $tags = $this->tagrepository->findByLikeName($nombre);
        $tagnames = [];

        foreach($tags as $tag) {
            $tagnames[] = [
                'nombre' => $tag->getNombre(),
                'numProyectos' => $tag->getProyectos()->count()
            ];
        }

        return new JsonResponse([
            'tags' => $tagnames
                ]
        );
    }

}