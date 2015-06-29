<?php

namespace CmsDev\CRUD\Xtras;

class List_Position_Zone {

    public static function set($PositionSelect = null, $IDPage = null, $Zone = 0) {
        if ($PositionSelect !== null && $IDPage !== null) {
            $rand = rand(2, 654);
            $Input = '<input name="Position" id="Position" class="Position' . $rand . ' form-control" type="text" value="[val]" />';
            $IDPage = \GetSQLValueString($IDPage, 'int');
            $Zone = \GetSQLValueString($Zone, 'int');
            $HTML = '';
            $SKTDB = \CmsDev\Sql\db_Skt::connect();
            $total = $SKTDB->get_var("SELECT count(*) FROM " . \DB_PREFIX . "content WHERE IDZone = '" . $Zone . "' AND IDPage = '$IDPage'");
            if (!isset($PositionSelect) or $PositionSelect == null) {
                $PositionSelect = 0;
            } elseif ($PositionSelect === -1) {
                $PositionSelect = $total + 1;
            }
            $HTML .= str_replace('[val]', $PositionSelect, $Input);
            $HTML .= '<script type="text/javascript">';
            $HTML .= '$(".Position' . $rand . '").spinner({step: 1,numberFormat: "n", min: 0, max: ' . ($total + 1) . '});';
            $HTML .= '</script>';
            return $HTML;
        }
    }

}

?>