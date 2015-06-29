<?php
if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    $SKTAJAX = 'AJAX';
    require ('../../../Config.php');
    require ('../../../db.php');
    require ('../../Core.php');
    $SKTDB = \CmsDev\sql\db_Skt::connect();
}
?>

<select name="CustomProperty" id="CustomProperty" class="text ui-corner-all" >
    <?php
    $ID = 0;
    $CC = 0;
    if (isset($_GET['ID']) && $_GET['ID'] != '') {
        $ID = $_GET['ID'];
    } else if (isset($_POST['ID']) && $_POST['ID'] != '') {
        $ID = $_POST['ID'];
    } else {
        $ID = $CC;
    }
    if ($SKT_Controls = $SKTDB->get_row("SELECT CustomProperty FROM " . DB_PREFIX . "content WHERE ID = '$ID'")) {
        $CC = $SKT_Controls->CustomProperty;
    }
    /* ------------------------------------------------------------------------------------------------- */
    /* ------------------------------    FROM TEMPLATE     --------------------------------------------- */

    $URLTemplate = '_TemplateSite/' . $TemplateSite . '/SKT_Theme_Parts/';
    $SKTDBTemplate = $LOC . '_TemplateSite/' . $TemplateSite . '/SKT_Theme_Parts/';
    if (file_exists($SKTDBTemplate)) {
        echo '<option value="" disabled="disabled" class="ui-widget-header">From Template: ' . $TemplateSite . '</option>';
        $directorio = $SKTDBTemplate;

        if (file_exists($directorio)) {
            $handle = opendir($directorio);
            while ($file = readdir($handle)) {
                if (!is_dir($file) && $file != ".." && $file != "."
                ) {
                    $Selected = '';
                    $thisCC = $CC;
                    if ($thisCC == $URLTemplate . $file) {
                        $Selected = 'selected="selected"';
                    }
                    $ControlType = '';
                    $find = strstr($file, 'Note_');
                    if ($find == true) {
                        $ControlType = 'Note';
                        $fileName = str_replace('Note_', '', $file);
                        $fileName = str_replace('_', ' ', $fileName);
                        $fileName = str_replace('.tpl', '', $fileName);
                        echo '<option class="' . $ControlType . '" ' . $Selected . ' value="' . $URLTemplate . $file . '">' . $fileName . '</option>';
                    }
                }
            }
            closedir($handle);
        }
    }
    /* ------------------------------------------------------------------------------------------------- */
    /* ------------------------------    FROM DEFAULT  ------------------------------------------------- */

    $URLTemplate = '_TemplateSite/default/SKT_Theme_Parts/';
    $SKTDBTemplate = $LOC . '_TemplateSite/default/SKT_Theme_Parts/';
    if (file_exists($SKTDBTemplate)) {
        echo '<option value="" disabled="disabled" class="ui-widget-header">From Template: Default</option>';
        $directorio = $SKTDBTemplate;

        if (file_exists($directorio)) {
            $handle = opendir($directorio);
            while ($file = readdir($handle)) {
                if (!is_dir($file) && $file != ".." && $file != "."
                ) {
                    $Selected = '';
                    $thisCC = $CC;
                    if ($thisCC == $URLTemplate . $file) {
                        $Selected = 'selected="selected"';
                    }
                    $ControlType = '';
                    $find = strstr($file, 'Note_');
                    if ($find == true) {
                        $ControlType = 'Note';
                        $fileName = str_replace('Note_', '', $file);
                        $fileName = str_replace('_', ' ', $fileName);
                        $fileName = str_replace('.tpl', '', $fileName);
                        echo '<option class="' . $ControlType . '" ' . $Selected . ' value="' . $URLTemplate . $file . '">' . $fileName . '</option>';
                    }
                }
            }
            closedir($handle);
        }
    }
    ?>
</select>