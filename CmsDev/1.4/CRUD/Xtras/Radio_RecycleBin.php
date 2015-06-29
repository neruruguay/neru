<?php

/**
 * Description of Radio_Recycle
 *
 * @author Martin Daguerre
 */

namespace CmsDev\CRUD\Xtras;

class Radio_RecycleBin {

    public static function OptionGroup($RecycleBin = 0, $type = 0) {
        $Sel = array();
        $Sel[0] = '';
        $Sel[1] = 'checked="checked"';
        if ($RecycleBin === '0') {
            $Sel[0] = 'checked="checked"';
            $Sel[1] = '';
        }
        if ($type === 0) {
            $legend = \SKT_ADMIN_RecycleTitle;
        } else {
            $legend = \SKT_ADMIN_TXT_Section_RecycleBin;
        }
        $HTML = '<fieldset>';
        $HTML .= '<legend>' . $legend . '</legend>';
        $HTML .= '<label class="sktContentInline"><span>' . \SKT_ADMIN_TXT_Section_Show . '</span>';
        $HTML .= '<input type="radio" name="RecycleBin" ' . $Sel[0] . ' value="0" id="RecycleBin_0" />';
        $HTML .= '</label>';
        $HTML .= '<label class="sktContentInline"><span>' . \SKT_ADMIN_TXT_Section_Hiden . '</span>';
        $HTML .= '<input type="radio" name="RecycleBin" ' . $Sel[1] . ' value="1" id="RecycleBin_1" />';
        $HTML .= '</label>';
        $HTML .= '</fieldset>';
        return $HTML;
    }

}

?>
