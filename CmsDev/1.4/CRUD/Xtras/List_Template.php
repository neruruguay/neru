<?php

namespace CmsDev\CRUD\Xtras;

class List_Template {

    public static function set($templateSelect = null) {
        if ($templateSelect !== null) {
            $SelectBefore = '<select name="Template"  class="text ui-corner-all">';
            $SelectAfter = '</select>';
            $selectT = 0;
            $directorio = \LOCAL_DIR . \SKTURL_TemplateSite . '/SKT_Theme_Pages/';
            $FileList = array();
            if (\file_exists($directorio)) {
                $handle = \opendir($directorio);
                $nfiles = 0;
                while ($file = \readdir($handle)) {
                    $extension = \explode(".", $file);
                    $num = count($extension) - 1;
                    /*TODO - Revisar lista de exclusion*/
                    if (!\is_dir($file) && $file !== ".." && $file != "." && $file !== "tmp" && $file !== "_notes" && $file !== "_error_log" && $file !== "EditorLayouts.php" && $file !== "Job_Offer.php" && $file !== "Send_html.php" && $file !== "Send_smtp.php" && $num === 1
                    ) {
                        if ($extension[$num] == "php") {
                            $T = \str_replace('.' . $extension[$num], '', $file);
                            $T = \str_replace('inc_template_', '', $T);
                            if ($T == $templateSelect) {
                                $selectT = 1;
                            }
                            $FileList[] = $T . '|' . $selectT;
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
                        $select = '';
                        if ($valSel == 1) {
                            $select = 'selected="selected"';
                        }
                        $List .= '<option value="' . $valName . '" ' . $select . '>' . $valName . '</option>';
                    }
                }
                return $SelectBefore . $List . $SelectAfter;
                \closedir($handle);
            } else {
                return 'El directorio "' . $directorio . '" No existe!';
            }
        }
    }

}

?>