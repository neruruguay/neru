<?php

/**
 * Description of List_Files 
 *
 * @author Martin Daguerre
 */

namespace CmsDev\AdminFilesystem;

use \CmsDev\AdminFilesystem\FileDataRecovery as FileDataRecovery;
use \CmsDev\skt_Code as Code;

class List_Files {

    public static function Directory($directory = '/', $return_link, $extensions = array()) {
        $code = '';
        if (substr($directory, -1) == "/")
            $directory = substr($directory, 0, strlen($directory) - 1);
        $code .= self::Resources($directory, $return_link, $extensions);
        return $code;
    }

    private static function DirFix($dir) {
        $replace = array(\LOCAL_DIR, '_FileSystems', \URL_VERSION . 'AdminFilesystem', '_FileSystems', 'AdminFilesystem');
        $for = array('', '', '', '');
        $return = str_replace($replace, $for, $dir);
        return $return;
    }

    private static function _ckdir($fn) {
        if (strpos($fn, "/") !== false) {
            $p = substr($fn, 0, strrpos($fn, "/"));
            if (!is_dir($p)) {
                _o("Mkdir: " . $p);
                mkdir($p, 777, true);
            }
        }
    }

    private static function img_resizer($src, $quality, $w, $h, $saveas) {
        /* v2.5 with auto crop */
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
            ImageDestroy($NewThumb);
            ImageDestroy($OldImage);
        }
        return $r;
    }

    private static function file_info($file, $Require = 'kb') {

        $info = \getimagesize($file);
        $i = '';
        if ($Require == 'HV') {
            if ($info[0] > $info[1]) {
                $i = '<span class="image-h" title="' . \SKT_ADMIN_FileSystems_ImageH . '"></span>';
            } else if ($info[0] < $info[1]) {
                $i = '<span class="image-v" title="' . \SKT_ADMIN_FileSystems_ImageV . '"></span>';
            } else {
                $i = '<span class="image-x" title="' . \SKT_ADMIN_FileSystems_ImageX . '"></span>';
            }
        }
        if ($Require == 'size') {
            $i = '<span class="image-size"><b>' . $info[0] . ' x ' . $info[1] . '</b></span>';
        }
        if ($Require == 'kb') {
            $kb = \filesize($file) / 1024;
            $kb = (int) $kb;
            $i = '<span class="file-kb">' . $kb . ' kb</span>';
        }
        if ($Require == 'tags') {
            $i = '<span class="file-tags" rel="' . Code::Encode($file) . '" title="' . \SKT_ADMIN_FileSystems_Meta_ModalTitle . '"><i class="skt-icon-tags"></i></span>';
        }
        if ($Require == 'Title') {
            $DataTag = new \CmsDev\AdminFilesystem\Metadata();
            $i = $DataTag->data($file, 'Title');
        }
        return $i;
    }

    private static function file_deleteBtn($file) {
        $i = '<span class="file-delete" title="' . \SKT_ADMIN_Btn_Delete . '" rel="' . Code::Encode($file) . '"><i class="skt-icon-close"></i></i></span>';
        return $i;
    }

    private static function folder_deleteBtn($folder, $namefolder) {
        global $FileSystemsDirName;
        global $subfolder;
        $i = '';
        if ($namefolder != 'Banners' &&
                $namefolder != '' &&
                $namefolder != 'Contenidos' &&
                $namefolder != 'icons') {
            $i = '<span class="folder-delete" title="' . \SKT_ADMIN_Btn_Delete . '" rel="' . Code::Encode($folder) . '"></span>';
            return $i;
        }
    }

    private static function Resources($directory = '/', $return_link, $extensions = array(), $first_call = true) {
        $PopUp_System = '';
        if (\is_dir($directory)) {
            $file = \scandir($directory);
            \natcasesort($file);
            $files = $dirs = $ListaFiles = array();
            foreach ($file as $this_file) {
                if (is_dir("$directory/$this_file")) {
                    $dirs[] = self::DirFix($this_file);
                } else {
                    $files[] = self::DirFix($this_file);
                }
            }
            $file = array_merge($dirs, $files);

            if (!empty($extensions)) {
                foreach (\array_keys($file) as $key) {
                    if (!\is_dir("$directory/$file[$key]")) {
                        $ext = \substr($file[$key], strrpos($file[$key], ".") + 1);
                        if (!\in_array($ext, $extensions)) {
                            unset($file[$key]);
                        }
                    }
                }
            }
            if (count($file) > 0) {
                $ProtectedDirectory = array('Audios', 'Banners', 'Documentos', 'Documents', 'Video', 'esp', 'eng', 'por', 'bra', 'ita', 'Products', 'Productos', 'icons', 'images', 'svn', 'git');
                $PopUp_System = "<ul";
                if ($first_call) {
                    $PopUp_System .= " class=\"PopUp_System\"";
                    $first_call = false;
                }
                $PopUp_System .= ">";
                $num = 900;
                $SKTURL_FileSystems = str_replace('_FileSystems/', '', \SKTURL_FileSystems);
                foreach ($file as $this_file) {
                    if ($this_file != "." && $this_file != "..") {
                        if (\is_dir("$directory/$this_file")) {
                            // Directory

                            if (\in_array($this_file, $ProtectedDirectory)) {
                                $Options = '<div class="OptionsNav"></div>';
                            } else {
                                $Options = '<div class="OptionsNav">
                                            <ul>
                                                <li class="RenameFolder"><span rel="' . Code::Encode($directory . '/' . $this_file) . '" title="Renombrar Carpeta \'' . $this_file . '\'" class="folder-rename"><i class="skt-icon-rewrite"></i></span></li>
                                                <li class="DeleteFolder"><span rel="' . $directory . '/' . $this_file . '" title="Borrar Carpeta \'' . $this_file . '\'" class="folder-delete"><i class="skt-icon-close"></i></span></li>
                                            </ul>
                                        </div>';
                            }

                            $ListaFiles[$this_file] = '
                        <li><a href="' . \SKT_URL_BASE . 'SKTFiles/' . Code::Encode($directory . '/' . \urlencode($this_file)) . '/">
                        <div class="divpnglist"><i class="skt-icon-folder"></i><img class="hidden" src="' . \SKTURL_assets . 'img/icons/dir.png" alt="' . self::DirFix(Code::RemoveLocalFS($this_file)) . '" /></div>
			<div class="Dirname">' . self::DirFix(Code::RemoveLocalFS(\str_replace('_', ' ', $this_file))) . '</div><div class="tip"></div></a>' . $Options . '</li>';
                            $Options = '';
                            //RECURSIVO
                            //$PopUp_System .= self::Directory("$directory/$this_file", $return_link ,$extensions, false);
                        } else {
                            // File
                            $ext = \substr($this_file, strrpos($this_file, ".") + 1);
                            $F = new FileDataRecovery();
                            $F->File("$directory/$this_file");

                            $File_Order = \CmsDev\AdminFilesystem\Metadata::File_Order("$directory/$this_file");

                            $click = \str_replace("[this]", self::DirFix(Code::Encode("$directory/" . \urlencode($this_file))), $return_link);
                            $click = \str_replace("[name]", self::DirFix($this_file), $click);
                            $click = \str_replace("[w]", $F->size('w', false), $click);
                            $click = \str_replace("[h]", $F->size('h', false), $click);
                            $click = \str_replace("/_FileSystems", '_FileSystems', $click);
                            $click = \str_replace(\URL_VERSION . "AdminFiles", '_FileSystems', $click);
                            $trumb = \str_replace('../../', '', \htmlspecialchars($directory . "/" . $this_file));
                            $trumbAlt = \str_replace('../../', '', \htmlspecialchars($this_file));
                            $bbase = \basename($_SERVER['SCRIPT_FILENAME']);
                            $typeOfFile = $ViewImage = '';
                            /*
                             * IMAGENES
                             */
                            if ($ext == 'png' || $ext == 'gif' || $ext == 'jpg') {
                                $ViewImage = "<li class=\"View\"><a href=\"" . $SKTURL_FileSystems . "SKTSize/" . self::DirFix($trumb) . "\" rel=\"prettyPhoto[mixed]\" title=\"View: " . $trumbAlt ."\"><i class=\"skt-icon-expand\"></i></a></li>";
                                $typeOfFile = $F->size('w', false) . " x " . $F->size('h', false). ' - Orden:'.$File_Order;
                                $IMG = '<div class="divpnglist"><img src="' . $SKTURL_FileSystems . 'SKTSize/' . self::DirFix($trumb) . '|120x120" alt="' . $trumbAlt . '" /><div class="Dirname">' . str_replace('_', ' ', self::DirFix($this_file)) . '' . self::file_info("$directory/$this_file", 'kb') . $typeOfFile . '</div></div>';
                                $Tips = '<div class="tip"></div>';
                                /*
                                 * OTROS ARCHIVOS
                                 */
                            } else {
                                $icon = $ext;
                                $URLDownload = \SERVER_DIR . '/' . $SKTURL_FileSystems . '_FileSystems/' . self::DirFix($trumb);
                                $ViewImage = "<li class=\"Download\"><a href=\"" . $URLDownload . "\" class=\"Ver\" title=\"Descargar\"><i class=\"skt-icon-download-cloud\"></i></a></li>";
                                $typeOfFile = "<br />" . $F->kb('kb', true);
                                $IMG = '<div class="divpnglist"><i class="skt-icon-' . $icon . '" ></i><div class="Dirname">' . \str_replace('_', ' ', self::DirFix($this_file)) . '' . self::file_info("$directory/$this_file", 'kb') . '</div></div>';
                                $Tips = '<div class="tip"></div>';
                            }
                            $FileOrder = $F->DataTag('FileOrder');
                            $ListaFiles[$FileOrder] = '
                    <li class="animate8 fileItem" rel="' . Code::Encode(Code::RemoveLocalFS($trumb)) . '" id="listItem_' . Code::Encode(self::DirFix($trumbAlt)) . '">
                        <div class="skt-icon-move"></div>
                        <a href="' . $click . '" class="atooltip" title="' . self::DirFix($trumbAlt) . '" >' . $IMG . '' . $Tips . '</a>
                        <div class="OptionsNav">
                            <ul>
                                <li class="RenameFile"><span class="Rename-file" rel="' . Code::Encode($directory . '/' . $this_file) . '" title="Renombrar Archivo \'' . $this_file . '\'" >
                                    <i class="skt-icon-rewrite"></i></span></li>
                                ' . $ViewImage . '
                                <li class="Tags">' . self::file_info("$directory/$this_file", 'tags') . '</li>
                                <li class="Delete">' . self::file_deleteBtn("$directory/$this_file") . '</li>
                                <li class="Move"><i class="skt-icon-move"></i></li>
                            </ul>
                        </div>
                    </li>';
                        }
                    }
                }
            }
            $ListaFilesR = '';
            if (\count($ListaFiles) > 0) {
                \krsort($ListaFiles);
                foreach (\array_reverse($ListaFiles) as $key => $val) {
                    $ListaFilesR.=$val;
                }
                $PopUp_SystemEnd = "</ul>";
                return $PopUp_System . $ListaFilesR . $PopUp_SystemEnd;
            } else {
                echo '<h3 style="talign:center; padding:35px;">No se encontraron archivos en esta carpeta</h3>';
            }
        } else {
            //umask(0000);
            //echo '*************** NO EXISTE ******************'.$directory.'************************* NO EXISTE *************';
            //mkdir($directory . "", 0777);
            //$file = scandir($directory);
        }
    }

}

?>
