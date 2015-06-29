<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TextToImage
 *
 * @author Martín Daguerre
 */

namespace CmsDev\CustomControl\TextToImage;

class TextToImage {

    public function getImage($text) {
        //$text = '' . $this->maxWidth . ' x ' . $this->maxHeight . 'px';
        $dir = './fonts/';
        $image = $_SERVER["DOCUMENT_ROOT"] . '/_FileSystems/images/avatar.png';
        $jpgimage = \imagecreatefromjpeg($image);
        $font = "Screwed.ttf";
        $color = \imagecolorallocate($image, 255, 255, 255);

        list($img_width, $img_height) = \getimagesize($jpgimage);
        $font_size = 10;
        $y = $img_height * 0.9;
        $x = $img_width / 2;
        \imagettftext($jpgimage, $font_size, 0, $x, $y, $color, $dir . $font, $text);
        \header("Content-type: image/png");
        \imagepng($jpgimage);
    }

}

$TextToImage = new \CmsDev\CustomControl\TextToImage\TextToImage();
$TextToImage->getImage('255 x 200px');
