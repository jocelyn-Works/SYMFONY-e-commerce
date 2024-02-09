<?php

namespace App\Service;

use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PictureService
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function add(UploadedFile $picture, ?string $folder = '', ?int
    $width = 300, ?int $height = 300)
    {
        // nouveau nom de l'image
        $fichier = md5(uniqid(rand(), true)) . '.webp';

        // récupére les infos de l'image
        $picture_infos = getimagesize($picture);

        if ($picture_infos === false) {
            throw new Exception('Format d\'image incorecte');
        }

        // on verifie le format de l'image 
        switch ($picture_infos['mime']) {
            case 'image/png':
                $picture_source = imagecreatefrompng($picture);
                break;
            case 'image/jpg':
                $picture_source = imagecreatefromjpeg($picture);
                break;
            case 'image/webp':
                $picture_source = imagecreatefromwebp($picture);
                break;

            default:
                throw new Exception('Format d\'image incorecte');
                break;
        }

        // on recadre l'image 
        // récupére les dimmensions
        $imageWidht = $picture_infos[0];
        $imageHeight = $picture_infos[1];

        // on verifie l'orientation de l'image 
        // <=>  : 1er : inferieure à   , 2emme : egale a  , 3eme : superieure à
        switch ($imageWidht <=> $imageHeight) {
            case -1: //portrait
                $squareSize = $imageWidht;
                $src_x = 0;
                $src_y = ($imageHeight - $squareSize) / 2;
                break;
            case 0: //carré
                $squareSize = $imageWidht;
                $src_x = 0;
                $src_y = 0;
                break;
            case 1: //paysage
                $squareSize = $imageHeight;
                $src_x = ($imageWidht - $squareSize) / 2;
                $src_y = 0;
                break;

            default:
                # code...
                break;
        }

        // on crée une nouvelle image 
        $resize_picture = imagecreatetruecolor($width, $height);

        imagecopyresampled($resize_picture, $picture_source, 0, 0, $src_x, $src_y, $width, $height, $squareSize, $squareSize);

        $path = $this->params->get('images_directory') . $folder;

        // crée le dossier de destination s'il nexiste pas
        if (!file_exists($path . '/mini/')) {
            mkdir($path . '/mini/', 0755, true);
        }

        // stoke l'image recadré 
        imagewebp($resize_picture, $path . '/mini/' . $width . 'x' . $height . '-' . $fichier);

        $picture->move($path . '/', $fichier);

        return $fichier;
    }

    public function delete(string $fichier, ?string $folder = '', ?int
    $width = 300, ?int $height = 300)
    {
        if ($fichier !== 'default.webp') {
            $succes = false;
            $path = $this->params->get('images_directory') . $folder;

            $mini = $path . '/mini/' . $width . 'x' . $height . '-' . $fichier;
            if (file_exists($mini)) {
                unlink($mini);
                $succes = true;
            }

            $original = $path . '/' . $fichier;

            if (file_exists($original)) {
                unlink($mini);
                $succes = true;
            }
            return $succes;
        }
        return false;
    }
}
