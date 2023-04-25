<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageService
{

    private $images_directory;

    public function __construct($images_directory)
    {
        $this->images_directory = $images_directory;
    }


    public function uploadImage($image)
    {
        $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        //$safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $newFilename = $originalFilename . '-' . uniqid() . '.' . $image->guessExtension();

        try {
            if (!is_dir($this->images_directory)) {
                mkdir($this->images_directory);
            }
            $image->move(
                $this->images_directory,
                $newFilename
            );
        } catch (FileException $e) {
            return $e->getMessage();
        }
        return $newFilename;
    }
}
