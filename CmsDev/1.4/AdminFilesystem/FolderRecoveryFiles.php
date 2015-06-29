<?php

/* -----------------------------------------------------------------------------------------------------
  $ServerFolder 	= 'C:/xampp/htdocs/subSite/FileSystems/Imagenes/';
  $PublicURL 		= '/subSite/FileSystems/Imagenes/';
  $subSite		= 'subSite'; // Sub folder in site http://www.website.com/[subSite]
  $DirFolder 		= new FolderRecoveryFiles();
  $DirFolder->Folder($ServerFolder, $PublicURL, $subSite);
  if($DirFolder->exist()==true){
  echo $DirFolder->FilesInFolder(); // Total files
  echo $DirFolder->ListFolder().'<br />';
  }
  -----------------------------------------------------------------------------------------------------
 */
/**
 * Description of FolderRecoveryFiles
 *
 * @author Mart�n Dario Daguerre 2012
 */

namespace CmsDev\AdminFilesystem;

use \CmsDev\skt_Code as Code;
use \CmsDev\AdminFilesystem\Metadata as Metadata;

class FolderRecoveryFiles {

    private $FileList = array();
    private $extArray = array("jpg", "png", "gif", "pdf", "avi", "mpg", "ogg", "mpg", "swf", "flv", "doc", "docx", "rtf", "xml", "xls", "xlsx", "zip", "rar");
    private $subSite = '';
    private $List = '';
    private $View_Image = 1;
    private $View_video = 1;
    private $View_Download = 1;
    private $W = 75;
    private $H = 75;
    private $Q = 95;
    private $Wrap_Before;
    private $Trumbnail = false;
    private $Wrap_After;
    private $item_model_image = '<li>
		<a href="[PublicURL]" rel="prettyPhoto[mixed]" class="MDTooltip" title="[title]">
			<img src="[subSite]TrumbnailImage.php?src=[PublicURL]&w=[W]&h=[H]&q=[Q]" title="[title]" />
		</a>
	</li>';
    private $item_model_video = '<li>
		<a href="[subSite]_FileSystems/mediaplayer.swf?width=320&amp;height=240&amp;file=[PublicURL]" rel="prettyPhoto[video]" title="[title]">
			<img src="[subSite]FileSystems/icons/video.png" />
			<img class="videobtn" src="/[subSite]/_FileSystems/icons/videobtn.png" />
		</a>
	</li>';
    private $item_model_Download = '<li>
		<a href="[PublicURL]" rel="prettyPhoto[mixed]" class="MDTooltip" title="[title]">
			<img src="[subSite]TrumbnailImage.php?src=[PublicURL]&w=[W]&h=[H]&q=[Q]" title="[title]" />
		</a>
	</li>';

    private function fixURL($url) {
        $url1 = str_replace('_FileSystems//_FileSystems//', '_FileSystems/', $url);
        $url2 = str_replace('//', '/', $url1);
        $url3 = str_replace('_FileSystems/_FileSystems/', '_FileSystems/', $url2);
        return $url3;
    }

    public function Folder($Folder, $PublicURL, $subSite) {
        $this->Folder = $this->fixURL($Folder);
        $this->PublicURL = $this->fixURL($PublicURL);
        $this->subSite = $this->fixURL($subSite);
    }

    public function Exist() {
        if (file_exists($this->Folder)) {
            return true;
        }
    }

    static function randomID() {
        $randomID = rand(5, 100);
        return $randomID;
    }

    public function FilesInFolder() {
        $total = 0;
        $files = array();
        $dh = opendir($this->Folder);

        while (false !== ($name = readdir($dh))) {
            $ext = strtolower(substr($name, strrpos($name, ".") + 1, 3));
            if ($ext != 'tag' && $ext != '') {
                if (in_array($ext, $this->extArray)) {
                    $files[] = $name;
                }
            }
        }
        if (is_dir($this->Folder)) {
            $total = count($files);
        }
        return (int) $total;
    }

    public function set_Wrap_Template($Wrap_Before, $Wrap_After) {
        $this->Wrap_Before = $Wrap_Before;
        $this->Wrap_After = $Wrap_After;
    }

    public function Trumbnail($TrumbSet = false) {
        $this->Trumbnail = $TrumbSet;
    }

    public function TrumbnailImage($W = 75, $H = 75, $Q = 95) {
        $this->W = $W;
        $this->H = $H;
        $this->Q = $Q;
    }

    public function item_model_image($item_model_image) {
        $this->item_model_image = $item_model_image;
    }

