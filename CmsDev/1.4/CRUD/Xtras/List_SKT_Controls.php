<?php

namespace CmsDev\CRUD\Xtras;

class List_SKT_Controls {

    private static $instancia;

    public static function get() {
        if (!self::$instancia instanceof self) {
            self::$instancia = new self;
        }
        return self::$instancia;
    }

    public function Render($ID = 0) {
        $CC = '';
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        if ($SKT_Controls = $SKTDB->get_row("SELECT Custom FROM " . \DB_PREFIX . "content WHERE ID = '$ID'")) {
            $CC = $SKT_Controls->Custom;
        }
        $SelectedIni = '';
        $Select = '<select name="Custom" id="Custom" class="text ui-corner-all" >';

        /* ------------------------------------------------------------------------------------------------- */
        /* ------------------------------    FROM TEMPLATE     --------------------------------------------- */

        $SKTDBTemplate = \LOCAL_DIR . \SKTURL_TemplateSite . '/SKT_Controls/';
        if (file_exists($SKTDBTemplate)) {
            $Select.= '<option value="" disabled="disabled" class="ui-widget-header">From Template</option>';
            $directorio = $SKTDBTemplate;

            if (file_exists($directorio)) {
                $handle = opendir($directorio);
                while ($file = readdir($handle)) {
                    if (!is_dir($file) && $file != ".." && $file != "." && $file != "CustomPropertyURI_for_Files.php"
                    ) {
                        $Selected = '';
                        $thisCC = $CC;
                        if ($thisCC != 0 || $thisCC != '') {
                            if ($thisCC == $file) {
                                $Selected = 'selected="selected"';
                            } else {
                                $Selected = '';
                            }
                        }
                        $ControlType = '';
                        $find = strstr($file, 'File_');
                        if ($find == true) {
                            $ControlType = 'TypeFiles';
                        }
                        $find2 = strstr($file, 'Folder_');
                        if ($find2 == true) {
                            $ControlType = 'TypeFolder';
                        }
                        $find3 = strstr($file, 'Customized_');
                        if ($find3 == true) {
                            $ControlType = 'Customized';
                        }

                        $fileName = str_replace('File', '', $file);
                        $fileName = str_replace('Folder', '', $fileName);
                        $fileName = str_replace('Customized', '', $fileName);
                        $fileName = str_replace('_', ' ', $fileName);
                        $Select.= '<option class="' . $ControlType . '" ' . $Selected . ' title="' . \SKTURL_TemplateSite . '/SKT_Controls/" value="' . $file . '">' . $fileName . '</option>';
                    }
                }
                closedir($handle);
            }
        }
        /* ------------------------------------------------------------------------------------------------- */
        /* ------------------------------    FROM ROOT     ------------------------------------------------- */
        $directorio = \LOCAL_DIR . 'CmsDev/Modules/';

        if (file_exists($directorio)) {
            $Select.= '<option value="" disabled="disabled" class="ui-widget-header">General</option>';
            $handle = opendir($directorio);
            while ($file = readdir($handle)) {
                if (!is_dir($file) && $file != ".." && $file != "." && $file != "CustomPropertyURI_for_Files.php"
                ) {
                    $Selected = '';
                    $thisCC = $CC;
                    if ($thisCC != 0 || $thisCC != '') {
                        if ($thisCC == $file) {
                            $Selected = 'selected="selected"';
                        } else {
                            $Selected = '';
                        }
                    }
                    $ControlType = '';
                    $find = strstr($file, 'File_');
                    if ($find == true) {
                        $ControlType = 'TypeFiles';
                    }
                    $find2 = strstr($file, 'Folder_');
                    if ($find2 == true) {
                        $ControlType = 'TypeFolder';
                    }
                    $find3 = strstr($file, 'Customized_');
                    if ($find3 == true) {
                        $ControlType = 'Customized';
                    }
                    $fileName = str_replace('File_', '', $file);
                    $fileName = str_replace('Folder_', '', $file);
                    $fileName = str_replace('Customized', '', $file);
                    $fileName = str_replace('_', ' ', $fileName);
                    $Select.= '<option class="' . $ControlType . '" ' . $Selected . ' title="" value="' . $file . '">' . $fileName . '</option>';
                }
            }
            closedir($handle);
        }
        $Select.= '</select>';
        return $Select;
    }

}

?>