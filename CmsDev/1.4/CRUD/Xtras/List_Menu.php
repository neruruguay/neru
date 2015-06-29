<?php

namespace CmsDev\CRUD\Xtras;

class List_Menu {

    private $HTML = '';
    private $ArrayCountOnMenu = 'var CountOnMenu = new Array(); ';

    public function set($DisplayOnMenuSel = 1, $Encode = 0) {

        $SKTDB = \CmsDev\sql\db_Skt::connect();
        $QueryDisplayOnMenu = $SKTDB->get_results("SELECT * FROM " . \DB_PREFIX . "menu");
        $this->HTML = '<select name="DisplayOnMenu">';
        foreach ($QueryDisplayOnMenu as $DisplayOnMenu) {
            $theName = $DisplayOnMenu->Name;
            if ($Encode !== 0) {
                $theName = $theName;
            }
            if ($DisplayOnMenuSel == $DisplayOnMenu->ID) {
                $this->HTML .= '<option value="' . $DisplayOnMenu->ID . '" selected="selected">' . \CmsDev\skt_Code::Charset($theName) . '</option>';
            } else {
                $this->HTML .= '<option value="' . $DisplayOnMenu->ID . '">' . \CmsDev\skt_Code::Charset($theName) . '</option>';
            }
            $CountTotalOnMenu = $SKTDB->get_var("SELECT  count(*) FROM " . \DB_PREFIX . "sections WHERE DisplayOnMenu = '" . $DisplayOnMenu->ID . "' AND SID = '" . \SKT_SECTION_ID . "' AND Language = '" . \THIS_LANG . "'");
            $this->ArrayCountOnMenu .= 'CountOnMenu[' . $DisplayOnMenu->ID . '] = ' . $CountTotalOnMenu . ';';
        }
        $this->HTML .= '</select><script type="text/javascript">';
        $this->HTML .= $this->ArrayCountOnMenu;
        $this->HTML .= '</script>';
        return $this->HTML;
    }

}

?>