    public function item_model_video($item_model_video) {
        $this->item_model_video = $item_model_video;
    }

    public function extArray($extArray) {
        $this->extArray = $extArray;
    }

    public function item_model_Download($item_model_Download) {
        $this->item_model_Download = $item_model_Download;
    }

    public function View_image($View_image) {
        $this->View_image = $View_image;
    }

    public function View_video($View_video) {
        $this->View_video = $View_video;
    }

    public function View_Download($View_Download) {
        $this->View_Download = $View_Download;
    }

    private function kb($file, $u = 'kb', $label = true) {
        $kb = '';
        if ($u == 'bit' || $u == 'bits') {
            $kb = filesize($file);
        }
        if ($u == 'kb') {
            $kb = filesize($file) / 1024;
            $kb = (int) $kb;
        }
        if ($u == 'gb') {
            $kb = filesize($file) / 1024;
            $kb = $kb / 1024;
            $kb = round($kb * 100) / 100;
        }
        if ($label == true) {
            $kb = '<span class="file-kb"><b>' . $kb . ' ' . $u . '</b></span>';
        }
        return $kb;
    }

    private function size($file, $i = 'w', $px = true) {
        $size = '';
        $ext = $this->extension($file);
        if ($ext == 'jpg' || $ext == 'png' || $ext == 'gif' || $ext == 'bmp') {
            list($width, $height) = getimagesize($file);
            if ($i == 'w') {
                $size = $width;
            }
            if ($i == 'h') {
                $size = $height;
            }
        }
        if ($px == true) {
            $size .= 'px';
        }
        return $size;
    }

    // This private function check exist FileTAGS
    private function TagExist($file) {
        if (file_exists($file . '.tag')) {
            return true;
        }
    }

    // This private function check extension
    private function extension($file) {
        if (is_file($file)) {
            $ext = strtolower(substr($file, strrpos($file, ".") + 1, 3));
        } else {
            $ext = '';
        }
        return $ext;
    }

    // This private function return de 'TAGS'
    private function DataTag($file = '', $Require = 'title', $label = true, $ClassCSS = 'easyTooltip', $target = '_blank') {
        $DataTag = new \CmsDev\AdminFilesystem\Metadata();
        return $DataTag->data($file, $Require, $label, $ClassCSS, $target);
    }

