<?php

//    echo "wget = " . $wget . "<br>";
//    echo "hget = " . $hget . "<br>";
//    echo "cget = " . $cget . "<br>";
//    echo "image = " . $image . "<br>";
//    echo "src = " . $src . "<br>";
//    echo "params = " . $params . "<br>";
//    echo "w = " . $w . "<br>";
//    echo "h = " . $h . "<br>";
//    echo "c = " . $c . "<br>";
//    echo "e = " . $e . "<br>";


function image_resize($src, $width, $height, $crop = 1) {

    if (!list($w, $h) = getimagesize($src))
        return "Unsupported picture type!";

    $type = strtolower(substr(strrchr($src, "."), 1));

    switch ($type) {
        case 'bmp': $img = imagecreatefromwbmp($src);
            break;
        case 'gif': $img = imagecreatefromgif($src);
            break;
        case 'png': $img = imagecreatefrompng($src);
            break;
        default : return "Unsupported picture type!";
    }

    // resize
    if ($crop == 1) {
        if ($w < $width or $h < $height) {
            $h = $height;
            $x = ($w - $width) / 2;
            $w = $width;
        } else {
            $ratio = max($width / $w, $height / $h);
            $h = $height / $ratio;
            $x = ($w - $width / $ratio) / 2;
            $w = $width / $ratio;
        }
    } else {
        if ($w > $width or $h > $height) {
            $h = $height;
            $x = ($w - $width) / 2;
            $w = $width;
        } else {
            $ratio = min($width / $w, $height / $h);
            $width = $w * $ratio;
            $height = $h * $ratio;
            $width = $w;
            $height = $h;
            $x = 0;
        }
    }

    $new = imagecreatetruecolor($width, $height);
    imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
    imagealphablending($new, false);
    imagesavealpha($new, false);
    imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);

    switch ($type) {
        case 'bmp': header('Content-Type: image/bmp');
            imagewbmp($new);
            break;
        case 'gif': header('Content-Type: image/gif');
            imagegif($new);
            break;
        case 'png': header('Content-Type: image/png');
            imagepng($new);
            break;
    }
    return true;
}

\image_resize($src, $w, $h, $c);
?>