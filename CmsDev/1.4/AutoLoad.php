<?php

/**
 * Description of Autoloader
 *
 * @author Martín Daguerre
 */
class Autoloader {

    public function __construct() {
        
    }

    public static function autoload($file) {
        $ds = DIRECTORY_SEPARATOR;
        $path = __DIR__;
        $fileFind = array('\CmsDev', 'CmsDev\\');
        $fileFix = str_replace($fileFind, '', $file);

        $Template = strstr($file, '_TemplateSite');
        if ($Template !== false) {

            global $SKT;
            $fileFix = str_replace('CmsDev\\' . \SKT_VERSION . '\\', '', $file);
            $path = str_replace('CmsDev\\' . \SKT_VERSION . '', '', $path);
            $file = strtr($fileFix, '\\', $ds);
            $filepath = "{$path}{$ds}{$file}.php";
            if (file_exists($filepath)) {
                require_once($filepath);
            } else {
                echo 'La class: ' . $file . ' no se encuentra en ' . $filepath;
                //Autoloader::recursive_autoload($file, $path);
            }
        } else {
            $file = strtr($fileFix, '\\', $ds);
            $filepath = "{$path}{$ds}{$file}.php";
            if (file_exists($filepath)) {
                require_once($filepath);
            } else {
                echo 'La class: ' . $file . ' no se encuentra en ' . $filepath;
                //Autoloader::recursive_autoload($file, $path);
            }
        }
    }

// try to load recursively the specified file

    public static function recursive_autoload($file, $path) {
        if (FALSE !== ($handle = opendir($path))) {
// search recursively the specified file
            while (FAlSE !== ($dir = readdir($handle))) {
                if (strpos($dir, '.') === FALSE) {
                    $path .= '/' . $dir;
                    $filepath = $path . '/' . $file . '.php';
                    if (file_exists($filepath)) {
                        require_once($filepath);
                        break;
                    }
                    Autoloader::recursive_autoload($file, $path);
                }
            }
            closedir($handle);
        }
    }

}
