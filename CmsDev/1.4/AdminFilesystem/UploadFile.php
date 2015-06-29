<?php

function _ckdir($fn) {
    if (strpos($fn, "/") !== false) {
        $p = substr($fn, 0, strrpos($fn, "/"));
        if (!is_dir($p)) {
            _o("Mkdir: " . $p);
            mkdir($p, 777, true);
        }
    }
}

function img_resizer($src, $quality, $w, $h, $saveas) {
    $r = 1;
    $e = strtolower(substr($src, strrpos($src, ".") + 1, 3));
    if (($e == "jpg") || ($e == "jpeg")) {
        $OldImage = imagecreatefromjpeg($src) or $r = 0;
    } elseif ($e == "gif") {

        $OldImage = ImageCreateFromGif($src) or $r = 0;
    } elseif ($e == "bmp") {

        $OldImage = ImageCreateFromwbmp($src) or $r = 0;
    } elseif ($e == "png") {

        $OldImage = ImageCreateFromPng($src) or $r = 0;
    } else {
        _o("No es una imagen v&aacute;lida! (" . $e . ") -- " . $src);
        $r = 0;
    }
    if ($r) {
        list($width, $height) = getimagesize($src);
        // check if ratios match
        $_ratio = array($width / $height, $w / $h);
        if ($_ratio[0] != $_ratio[1]) { // crop image
            // find the right scale to use
            $_scale = min((float) ($width / $w), (float) ($height / $h));
            // coords to crop
            $cropX = (float) ($width - ($_scale * $w));
            $cropY = (float) ($height - ($_scale * $h));
            // cropped image size
            $cropW = (float) ($width - $cropX);
            $cropH = (float) ($height - $cropY);
            $crop = ImageCreateTrueColor($cropW, $cropH);
            // crop the middle part of the image to fit proportions
            ImageCopy(
                    $crop, $OldImage, 0, 0, (int) ($cropX / 2), (int) ($cropY / 2), $cropW, $cropH
            );
        }
        // do the thumbnail
        $NewThumb = ImageCreateTrueColor($w, $h);
        if (isset($crop)) { // been cropped
            ImageCopyResampled(
                    $NewThumb, $crop, 0, 0, 0, 0, $w, $h, $cropW, $cropH
            );

            ImageDestroy($crop);
        } else { // ratio match, regular resize
            ImageCopyResampled(
                    $NewThumb, $OldImage, 0, 0, 0, 0, $w, $h, $width, $height
            );
        }
        _ckdir($saveas);
        ImageJpeg($NewThumb, $saveas, $quality);
        //ImageDestroy($NewThumb);
        //ImageDestroy($OldImage);
    }
    return $r;
}

if (isset($_FILES['userfile']['name']) && $_FILES['userfile']['name'] != '') {
    $UpFileInFolder = $FolderDecode;
    $FileNewFile = $_FILES['userfile']['name'];
    $extension = explode(".", $FileNewFile);
    $num = count($extension) - 1;
    $ext = strtolower($extension[$num]);
    $Message = '';
    if ($ext == 'jpeg') {
        $ext = 'jpg';
    }
    if ($ext == 'mpeg') {
        $ext = 'mpg';
    }
    $Type_File = strtolower($ext);
    $FileNewFile = str_replace($ext, $Type_File, $_FILES['userfile']['name']);
    if (isset($_POST['FileNewFileName']) && $_POST['FileNewFileName'] != '') {
        $FileNewFile = $_POST['FileNewFileName'] . '.' . $Type_File;
    }
    $FileNew_correct = str_replace(" ", "_", $FileNewFile);
    $FileNew_correct = str_replace("Ñ", "n", $FileNew_correct);
    $FileNew_correct = str_replace("ñ", "n", $FileNew_correct);
    $FileNew_correct = str_replace("á", "a", $FileNew_correct);
    $FileNew_correct = str_replace("é", "e", $FileNew_correct);
    $FileNew_correct = str_replace("í", "i", $FileNew_correct);
    $FileNew_correct = str_replace("ó", "o", $FileNew_correct);
    $FileNew_correct = str_replace("ú", "u", $FileNew_correct);
    $FileNew_correct = str_replace("Á", "A", $FileNew_correct);
    $FileNew_correct = str_replace("É", "E", $FileNew_correct);
    $FileNew_correct = str_replace("Í", "I", $FileNew_correct);
    $FileNew_correct = str_replace("Ó", "O", $FileNew_correct);
    $FileNew_correct = str_replace("Ú", "U", $FileNew_correct);
    $FileNew_correct = str_replace(",", "-", $FileNew_correct);
    $FileNew_correct = str_replace("(", "-", $FileNew_correct);
    $FileNew_correct = str_replace(")", "-", $FileNew_correct);
    $FileNew_correct = str_replace("\"", "-", $FileNew_correct);
    $FileNew_correct = str_replace("`", "", $FileNew_correct);
    $FileNew_correct = str_replace("@", "", $FileNew_correct);
    $FileNew_correct = str_replace("\"", "", $FileNew_correct);
    $FileNew_correct = str_replace("$", "s", $FileNew_correct);
    $FileNew_correct = str_replace("º", "0", $FileNew_correct);

    if ($_FILES['userfile']['size'] > $MAX_FILE_SIZE) {
        $Message .= '<h5 class="alert alert-warning"><i class="skt-icon-error"></i> El archivo supera el peso permitido</h5>'; /* $InfoFileUpload1
          . $InfoFileUpload2
          . $Type_File
          . $InfoFileUpload3
          . $InfoFileUpload4; */
    } else {
        $FileCopyLocation = $UpFileInFolder . DIRECTORY_SEPARATOR . $FileNew_correct;
        $FileCopyLocation = str_replace('/', DIRECTORY_SEPARATOR, $FileCopyLocation);
        $FileCopyLocation = str_replace('//', DIRECTORY_SEPARATOR, $FileCopyLocation);
        $FileCopyLocation = str_replace('\\', DIRECTORY_SEPARATOR, $FileCopyLocation);
        echo $FileCopyLocation;
        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $FileCopyLocation)) {
            //echo $UpFileInFolder.$FileNew_correct;
            if (isset($_POST['FileNewFileX']) && $_POST['FileNewFileX'] != '' && isset($_POST['FileNewFileY']) && $_POST['FileNewFileY'] != '') {
                $info = getimagesize($FileCopyLocation);
                $anchofoto = $info[0];
                $altofoto = $info[1];
                img_resizer($FileCopyLocation, 85, $_POST['FileNewFileX'], $_POST['FileNewFileY'], $FileCopyLocation);
            }
            $Message.= '<h5 class="alert alert-success"><i class="skt-icon-ok"></i> El archivo ' . $FileNewFile . ' fue cargado correctamente.</h5>';
        } else {
            $Message.= '<h5 class="alert alert-warning"><i class="skt-icon-error"></i> Ha ocurrido un error al cargar el archivo: ' . $FileNewFile . ".</h5>";
        }
    }
    echo $Message;
}