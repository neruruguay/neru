<?php

/**
 * Description of List_AllPage
 *
 * @author Martín Daguerre
 */

namespace CmsDev\CRUD\Xtras;

class List_ThisOrAll_Page {

    public static function ThisOrAll($ThisPage = 0) {
        $Sel = array();
        $Sel[0] = '';
        $Sel[1] = 'selected="selected"';
        if ($ThisPage !== 1) {
            $Sel[0] = 'selected="selected"';
            $Sel[1] = '';
        }
        $HTML = '<select name="AllPage">';
        $HTML .= '<option value="0" ' . $Sel[0] . '>' . \SKT_ADMIN_TXT_View_AllPages0 . '</option>';
        $HTML .= '<option value="1" ' . $Sel[1] . '>' . \SKT_ADMIN_TXT_View_AllPages1 . '</option>';
        $HTML .= '</select>';
        return $HTML;
    }

}

?>