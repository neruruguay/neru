<?php

/**
 * Description of Themes_Note
 *
 * @author Martin Daguerre
 */

namespace CmsDev\CRUD\Xtras;

class Themes_Note {

    public static function ThemeList($ThemeSelected = null) {
        $SelectBefore = '<select name="CustomProperty" id="CustomProperty">';
        $SelectAfter = '</select>';
        $selectT = 0;
        $directorio = \LOCAL_DIR . \SKTURL_TemplateSite . '/SKT_Theme_Parts/Notes/';
        $FileList = array();
        if (\file_exists($directorio)) {
            $handle = \opendir($directorio);
            $nfiles = 0;
            while ($file = \readdir($handle)) {
                $extension = \explode(".", $file);
                $num = count($extension) - 1;
                if (!\is_dir($file) && $file !== ".." && $file != "." && $file !== "tmp" && $file !== "_notes" && $file !== "_error_log" && $num === 1) {
                    if ($extension[$num] == "tpl") {
                        $valName = \str_replace('.' . $extension[$num], '', $file);
                        $valName = \str_replace('Note_', '', $valName);
                        $valName = \str_replace('_', ' ', $valName);
                        if ($valName == $ThemeSelected) {
                            $selectT = 1;
                        }
                        $FileList[] = $valName . '|' . $selectT . '|' . $file;
                        $selectT = "";
                    }
                }$nfiles++;
            }
            $List = '';
            if (\is_array($FileList)) {
                \natcasesort($FileList);
                foreach ($FileList as $key => $val) {
                    $valGruop = \explode('|', $val);
                    $valName = $valGruop[0];
                    $valSel = $valGruop[1];
                    $FileNane = $valGruop[2];
                    $select = '';
                    if ($valSel == 1) {
                        $select = 'selected="selected"';
                    }
                    $List .= '<option value="' . $FileNane . '" ' . $select . '>' . $valName . '</option>';
                }
            }
            return $SelectBefore . $List . $SelectAfter;
            \closedir($handle);
        } else {
            return 'El directorio "' . $directorio . '" No existe!';
        }
    }

}

?>
