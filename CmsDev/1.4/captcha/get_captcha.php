<?php

session_start();

$string = '';

for ($i = 0; $i < 6; $i++) {
    $string .= chr(rand(97, 122));
}

$_SESSION['random_number'] = $string;

$dir = './fonts/';

$image = imagecreatetruecolor(213, 36);

// random number 1 or 2
$num = rand(1, 3);
if ($num == 1) {
    $font = "Capture it 2.ttf"; // font style
} else if ($num == 2) {
    $font = "ActionIs.ttf"; // font style
} else {
    $font = "Screwed.ttf"; // font style
}

// random number 1 or 2
$num2 = rand(1, 2);
$r1 = rand(150, 255);
$r2 = rand(150, 255);
$r3 = rand(150, 255);
$color = imagecolorallocate($image, $r1, $r2, $r3); // color

$bg = imagecolorallocate($image, 6, 167, 235); // background color white
imagefilledrectangle($image, 0, 0, 399, 99, $bg);

imagettftext($image, 30, 3, 20, 35, $color, $dir . $font, $_SESSION['random_number']);

header("Content-type: image/png");
imagepng($image);
?>