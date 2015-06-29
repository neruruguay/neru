<?php
if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    $SKTAJAX = 'AJAX';
    require ('../../../Config.php');
    require ('../../../db.php');
    require ('../Core.php');
    $SKTDB = \CmsDev\sql\db_Skt::connect();
}

function FolderSystemUL($directory, $return_link, $extensions = array()) {

    // Generates a valid XHTML list of all directories, sub-directories, and files in $directory
    // Remove trailing slash

    $code = '';

    if (substr($directory, -1) == "/")
        $directory = substr($directory, 0, strlen($directory) - 1);

    $code .= FolderSystemUL_dir($directory, $return_link, $extensions);

    return $code;
}

function FolderSystemUL_dir($directory, $return_link, $extensions = array(), $first_call = true) {


    $LOC = \LOCAL_FILESYSTEM;
    


    // Recursive function called by FolderSystemUL() to list directories/files

    $FolderSystemUL = '';

    // Get and sort directories/files

    if (function_exists("scandir"))
        $file = scandir($directory); else
        $file = php4_scandir($directory);

    natcasesort($file);

    // Make directories first

    $files = $dirs = array();

    foreach ($file as $this_file) {

        if (is_dir("$directory/$this_file"))
            $dirs[] = $this_file; else
            $files[] = $this_file;
    }

    $file = array_merge($dirs, $files);



    // Filter unwanted extensions

    if (!empty($extensions)) {

        foreach (array_keys($file) as $key) {

            if (!is_dir("$directory/$file[$key]")) {

                $ext = substr($file[$key], strrpos($file[$key], ".") + 1);

                if (!in_array($ext, $extensions))
                    unset($file[$key]);
            }
        }
    }



    if (count($file) > 2) { // Use 2 instead of 0 to account for . and .. "directories"
        $FolderSystemUL = "<ul";

        if ($first_call) {
            $FolderSystemUL .= " class=\"FolderSystemUL\"";
            $first_call = false;
        }

        $FolderSystemUL .= ">";

        foreach ($file as $this_file) {

            if ($this_file != "." && $this_file != ".." && $this_file != "icons" && $this_file != "productos" && $this_file != "images") {



                $F = new \CmsDev\AdminFilesystem\FileDataRecovery();

                $FLocalFile = str_replace('../../', '/', $directory);

                $FLocalFile = $LOC . $FLocalFile;

                $FLocalFile = str_replace('AdminFiles/', '', $FLocalFile);

                $FLocalFile = $FLocalFile . '/' . $this_file;

                //G:/xampp/htdocs/sekitocmsDemoV4/_Sekito_FileSystems/esp/ejemplo.ppt

                $F->File($FLocalFile);



                if (is_dir("$directory/$this_file")) {

                    // Directory
                    if ($this_file != "productos" && $this_file != "images") {
                        $FolderSystemUL .= "<li class=\"pft-directory\"><span class=\"iconfolder\"></span><a href=\"javascript:void(0);\"><span>" . htmlspecialchars($this_file) . "</span></a>";

                        $FolderSystemUL .= FolderSystemUL_dir("$directory/$this_file", $return_link, $extensions, false);

                        $FolderSystemUL .= "</li>";
                    }
                } else {

                    // File

                    $typeFile = 'rel="no"';

                    $ext = "ext-" . substr($this_file, strrpos($this_file, ".") + 1);

                    if ($ext == 'ext-gif' || $ext == 'ext-jpg' || $ext == 'ext-jpeg' || $ext == 'ext-png') {

                        $typeFile = 'rel="image"';

                        $link = str_replace("[link]", "$directory/" . urlencode($this_file), $return_link);



                        $FolderSystemUL .= "<li class=\"pft-file " . strtolower($ext) . "\"  " . $typeFile . " title=\"" . str_replace('../../', '', $directory) . "/" . $this_file . "\" rev=\"" . $F->kb('kb', false) . "\"><a href=\"javascript:void(0)\" ><span>" . htmlspecialchars($this_file) . "" . $F->kb('kb') . "</span></a></li>";
                    } else {

                        $typeFile = 'rel="download"';

                        $link = str_replace("[link]", "$directory/" . urlencode($this_file), $return_link);



                        $FolderSystemUL .= "<li class=\"pft-file " . strtolower($ext) . "\"  " . $typeFile . " title=\"" . str_replace('../../', '', $directory) . "/" . $this_file . "\"  rev=\"" . $F->kb('kb', false) . "\"><a href=\"javascript:void(0)\" ><span>" . htmlspecialchars($this_file) . "" . $F->kb('kb') . "</span></a></li>";
                    }
                }
            }
        }

        $FolderSystemUL .= "</ul>";
    }

    return $FolderSystemUL;
}

// For PHP4 compatibility

function php4_scandir($dir) {

    $dh = opendir($dir);

    while (false !== ($filename = readdir($dh))) {

        $files[] = $filename;
    }

    sort($files);

    return($files);
}

$allowed = $SKT['allowedExtentions'];

echo FolderSystemUL('../../../_FileSystems/', "", $allowed);

?>