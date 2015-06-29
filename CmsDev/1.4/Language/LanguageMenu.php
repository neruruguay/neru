<?php

/**
 * Description of Language
 *
 * @author Martín Daguerre
 */

namespace CmsDev\Language;

use CmsDev\sql as SKT_DB;

class LanguageMenu {

    private $Nav_Sub_Items_Before = '<div class="dropdown LanguageMenu"><button class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown"><i class="skt-icon-language"></i></button><span class="dropdown-arrow"></span><ul class="dropdown-menu  dropdown-inverse">';
    private $Nav_Sub_Items_After = '</ul></div>';
    private $item_model = '<li class="[Prefix]"><a href="[URL]" title="[LanguageName]">[LanguageName]</a></li>';
    private $levels = 1;
    private $Nav_Class_Item_Selected = 'current';
    private $query;
    private $counter;
    private $Language = 'esp';

    public function connect($query, $counter) {
        $this->query = $query;
        $this->counter = $counter;
    }

    public function set_Language($Language) {
        $this->Language = $Language;
    }

    public function set_Wrap_Template($Nav_Sub_Items_Before, $Nav_Sub_Items_After) {
        $this->Nav_Sub_Items_Before = $Nav_Sub_Items_Before;
        $this->Nav_Sub_Items_After = $Nav_Sub_Items_After;
    }

    public function set_Item_Template($item_model) {
        $this->item_model = $item_model;
    }

    public function set_levels($levels) {
        $this->levels = $levels;
    }

    public function Nav_Class_Item_Selected($Nav_Class_Item_Selected) {
        $this->Nav_Class_Item_Selected = $Nav_Class_Item_Selected;
    }

    public function RenderLanguageMenu() {
        echo $this->Render();
    }

    private function Render() {

        $SKTDB = SKT_DB\db_Skt::connect();

        $Language = \THIS_LANG;
        $query = $SKTDB->get_results("SELECT ID,LanguageName,Prefix,URL,SID,Hidden FROM language WHERE Hidden='0' ORDER BY LanguageName ASC");
        $counter = $SKTDB->get_var("SELECT count(ID) FROM language");

        self::connect($query, $counter);
        self::set_Language($Language);

        if ($this->counter > 1) {
            $Render = $this->Nav_Sub_Items_Before;
            foreach ($this->query as $Item) {
                if ($this->Language == $Item->Prefix) {
                    $active = ' class="' . $this->Nav_Class_Item_Selected . '"';
                } else {
                    $active = '';
                }
                $preitem = $this->item_model;
                $item = str_replace('[LanguageName]', $Item->LanguageName, $preitem);
                $item = str_replace('[URL]', SKT_URL_BASE . $Item->Prefix . '/', $item);
                $item = str_replace('[Prefix]', $Item->Prefix, $item);
                $item = str_replace('[activeLang]', $active, $item);
                if ($Item->Hidden == 0) {
                    $Render .= $item;
                }
            }
            $Render .= $this->Nav_Sub_Items_After;
        }
        return $Render;
    }

}

?>