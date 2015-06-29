<?php

namespace CmsDev\CRUD\Xtras;

class List_Position_Section {

    public function set($PositionSelect = null, $SID = null) {
        if ($PositionSelect !== null && $SID !== null) {
            $randomID = 'Position' . \md5(\rand(1000, 99999));
            $SID = \GetSQLValueString($SID, 'int');
            $SKTDB = \CmsDev\Sql\db_Skt::connect();
            $total = $SKTDB->get_var("SELECT count(*) FROM " . \DB_PREFIX . "sections WHERE Language = '" . \THIS_LANG . "' AND SID = '$SID'");
            if (!isset($PositionSelect) or $PositionSelect == null) {
                $PositionSelect = 0;
            } elseif ($PositionSelect === 'max') {
                $PositionSelect = $total + 1;
            }
            $this->HTML .= '<input name="Position" id="' . $randomID . '" type="text" value="' . $PositionSelect . '" />';
            $this->HTML .= '<script type="text/javascript">';
            $this->HTML .= '$("#' . $randomID . '").spinner({step: 1,numberFormat: "n", min: 0, max: ' . ($total + 1) . '});';
            //$this->HTML .= 'alert("$total =' . $total . ' y $SID =' . $SID . ' y $PositionSelect =' . $PositionSelect . '");';
            $this->HTML .= '</script>';
            return $this->HTML;
        }
    }

}

?>