<?php

if (session_id() == "") {
    session_start();
}
require (dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'DefinePath.php');
$VERSION = \SKT_VERSION;
$HandleUploadDir = \SKTPATH_FileSystems . 'images/';


if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {

    //$HandleUploadDir = str_replace('/','\\',$HandleUploadDir);
}

//echo $HandleUploadDir;



$ExtensionsCV = array("jpg", "png", "gif");

/**

 * Handle file uploads via XMLHttpRequest

 */
class qqUploadedFileXhr {

    /**

     * Save the file to the specified path

     * @return boolean TRUE on success

     */
    function save($path) {

        $input = fopen("php://input", "r");

        $temp = tmpfile();

        $realSize = stream_copy_to_stream($input, $temp);

        fclose($input);



        if ($realSize != $this->getSize()) {

            return false;
        }



        $target = fopen($path, "w");

        fseek($temp, 0, SEEK_SET);

        stream_copy_to_stream($temp, $target);

        fclose($target);



        return true;
    }

    function getName() {

        return $_GET['qqfile'];
    }

    function getSize() {

        if (isset($_SERVER["CONTENT_LENGTH"])) {

            return (int) $_SERVER["CONTENT_LENGTH"];
        } else {

            throw new Exception('Getting content length is not supported.');
        }
    }

}

/**

 * Handle file uploads via regular form post (uses the $_FILES array)

 */
class qqUploadedFileForm {

    /**

     * Save the file to the specified path

     * @return boolean TRUE on success

     */
    function save($path) {

        if (!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)) {

            return false;
        }

        return true;
    }

    function getName() {

        return $_FILES['qqfile']['name'];
    }

    function getSize() {

        return $_FILES['qqfile']['size'];
    }

}

class qqFileUploader {

    private $allowedExtensions = array();
    private $sizeLimit = 1024000;
    private $file;

    function __construct(array $allowedExtensions = array(), $sizeLimit = 1024000) {

        $allowedExtensions = array_map("strtolower", $allowedExtensions);



        $this->allowedExtensions = $allowedExtensions;

        $this->sizeLimit = $sizeLimit;



        $this->checkServerSettings();



        if (isset($_GET['qqfile'])) {

            $this->file = new qqUploadedFileXhr();
        } elseif (isset($_FILES['qqfile'])) {

            $this->file = new qqUploadedFileForm();
        } else {

            $this->file = false;
        }
    }

    private function checkServerSettings() {

        $postSize = $this->toBytes(ini_get('post_max_size'));

        $uploadSize = $this->toBytes(ini_get('upload_max_filesize'));



        if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit) {

            $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';

            die("{'error':'El tamaño máximo de carga es de $size'}");
        }
    }

    private function toBytes($str) {

        $val = trim($str);

        $last = strtolower($str[strlen($str) - 1]);

        switch ($last) {

            case 'g': $val *= 1024;

            case 'm': $val *= 1024;

            case 'k': $val *= 1024;
        }

        return $val;
    }

    /**

     * Returns array('success'=>true) or array('error'=>'error message')

     */
    function _ckdir($fn) {

        if (strpos($fn, "/") !== false) {

            $p = substr($fn, 0, strrpos($fn, "/"));

            if (!is_dir($p)) {

                _o("Mkdir: " . $p);

                mkdir($p, 777, true);
            }
        }
    }

    function img_resizer($src, $quality, $w, $h, $saveas, $cropImage) {

        /* v2.5 with auto crop */

        $r = 1;

        $e = strtolower(substr($src, strrpos($src, ".") + 1, 3));

        if (($e == "jpg") || ($e == "jpeg")) {

            $OldImage = ImageCreateFromJpeg($src) or $r = 0;
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

            if ($cropImage == 'cropImage') {

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

            $this->_ckdir($saveas);

            ImageJpeg($NewThumb, $saveas, $quality);

            ImageDestroy($NewThumb);

            ImageDestroy($OldImage);
        }

        return $r;
    }

    function handleUpload($uploadDirectory, $replaceOldFile = TRUE) {

        global $_GET;

        if (!is_writable($uploadDirectory)) {

            return array('error' => "Error del servidor. No se pudo escribir." . $uploadDirectory);
        }



        if (!$this->file) {

            return array('error' => 'No se cargo el archivo.');
        }



        $size = $this->file->getSize();



        if ($size == 0) {

            return array('error' => 'El archivo no se encuentra');
        }



        if ($size > $this->sizeLimit) {

            return array('error' => 'El archivo es muy grande');
        }

        $pathinfo = pathinfo($this->file->getName());

        //$filename = $pathinfo['filename'];

        $filename = $_GET['SessionURLSection'];


        $ext = strtolower($pathinfo['extension']);



        if ($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)) {

            $these = implode(', ', $this->allowedExtensions);

            return array('error' => 'El tipo de archivo no es válido, cargue uno de estos tipos ' . $these . '.');
        }



        if (!$replaceOldFile) {

            /// don't overwrite previous files that were uploaded

            while (file_exists($uploadDirectory . $filename . '.' . $ext)) {

                $filename .= rand(10, 99);
            }
        }
        if ($this->file->save($uploadDirectory . $filename . '.' . $ext)) {

            $uploadfile1 = $uploadDirectory . $filename . '.' . $ext;

            $uploadfile2 = $uploadDirectory . $_GET['SessionURLSection'] . '.' . $ext;

            if ($ext == 'jpg') {

                //$this->img_resizer($uploadfile1,85,$ThumbnailProductX,$ThumbnailProductY,$uploadfile2, 'NOcropImage');
            }

            return array('success' => true, 'filename' => $filename . '.' . $ext);
        } else {

            return array('error' => 'No se pudo cargar el archivo.' .
                'La carga fue cancelada, O se encontró un error');
        }
    }

}

// list of valid extensions, ex. array("jpeg", "xml", "bmp")

$allowedExtensions = $ExtensionsCV;

// max file size in bytes

$sizeLimit = 1 * 1024 * 1024;



$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);

$result = $uploader->handleUpload($HandleUploadDir);

// to pass data through iframe you will need to encode all html tags

echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);

