<?php

/**
 * Description of EditorLayoutsThumb
 *
 * @author Martin
 */
class EditorLayoutsThumb {

    private static $instance;

    public static function get() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private static function LayoutList($directory, $return_link, $extensions = '') {
        $code = '';
        if (substr($directory, -1) == "/")
            $directory = substr($directory, 0, strlen($directory) - 1);
        $code .= static::LayoutList_dir($directory, $return_link, $extensions);
        return $code;
    }

    private static function LayoutList_dir($directory, $return_link, $extensions = '', $first_call = true) {
        $LayoutList = '';
        $file = scandir($directory);
        if (!empty($extensions)) {
            foreach (array_keys($file) as $key) {
                if (!is_dir("$directory/$file[$key]")) {
                    $ext = substr($file[$key], strrpos($file[$key], ".") + 1);
                    if ($ext != $extensions)
                        unset($file[$key]);
                }
            }
        }
        if (count($file) > 2) {
            $LayoutList = '';
            if ($first_call) {
                $LayoutList .= '';
                $first_call = false;
            }
            $LayoutList .= '';
            $i = 0;
            foreach ($file as $this_file) {
                if ($this_file != "." && $this_file != "..") {
                    if (!is_dir("$directory/$this_file")) {
                        $ext = substr($this_file, strrpos($this_file, ".") + 1);
                        if ($ext == 'png') {
                            $title = str_replace('.' . $ext, '', $this_file);
                            $title = str_replace('_', ' ', $title);
                            $LayoutList .= '<div class="IconLayoutObj" style="background: transparent url(' . $return_link . $this_file . ') scroll no-repeat center center; width:50px; height:50px; display:block; float:left; position:relative; margin:0, padding:0; z-index:' . $i . '" title="' . $title . '"></div>';
                        }
                        $i++;
                    }
                }
            }
        }
        return $LayoutList;
    }

    function __construct() {
        $HTML = '<div id="sktLayoutsObj">' . static::LayoutList(\LOCAL_DIR . \SKTURL_TemplateSite . '/SKT_Editor_Parts/', \SKTURL_TemplateSite . '/SKT_Editor_Parts/', 'png') . '</div>';
        \define('EditorLayoutsThumb', \LOCAL_DIR . \SKTURL_TemplateSite . '/SKT_Editor_Parts/');
    }

}

?>
