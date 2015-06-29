<?php
//var_dump($_GET);
function _ckdir($fn) {
    if (strpos($fn, "/") !== false) {
        $p = substr($fn, 0, strrpos($fn, "/"));
        if (!is_dir($p)) {
            //_o("Mkdir: " . $p);
            mkdir($p, 775, true);
        }
    }
}

$DS = DIRECTORY_SEPARATOR;
$quality = '50';
$w = '';
$h = '';
$c = 1;


$wget = isset($_GET['w']) ? $_GET['w'] : '';
$hget = isset($_GET['h']) ? $_GET['h'] : '';
$cget = isset($_GET['c']) ? $_GET['c'] : '';

$SKTimage = str_replace('_FileSystems/', '', $_GET['SKTimage']);
$SKTimagebase64 = str_replace('_FileSystems/', '', \base64_decode(\urldecode(\utf8_decode($_GET['SKTimage']))));

if (isset($DecodedURL) || $DecodedURL == 1) {
    //echo "decode1";
    $src = dirname(__FILE__) . $DS . $SKTimage;
} else {
    //echo "decode0";
    $src = dirname(__FILE__) . $DS . $SKTimagebase64;
}
//echo $src; exit;

$e = strtolower(substr($src, strrpos($src, ".") + 1, 3));
if ($wget != '') {
    $w = $wget;
}
if ($hget != '') {
    $h = $hget;
}
if ($cget == 'c') {
    $c = $cget;
}


$name = str_replace('.' . $e, '', $src);
$NewName = $name . '-' . $w . 'x' . $h . '.' . $e;
$saveas = $NewName = str_replace('_FileSystems/','_FileSystems/cache/',$NewName);

if (file_exists($NewName)) {
    header('Content-Type: image/jpeg');
    echo file_get_contents($NewName);
    //echo $NewName;
    exit();
}

if (!file_exists($src)) {
    $src = dirname(__FILE__) . $DS . 'dummy.png';
}

if ($wget == '' && $hget == '') {
    if (($e == "jpg") || ($e == "jpeg")) {
        header('Content-Type: image/jpeg');
        echo file_get_contents($src);
        exit();
    } else {
        switch ($e) {
            case 'bmp': header('Content-Type: image/bmp');
                break;
            case 'gif': header('Content-Type: image/gif');
                break;
            case 'png': header('Content-Type: image/png');
                break;
        }
        echo file_get_contents($src);
        exit();
    }
} else if (($e != "jpg") && ($e != "jpeg")) {
    require_once dirname(__FILE__) . '/Trumb.php';
    exit();
}

$r = 1;
$e = strtolower(substr($src, strrpos($src, ".") + 1, 3));
if (($e == "jpg") || ($e == "jpeg")) {
    $OldImage = ImageCreateFromJpeg($src) or $r = 0;
} else {
    $r = 0;
}
if ($r) {
    if ($e == "jpg") {
        list($width, $height) = getimagesize($src);
        $_ratio = array($width / $height, $w / $h);
        if ($_ratio[0] != $_ratio[1]) {
            $_scale = min((float) ($width / $w), (float) ($height / $h));
            $cropX = (float) ($width - ($_scale * $w));
            $cropY = (float) ($height - ($_scale * $h));
            $cropW = (float) ($width - $cropX);
            $cropH = (float) ($height - $cropY);
            $crop = ImageCreateTrueColor($cropW, $cropH);
            ImageCopy(
                    $crop, $OldImage, 0, 0, (int) ($cropX / 2), (int) ($cropY / 2), $cropW, $cropH
            );
        }
        $NewThumb = ImageCreateTrueColor($w, $h);
        if (isset($crop)) {
            ImageCopyResampled(
                    $NewThumb, $crop, 0, 0, 0, 0, $w, $h, $cropW, $cropH
            );
            ImageDestroy($crop);
        } else {
            ImageCopyResampled(
                    $NewThumb, $OldImage, 0, 0, 0, 0, $w, $h, $width, $height
            );
        }
    }
    _ckdir($saveas);
    ImageJpeg($NewThumb, $saveas, $quality);
    ImageDestroy($OldImage);
}
if (($e == "jpg") || ($e == "jpeg")) {
    header('Content-Type: image/jpeg');
    ImageJpeg($NewThumb);
    ImageDestroy($NewThumb);
} else {
    echo "No es una imagen v&aacute;lida! (" . $e . ") -- " . $src;
}
?>