    public function ListFolder($Require = 'title', $label = true, $ClassCSS = 'easyTooltip', $target = '_blank') {
        $Exist = $this->Exist();
        $View_Image = $this->View_Image;
        $View_video = $this->View_video;
        $View_Download = $this->View_Download;
        $randomID = $this->randomID();
        $FileList = '';
        $preitem = '';
        $item = '';
        if ($Exist == true && is_readable($this->Folder)) {
            $handle = opendir($this->Folder);
            while ($file = readdir($handle)) {
                $ext = $this->extension($this->Folder . $file);
                $FixName = str_replace('_', ' ', $file);
                $FixName = str_replace('-', ' ', $FixName);
                if (!is_dir($file) && $file != ".." && $file != "." && $file != "tmp" && $file != "icons" && $file != "_notes" && $ext != ""
                ) {
                    switch ($ext) {
                        case "gif": case "jpg": case "png":
                            $TypeInfo = "Imagen";
                            $option = 'ImageBox';
                            break;
                        case "tif": case "bmp":
                            $TypeInfo = "Imagen file";
                            $option = 'Download';
                            break;
                        case "doc": case "rtf": case "docx": case "dot":
                            $TypeInfo = "Microsoft Word";
                            $option = 'Download';
                            break;
                        case "html": case "htm":
                            $TypeInfo = "Documento Web";
                            $option = 'View Download';
                            break;
                        case "txt":
                            $TypeInfo = "Documento de Texto";
                            $option = 'View Download';
                            break;
                        case "php": case "asp":
                            $TypeInfo = "Documento Web ServerSide";
                            $option = 'No';
                            break;
                        case "mp3": case "wav":
                            $TypeInfo = "Archivo de Sonido";
                            $option = 'Download';
                            break;
                        case "zip":case "rar":
                            $TypeInfo = "Archivo Comprimido";
                            $option = 'Download';
                            break;
                        case "pps": case "ppt": case "ppp":
                            $TypeInfo = "Power Point";
                            $option = 'Download';
                            break;
                        case "pdf":
                            $TypeInfo = "Acrobat Reader";
                            $option = 'View Download';
                            break;
                        case "xls":
                            $TypeInfo = "MS Excel";
                            $option = 'Download';
                            break;
                        case "flv": case "mp4":
                            $TypeInfo = "Video de Flash";
                            $option = 'flv';
                            break;
                        case "swf":
                            $TypeInfo = "Archivo de Flash";
                            $option = 'View Download';
                            break;
                        default:
                            $TypeInfo = "Archivo para descargar";
                            $option = 'Download';
                            break;
                    }
                    /*
                      DataTag(
                      local_file_location,
                      Require	='title','Description','hiperlink','FileOrder',
                      label 	= true/false, (if 'Require' is 'hiperlink', wrap with HTML tag <a>)
                      ClassCSS= 'any',
                      target = '_blank','self','top','parent','_new' (if 'Require' is 'hiperlink')
                      )
                     */
                    if ($ext != 'php' && $ext != 'css' && $ext != 'js' && $ext != 'sql' && $ext != 'db' && $ext != 'tag' && $ext != '') {
                        if ($option == 'ImageBox') {
                            if ($View_Image == 1) {
                                $preitem = $this->item_model_image;
                                if ($this->Trumbnail == true) {
                                    $trumbURL = str_replace('_FileSystems','SKTSize',$this->fixURL($this->PublicURL . $file)).'|'.$this->W.'x'.$this->H;
                                    $item = str_replace('[PublicURL]', $trumbURL, $preitem);
                                } else {
                                    $item = str_replace('[PublicURL]', $this->fixURL($this->PublicURL . $file), $preitem);
                                }
                                
                            }
                        } else if ($option == 'flv') {
                            if ($View_video == 1) {
                                $preitem = $this->item_model_video;
                                $item = str_replace('[PublicURL]', $this->fixURL($this->PublicURL . $file), $preitem);
                            }
                        } else {
                            if ($View_Download == 1) {
                                $preitem = $this->item_model_Download;
                                $item = str_replace('[PublicURL]', $this->fixURL($this->PublicURL . $file), $preitem);
                            }
                        }
                        $item = str_replace('[subSite]', $this->subSite, $item);
                        $item = str_replace('[URL]', $this->Folder . $file, $item);
                        $item = str_replace('[FixName]', $FixName, $item);
                        $item = str_replace('[FixNameOutExt]', str_replace('.' . $ext, '', $FixName), $item);
                        $item = str_replace('[NameOutExt]', str_replace('.' . $ext, '', $file), $item);
                        $item = str_replace('[title]', $this->DataTag($this->Folder . $file, 'title'), $item);
                        $item = str_replace('[hiperlink-label]', $this->DataTag($this->Folder . $file, 'hiperlink', true), $item);
                        $item = str_replace('[hiperlink]', $this->DataTag($this->Folder . $file, 'hiperlink', false), $item);
                        $item = str_replace('[Description]', $this->DataTag($this->Folder . $file, 'Description'), $item);
                        $item = str_replace('[FileOrder]', $this->DataTag($this->Folder . $file, 'FileOrder'), $item);
                        $item = str_replace('[bit-label]', $this->kb($this->Folder . $file, 'bit', true), $item);
                        $item = str_replace('[kb-label]', $this->kb($this->Folder . $file, 'kb', true), $item);
                        $item = str_replace('[gb-label]', $this->kb($this->Folder . $file, 'gb', true), $item);
                        $item = str_replace('[bit]', $this->kb($this->Folder . $file, 'bit', false), $item);
                        $item = str_replace('[kb]', $this->kb($this->Folder . $file, 'kb', false), $item);
                        $item = str_replace('[gb]', $this->kb($this->Folder . $file, 'gb', false), $item);
                        $item = str_replace('[ext]', $ext, $item);
                        $item = str_replace('[URL]', $this->Folder . $file, $item);
                        $item = str_replace('[W]', $this->W, $item);
                        $item = str_replace('[H]', $this->H, $item);
                        $item = str_replace('[Q]', $this->Q, $item);
                        $item = str_replace('[randomID]', $randomID, $item);
                        if (is_file($this->Folder . $file) && !is_dir($this->Folder . $file)) {
                            if ($ext) {
                                if (in_array($ext, $this->extArray)) {
                                    $FileList[$this->DataTag($this->Folder . $file, 'FileOrder')] = $item;
                                }
                            }
                        }
                    }
                }
            }
        }
        $List = '';
        closedir($handle);
        if (is_array($FileList)) {
            krsort($FileList);
            foreach (array_reverse($FileList) as $key => $val) {
                $List .= $val;
            }
        }
        return $List;
    }

}
