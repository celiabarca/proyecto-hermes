<?php
/**
 * Created by PhpStorm.
 * User: magonx
 * Date: 29/05/18
 * Time: 20:08
 */

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader {

    private $targetDirectory;

    public function __construct($targetDirectory) {
        $this->targetDirectory = $targetDirectory;
    }

    /**
     * Sube un archivo al servidor
     * @param UploadedFile $file
     * @return string
     */
    public function upload(UploadedFile $file) {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->targetDirectory, $fileName);
        return $fileName;
    }

    /**
     * Devuelve la ruta a partir del directorio public
     * @return string
     */
    public function getUploadsDirectory() {
        $string = preg_split('public', $this->targetDirectory);
        return $string[1]; // retorna la ruta desde el directorio public
    }

}