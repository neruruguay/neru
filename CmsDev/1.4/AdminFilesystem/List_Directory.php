<?php

/**
 * Description of List_Directory
 *
 * @author Martin Daguerre
 */

namespace CmsDev\AdminFilesystem;

use \CmsDev\AdminFilesystem\FileDataRecovery as FileDataRecovery;
use \CmsDev\skt_Code as Code;

class List_Directory {
    static $root = 0;
    public static function FolderSystemUL($directory, $return_link, $extensions = array('dir')) {
        $code = '';
        if (substr($directory, -1) == "/")
            $directory = substr($directory, 0, strlen($directory) - 1);
        $code .= self::FolderSystemUL_dir($directory, $return_link, $extensions);
        return $code;
    }

    private static function FolderSystemUL_dir($directory, $return_link, $extensions = array(), $first_call = true) {
        $LOC = \LOCAL_FILESYSTEM;
        $FolderSystemUL = '';
        $file = scandir($directory);
        natcasesort($file);
        $files = $dirs = array();
        foreach ($file as $this_file) {
            if (is_dir("$directory/$this_file"))
                $dirs[] = $this_file;
            else
                $files[] = $this_file;
        }
        $file = array_merge($dirs, $files);
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
            $FolderSystemUL .= '>';
            if (static::$root == 0) {
                $FolderSystemUL .= '<li class="pft-directory">
                <span class="skt-icon-folder iconfolder iconmore"></span>
                <a href="javascript:SKTFSys.ViewFolderList(\'/\');">
                    <span>Ra&iacute;z</span>
                </a>
            </li>';
                static::$root = 1;
            }
            foreach ($file as $this_file) {
                if ($this_file != "." && $this_file != ".." && $this_file != "icons") {
                    $F = new FileDataRecovery();
                    $FLocalFile = str_replace('../../', '/', $directory);
                    $FLocalFile = $LOC . $FLocalFile;
                    $FLocalFile = str_replace(\URL_VERSION . 'AdminFilesystem/', '', $FLocalFile);
                    $FLocalFile = $FLocalFile . '/' . $this_file;
                    $F->File($FLocalFile);
                    if (is_dir("$directory/$this_file")) {
                        // Directory
                        $link = str_replace("[link]", Code::Encode("$directory/" . $this_file), $return_link);
                        $link = str_replace("[this]", Code::Encode("$directory/" . $this_file), $link);
                        $FolderSystemUL .= "<li class=\"pft-directory\"><span class=\"skt-icon-folder iconfolder\"></span><a href=\"" . $link . "\"><span>" . htmlspecialchars($this_file) . "</span></a>";
                        $FolderSystemUL .= self::FolderSystemUL_dir("$directory/$this_file", $return_link, $extensions, false);
                        $FolderSystemUL .= "</li>";
                    } else {
                        // File
                        $typeFile = 'rel="no"';
                        $ext = "ext-" . substr($this_file, strrpos($this_file, ".") + 1);
                        if ($ext == 'ext-gif' || $ext == 'ext-jpg' || $ext == 'ext-jpeg' || $ext == 'ext-png') {
                            $typeFile = 'rel="image"';
                            $link = str_replace("[link]", Code::Encode("$directory/" . $this_file), $return_link);
                            $FolderSystemUL .= "<li class=\"pft-file " . \strtolower($ext) . "\"  " . $typeFile . " title=\"" . \str_replace('../../', '', $directory) . "/" . $this_file . "\" rev=\"" . $F->kb('kb', false) . "\"><a href=\"" . $link . "\" ><span>" . \htmlspecialchars($this_file) . "" . $F->kb('kb') . "</span></a></li>";
                        } else {
                            $typeFile = 'rel="download"';
                            $link = str_replace("[link]", Code::Encode("$directory/" . $this_file), $return_link);
                            $FolderSystemUL .= "<li class=\"pft-file " . \strtolower($ext) . "\"  " . $typeFile . " title=\"" . \str_replace('../../', '', $directory) . "/" . $this_file . "\"  rev=\"" . $F->kb('kb', false) . "\"><a href=\"" . $link . "\"><span>" . \htmlspecialchars($this_file) . "" . $F->kb('kb') . "</span></a></li>";
                        }
                    }
                }
            }
            $FolderSystemUL .= "</ul>";
        }
        return $FolderSystemUL;
    }

}

?>
