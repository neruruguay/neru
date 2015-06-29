<?php

/*
  $file = 'C:/xampp/htdocs/subSite/FileSystems/Content/Imagenes/image.jpg';
  $F = new FileDataRecovery();
  $F->File($file);
  echo $F->exist().'<br />';
  echo $F->TagExist().'<br />';
  echo $F->kb('bits').'<br />';
  echo $F->extension().'<br />';
  echo $F->size('w').'<br />';
  echo $F->size('h').'<br />';
  echo $F->DataTag('Title').'<br />';
  echo $F->DataTag('Description').'<br />';
  echo $F->DataTag('Hiperlink').'<br />';
  echo $F->DataTag('FileOrder').'<br />';
  -----------------------------------------------------------------------------------------------------
  $file = 'C:/xampp/htdocs/subSite/FileSystems/Content/Videos/LogoVideo.flv';
  $F = new FileDataRecovery();
  $F->File($file);
  echo $F->exist().'<br />';
  echo $F->TagExist().'<br />';
  echo $F->kb('gb',true).'<br />';
  echo $F->extension().'<br />';
  echo $F->DataTag('Title').'<br />';
  echo $F->DataTag('Description').'<br />';
  echo $F->DataTag('Hiperlink').'<br />';
  echo $F->DataTag('FileOrder').'<br />';
 */

/**
 * Description of FileDataRecovery
 *
 * @author Martin
 */

namespace CmsDev\AdminFilesystem;

use \CmsDev\skt_Code as Code;
use \CmsDev\AdminFilesystem\Metadata as Metadata;

class FileDataRecovery {

    public function File($File) {
        $this->File = $File;
    }

    public function exist() {
        if (file_exists($this->File)) {
            return true;
        }
    }

    public function TagExist() {
        if (file_exists($this->File . '.tag')) {
            return true;
        }
    }

    public function extension() {
        $ext = '';
        $exist = $this->exist();
        if ($exist == true) {
            $ext = strtolower(substr($this->File, strrpos($this->File, ".") + 1, 3));
        }
        return $ext;
    }

    public function FilesInFolder() {
        $bbase = basename($this->File);
        $ThisFolder = str_replace($bbase, "", $this->File);
        $dh = opendir($ThisFolder);
        while (false !== ($name = readdir($dh))) {
            $files[] = $name;
        }
        $total = count($files) / 2;
        return (int) $total;
    }

    public function kb($u = 'kb', $label = true) {
        $kb = '';
        $exist = $this->exist();
        if ($exist == true) {
            if ($u == 'bit' || $u == 'bits') {
                $kb = filesize($this->File);
            }
            if ($u == 'kb') {
                $kbr = filesize($this->File) / 1024;
                $kb = (int) $kbr;
            }
            if ($u == 'gb') {
                $kbr = filesize($this->File) / 1024;
                $kbs = $kbr / 1024;
                $kb = round($kbs * 100) / 100;
            }
        }
        if ($label == true) {
            $kb = '<span class="file-kb"><b>' . $kb . ' ' . $u . '</b></span>';
        }
        return $kb;
    }

    public function size($i = 'w', $px = true) {
        $size = '';
        $ext = $this->extension();
        $exist = $this->exist();
        if ($exist == true) {
            if ($ext == 'jpg' || $ext == 'png' || $ext == 'gif' || $ext == 'bmp') {
                list($width, $height) = getimagesize($this->File);
                if ($i == 'w') {
                    $size = $width;
                }
                if ($i == 'h') {
                    $size = $height;
                }
            }
        }
        if ($px == true) {
            $size .= 'px';
        }
        return $size;
    }

    public function DataTag($Require = 'Title', $label = true, $ClassCSS = 'sktToolTip', $target = '_blank') {
        $DataTag = new \CmsDev\AdminFilesystem\Metadata();
        return $DataTag->data($this->File, $Require, $label, $ClassCSS, $target);
    }

}

function dataExt($ext, $require) {
    switch ($ext) {
        case "gif": case "jpg": case "png":
            $TypeInfo = "Imagen";
            $option = 'ImageBox';
            $pretty = '';
            $prettyRel = '';
            break;
        case "tif": case "bmp":
            $TypeInfo = "Imagen file";
            $option = 'Download';
            $pretty = '';
            $prettyRel = '';
            break;
        case "doc": case "rtf": case "docx":
            $TypeInfo = "Microsoft Word";
            $option = 'Download';
            $pretty = '';
            $prettyRel = '';
            break;
        case "html": case "htm":
            $TypeInfo = "Documento Web";
            $option = 'View Download';
            $pretty = '';
            $prettyRel = '';
            break;
        case "txt":
            $TypeInfo = "Documento de Texto";
            $option = 'View Download';
            $pretty = '';
            $prettyRel = '';
            break;
        case "php": case "asp":
            $TypeInfo = "Documento Web ServerSide";
            $option = 'No';
            $pretty = '';
            $prettyRel = '';
            break;
        case "mp3": case "wav":
            $TypeInfo = "Archivo de Sonido";
            $option = 'Download';
            $pretty = '';
            $prettyRel = '';
            break;
        case "zip":case "rar":
            $TypeInfo = "Archivo Comprimido";
            $option = 'Download';
            $pretty = '';
            $prettyRel = '';
            break;
        case "pps": case "ppt": case "ppp": case "ppsx": case "pptx": case "pppx":
            $TypeInfo = "Power Point";
            $option = 'Download';
            $pretty = '';
            $prettyRel = '';
            break;
        case "pdf":
            $TypeInfo = "Acrobat Reader";
            $option = 'View Download';
            $pretty = '?iframe=true&width=90%&amp;height=90%';
            $prettyRel = 'rel="FSprettyPhoto[iframe]"';
            break;
        case "xls":
            $TypeInfo = "MS Excel";
            $option = 'Download';
            $pretty = '';
            $prettyRel = '';
            break;
        case "flv":
            $TypeInfo = "Video de Flash";
            $option = 'View Download';
            $pretty = '_FileSystems/mediaplayer.swf?width=320&amp;height=240&amp;file=';
            $prettyRel = 'rel="FSprettyPhoto[iframe]"';
            break;
        case "mov":
            $TypeInfo = "Video QuickTime";
            $option = 'View Download';
            $pretty = '?width=320&amp;height=240';
            $prettyRel = 'rel="FSprettyPhoto[movies]"';
            break;
        case "swf":
            $TypeInfo = "Archivo de Flash";
            $option = 'View Download';
            $pretty = '?width=90%&amp;height=90%';
            $prettyRel = 'rel="FSprettyPhoto[flash]"';
            break;
        default:
            $TypeInfo = "Archivo para descargar";
            $option = 'Download';
            $pretty = '';
            $prettyRel = '';
            break;
    }
    if ($require == 'TypeInfo') {
        return $TypeInfo;
    }
    if ($require == 'option') {
        return $option;
    }
    if ($require == 'pretty') {
        return $pretty;
    }
    if ($require == 'prettyRel') {
        return $prettyRel;
    }
}

?>
