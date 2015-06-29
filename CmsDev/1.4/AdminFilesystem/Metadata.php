<?php

/**
 * System of metadata file 
 *
 * @author Martín Daguerre
 */

namespace CmsDev\AdminFilesystem;

use \CmsDev\skt_Code as Code;
use \CmsDev\AdminFilesystem\FolderRecoveryFiles as DirFolder;

class Metadata {

    private static $File;
    private static $Title = '';
    private static $Description = '';
    private static $Hiperlink = '';
    private static $CustomData = '';
    private static $FileOrder = 0;

    public static function File_Order($File = false) {
        if (!$File) {
            $File = self::$File;
        }
        return self::data($File, 'FileOrder');
    }

    public static function File_Title($File = false) {
        if (!$File) {
            $File = self::$File;
        }
        return self::data($File, 'Title');
    }

    public static function File_Description($File = false) {
        if (!$File) {
            $File = self::$File;
        }
        return self::data($File, 'Description');
    }

    public static function File_Hiperlink($File = false) {
        if (!$File) {
            $File = self::$File;
        }
        return self::data($File, 'Hiperlink');
    }

    public static function File_CustomData($File = false) {
        if (!$File) {
            $File = self::$File;
        }
        return self::data($File, 'CustomData');
    }

    private static function DefineTags() {
        if (self::FileExist() && self::FileTagExist()) {
            $Metadata = file_get_contents(self::$File . '.tag');
            $Exp = explode("|", $Metadata);
            self::$FileOrder = $Exp[0];
            $Data = Code::Decode($Exp[1]);
            $Attr = explode("|", $Data);
            $num = count($Attr);
            self::$Title = $Attr[0];
            self::$Description = $Attr[1];
            self::$Hiperlink = $Attr[2];
            self::$CustomData = $Attr[3];
        } else {
            self::Create();
        }
    }

    public static function File($File) {
        self::$Title = '';
        self::$Description = '';
        self::$Hiperlink = '';
        self::$CustomData = '';
        self::$FileOrder = '';
        $CodeFile = Code::Decode($File);
        if (file_exists($CodeFile)) {
            self::$File = $CodeFile;
        } else {
            try {
                if (file_exists($File)) {
                    self::$File = $File;
                }
            } catch (Exception $ex) {
                self::$File = 'dummy.jpg';
            }
        }
    }

    public static function FileExist() {
        if (file_exists(self::$File)) {
            return true;
        } else {
            return false;
        }
    }

    public static function FileTagExist() {
        if (file_exists(self::$File . '.tag')) {
            return true;
        } else {
            return false;
        }
    }

    private static function FilesInFolder() {
        $total = 0;
        $files = array();
        $Folder = explode(DIRECTORY_SEPARATOR, self::$File);
        $FolderC = count($Folder) - 1;
        self::$FileOrder = $FolderC;
        $Folder = str_replace($Folder[$FolderC], '', self::$File);
        if (is_dir($Folder)) {
            $dh = opendir($Folder);
            while (false !== ($name = readdir($dh))) {
                $ext = strtolower(substr($name, strrpos($name, ".") + 1, 3));
                if ($ext != 'tag' && $ext != '') {
                    $files[] = $name;
                }
            }
            $total = count($files);
        }
        return (int) $total + self::$FileOrder;
    }

    private static function Create() {
        if (self::FileExist()) {
            $Title = $Description = $Hiperlink = $CustomData = '';
            new Counter();
            $Counter = Counter::$counter;
            $FileOrder = self::FilesInFolder() + $Counter;
            $handle = fopen(self::$File . '.tag', "x+");
            $add = $Title . "|" . $Description . "|" . $Hiperlink . "|" . $CustomData;
            $Data = $FileOrder . "|" . Code::Encode($add);
            fwrite($handle, $Data);
            fclose($handle);
            self::FileTagExist();
            self::DefineTags();
        }
    }

    private static function TagExistOrCreate() {
        if (file_exists(self::$File . '.tag')) {
            return true;
        } else {
            self::Create();
        }
    }

    public static function data($File = 'dummy.jpg', $Require = 'Title', $label = false, $ClassCSS = 'sktToolTip', $target = '_blank') {
        self::File($File);
        self::TagExistOrCreate();
        self::DefineTags();
        if ($Require == 'Title') {
            return Code::Charset(self::$Title);
        }
        if ($Require == 'Description') {
            return Code::Charset(self::$Description);
        }
        if ($Require == 'Hiperlink') {
            if ($label == true) {
                $Hiperlink = '<a href="' . Code::Charset(self::$Hiperlink) . '" class="' . $ClassCSS . '" target="' . $target . '" Title="' . Code::Charset(self::$Title) . '" >' . Code::Charset(self::$Hiperlink) . '</a>';
                return $Hiperlink;
            } else {
                return Code::Charset(self::$Hiperlink);
            }
        }
        if ($Require == 'FileOrder') {
            return (int) self::$FileOrder;
        }
        if ($Require == 'CustomData') {
            return Code::Charset(self::$CustomData);
        }
        if ($Require == 'kb') {
            if (self::FileExist()) {
                $kb = filesize(self::$File) / 1024;
                $kb = (int) $kb;
                return '<span class="file-kb"><b>' . $kb . ' kb</b></span>';
            }
        }
    }

}

class Counter{

    public static $counter = 1;

    function __construct() {
        self::$counter++;
    }
//
//    public function Reset() {
//        self::$counter = 1;
//    }

}
