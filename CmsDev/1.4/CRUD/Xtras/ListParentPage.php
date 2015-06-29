<?php

namespace CmsDev\CRUD\Xtras;

class ListParentPage {

    private $HTML = '';
    private $L = 1;

    public function set($IDPage) {
        $this->HTML = '<select name="IDPage" id="IDPage">';
        $this->HTML .= self::root($IDPage);
        $this->HTML .= '</select>';
        return $this->HTML;
    }

    private function root($IDPage) {

        $SKTDB = \CmsDev\sql\db_Skt::connect();
        $Menu = $SKTDB->get_results("SELECT ID,Title,URLName,SID,Language FROM " . \DB_PREFIX . "sections WHERE SID = 0 ORDER BY Position ASC");
        if ($Menu) {
            foreach ($Menu as $Section) {
                if ($Section->ID === $IDPage) {
                    $selected = ' selected="selected"';
                } else {
                    $selected = '';
                }
                $this->HTML .= '<option value="' . $Section->ID . '" ' . $selected . ' class="L1">[' . $Section->Language . '] > ' . utf8_encode($Section->URLName) . '</option>';
                $TestSub = $SKTDB->get_var("SELECT count(*) FROM " . \DB_PREFIX . "sections WHERE SID = '" . $Section->ID . "'");
                if ($TestSub != 0) {
                    $this->HTML .= self::level($IDPage, $Section->ID);
                }
            }
        }
    }

    private function level($IDPage, $SID) {
        $SKTDB = \CmsDev\sql\db_Skt::connect();
        $Menu = $SKTDB->get_results("SELECT ID,Title,URLName,SID,Language FROM " . \DB_PREFIX . "sections WHERE SID = '" . $SID . "' ORDER BY Position ASC");
        if ($Menu) {
            $this->L++;
            foreach ($Menu as $Section) {
                if ($Section->ID === $IDPage) {
                    $selected = ' selected="selected"';
                } else {
                    $selected = '';
                }
                $this->HTML .= '<option value="' . $Section->ID . '" ' . $selected . ' class="L' . $this->L . '">&nbsp;&nbsp;&nbsp;&nbsp;' . utf8_encode($Section->URLName) . '</option>';
                if ($SKTDB->get_var("SELECT count(*) FROM " . DB_PREFIX . "sections WHERE SID = '" . $Section->ID . "'") > 0) {
                    $this->HTML .= self::level($IDPage, $Section->ID);
                }
            }
            $this->L = $this->L - 1;
        }
    }

}

?>