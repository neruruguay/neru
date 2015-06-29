<?php

function utf8_fopen_read($fileName) {
    $fc = iconv('windows-1250', 'utf-8', file_get_contents($fileName));
    $handle = fopen("php://memory", "r");
    fwrite($handle, $fc);
    fseek($handle, 0);
    return($handle);
}

function LayoutList() {
    $directory = \SKTPATH_TemplateSite . '/SKT_Editor_Parts/';
    $extensions = 'tpl';
    $code = '';
    if (substr($directory, -1) == "/")
        $directory = substr($directory, 0, strlen($directory) - 1);
    $code .= LayoutList_dir($directory, $extensions);
    return $code;
}

function LayoutList_dir($directory, $extensions = '', $first_call = true) {
    // Recursive function called by LayoutList() to list directories/files
    $LayoutList = '';
    // Get and sort directories/files
    if (function_exists("scandir"))
        $file = scandir($directory);
    else
        $file = php4_scandir($directory);
    natcasesort($file);
    // Make directories first
    $files = $dirs = array();
    foreach ($file as $this_file) {
        if (is_dir("$directory/$this_file"))
            $dirs[] = $this_file;
        else
            $files[] = $this_file;
    }
    $file = array_merge($dirs, $files);
    // Filter unwanted extensions
    if (!empty($extensions)) {
        foreach (array_keys($file) as $key) {
            if (!is_dir("$directory/$file[$key]")) {
                $ext = substr($file[$key], strrpos($file[$key], ".") + 1);
                if ($ext != $extensions)
                    unset($file[$key]);
            }
        }
    }
    if (count($file) > 2) { // Use 2 instead of 0 to account for . and .. "directories"
        if ($first_call) {
            $LayoutList .= '';
            $first_call = false;
        }
        $LayoutList .= '';
        foreach ($file as $this_file) {
            if ($this_file != "." && $this_file != "..") {
                if (!is_dir("$directory/$this_file")) {
                    $ext = substr($this_file, strrpos($this_file, ".") + 1);
                    if ($ext == 'tpl') {
                        $data = file_get_contents("$directory/$this_file");
                        $LayoutList .= '<div class="bloque"><div class="LayoutBox">' . $data . '</div></div>';
                    }
                }
            }
        }
    }
    return $LayoutList;
    $LayoutList = '';
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
?>
<div id="sktLayoutsObj" style="display:none">
    <?php
    echo \LayoutList();
    ?>
</div>

