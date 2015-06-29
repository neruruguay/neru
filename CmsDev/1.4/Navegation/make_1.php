<?php

/**
 * Description of Menu
 *
 * @author Martín Daguerre
 */

namespace CmsDev\Navegation;

class Menu {

    protected $SKTDB;
    protected $SectionValues = array();
    protected $Language = 'esp';
    protected $LoggedInAdmin = false;
    protected $subSite = '/';
    protected $html = '';
    protected $menu = array();
    protected $URLNameParent = '';
    protected $Sections_MenuClassHidden = 'sktRecycleBinHidden';
    protected $Class = 'nav';
    protected $Nav_Item_Before = '';
    protected $Nav_Item_After = '';
    protected $Nav_Class_Item_Selected = 'active';
    protected $PrefixURL = '/';
    protected $l1 = '';
    protected $l2 = '';
    protected $l3 = '';
    protected $l4 = '';
    protected $l5 = '';
    protected $Root = 0;
    protected $wp = 0;

    protected function PopUpMode($url = '', $w = '640', $h = '480', $title = '...') {
        $script = 'javascript:SKT.PopUp(\'' . $url . '\',\'_blank\',\'toolbar=no, location=no, directories=no, status=no, menubar=no, title=' . $title . ', width=' . $w . ',height=' . $h . '\');';
        if ($url != '') {
            return $script;
        }
    }

    protected function globalNav() {
        $this->URLNameParent = '';
        if (isset($this->menu['parents'][$this->ID])) {
            foreach ($this->menu['parents'][$this->ID] as $itemId) {
                $this->URLNameParent = '';
                if (!isset($this->menu['parents'][$itemId])) {
                    self::item($itemId, 1);
                } else {
                    $this->wp = 1;
                    $this->URLNameParent = '';
                    self::item($itemId, 2);
                    self::ParentItem($itemId);
                    $this->html .= $this->Sections_Menu['Nav_Sub_Items_Before'];
                    foreach ($this->menu['parents'][$itemId] as $itemId) {
                        if (!isset($this->menu['parents'][$itemId])) {
                            self::item($itemId, 3);
                            $this->URLNameParent = $this->URLNameParent .$this->menu['items'][$itemId]['URLName'] . '/';
                        } else {
                            $this->wp = 1;
                            self::item($itemId, 4);
                            $this->URLNameParent = $this->URLNameParent .$this->menu['items'][$itemId]['URLName'] . '/';
                            $this->html .= $this->Sections_Menu['Nav_Sub_Items_Before'];
                            foreach ($this->menu['parents'][$itemId] as $itemId) {
                                if (!isset($this->menu['parents'][$itemId])) {
                                    self::item($itemId, 5);
                                    $this->URLNameParent = $this->URLNameParent .$this->menu['items'][$itemId]['URLName'] . '/';
                                } else {
                                    $this->wp = 1;
                                    self::item($itemId, 6);
                                    $this->URLNameParent = $this->URLNameParent .$this->menu['items'][$itemId]['URLName'] . '/';
                                    $this->html .= $this->Sections_Menu['Nav_Sub_Items_Before'];
                                    foreach ($this->menu['parents'][$itemId] as $itemId) {
                                        if (!isset($this->menu['parents'][$itemId])) {
                                            self::item($itemId, 7);
                                        } else {
                                            $this->wp = 1;
                                            self::ParentItem($itemId);
                                            self::item($itemId, 8);
                                            $this->html .= $this->Sections_Menu['Nav_Sub_Items_Before'];
                                            foreach ($this->menu['parents'][$itemId] as $itemId) {
                                                if (!isset($this->menu['parents'][$itemId])) {
                                                    self::item($itemId, 9);
                                                } else {
                                                    $this->wp = 1;
                                                    self::item($itemId, 10);
                                                    $this->html .= $this->Sections_Menu['Nav_Sub_Items_Before'];
                                                    foreach ($this->menu['parents'][$itemId] as $itemId) {
                                                        self::ParentItem($itemId);
                                                        self::item($itemId, 11);
                                                    }
                                                    $this->html .= $this->Sections_Menu['Nav_Sub_Items_After'];
                                                    $this->html .= $this->Sections_Menu['Nav_Item_After'];
                                                    $this->URLNameParent = '';
                                                }
                                            }
                                            $this->html .= $this->Sections_Menu['Nav_Sub_Items_After'];
                                            $this->html .= $this->Sections_Menu['Nav_Item_After'];
                                            $this->URLNameParent = '';
                                        }
                                    }
                                    $this->html .= $this->Sections_Menu['Nav_Sub_Items_After'];
                                    $this->html .= $this->Sections_Menu['Nav_Item_After'];
                                    $this->URLNameParent = '';
                                }
                            }
                            $this->html .= $this->Sections_Menu['Nav_Sub_Items_After'];
                            $this->html .= $this->Sections_Menu['Nav_Item_After'];
                            $this->URLNameParent = '';
                        }
                    }
                    $this->html .= $this->Sections_Menu['Nav_Sub_Items_After'];
                    $this->html .= $this->Sections_Menu['Nav_Item_After'];
                    $this->URLNameParent = '';
                }
            }
        }
        return \CmsDev\skt_Code::Charset($this->html);
    }

    protected function active($ThisID) {
        if ($ThisID == \SKT_SECTION_ID) {
            $active = $this->Sections_Menu['Nav_Class_Item_Selected'];
        } else {
            $active = '';
        }
        return $active;
    }

    protected function ParentItem($itemId) {
        if ($this->URLNameParent == $this->menu['items'][$itemId]['URLName']
                || $this->URLNameParent == $this->menu['items'][$itemId]['URLName'] . '/') {
            $this->URLNameParent = '';
        } else {
            $this->URLNameParent = $this->menu['items'][$itemId]['URLName'] . '/';
        }
    }

    protected function item($itemId, $level = 0) {
        $active = self::active($this->menu['items'][$itemId]['ID']);
        $Thisitem = $this->Sections_Menu['Nav_Item_Before'];
        $level = ''; //['.$level . ']';
        if ($this->menu['items'][$itemId]['Link_ID'] != '') {
            $linkValues = $this->SKTDB->get_row("SELECT * FROM " . \DB_PREFIX . "links WHERE ID = '" . $this->menu['items'][$itemId]['Link_ID'] . "'");
            if ($this->menu['items'][$itemId]['RecycleBin'] == 1) {
                $Thisitem = str_replace('[sktRecycleBinHidden]', $Sections_MenuClassHidden, $Thisitem);
            } else {
                $Thisitem = str_replace('[sktRecycleBinHidden]', '', $Thisitem);
            }
            if ($this->LoggedInAdmin == true) {
                $Thisitem = str_replace('</a>', '</a><a href="javascript:AppSKT.sktViewLinkItem(\'' . $this->PrefixURL . $this->URLNameParent . $this->menu['items'][$itemId]['URLName'] . '\',\'' . $this->menu['items'][$itemId]['Link_ID'] . '\');" class="sktViewLinkItem"><i class="skt-icon-edit"></i></a>', $Thisitem);
            }
            if ($linkValues) {
                $Thisitem = str_replace('[Name]', $level . $linkValues->LinkTitle, $Thisitem);

                if ($this->menu['items'][$itemId]['LinkActive'] == 1) {
                    if ($linkValues->LinkType == 'popup') {
                        $Thisitem = str_replace('[URL]', self::PopUpMode($linkValues->Link, $linkValues->W, $linkValues->H, $linkValues->LinkTitle), $Thisitem);
                    }
                    $Thisitem = str_replace('[URL]', $this->PrefixURL . $this->URLNameParent . $linkValues->Link , $Thisitem);
                    $Thisitem = str_replace('_self', $linkValues->Target, $Thisitem);
                } else {
                    $Thisitem = str_replace('[URL]', 'javascript:void(0);', $Thisitem);
                    $Thisitem = str_replace('class="', 'class="CursorDefault', $Thisitem);
                }
                $Thisitem = str_replace('[Nav_Class_Item_Selected]', $linkValues->css_class . ' ' . $active, $Thisitem);
            } else {
                $Thisitem = '';
            }
        } else {
            if ($this->menu['items'][$itemId]['RecycleBin'] == 1) {
                $Thisitem = str_replace('[sktRecycleBinHidden]', 'sktRecycleBinHidden', $Thisitem);
            } else {
                $Thisitem = str_replace('[sktRecycleBinHidden]', '', $Thisitem);
            }
            $Thisitem = str_replace('[Name]', $level . $this->menu['items'][$itemId]['Title'], $Thisitem);
            if ($this->menu['items'][$itemId]['LinkActive'] == 1) {
                $Thisitem = str_replace('[URL]', $this->PrefixURL . $this->URLNameParent . $this->menu['items'][$itemId]['URLName'] , $Thisitem);
            } else {
                $Thisitem = str_replace('[URL]', 'javascript:void(0);', $Thisitem);
                $Thisitem = str_replace('class="', 'class="CursorDefault', $Thisitem);
            }
            $Thisitem = str_replace('[Nav_Class_Item_Selected]', $active, $Thisitem);
        }
        if ($this->wp = 0) {
            $this->html .= $Thisitem . $this->Sections_Menu['Nav_Item_After'];
        } else {
            $this->html .= $Thisitem;
        }
    }

}

class make extends \CmsDev\Navegation\Menu {

    public function nav($Sections_Menu, $ID = 1, $URLNameParent = '') {
        $this->ID = $ID;
        $this->URLNameParent = $URLNameParent;
        $this->Sections_Menu = $Sections_Menu;
        $ShowHidden = " RecycleBin = '0'  AND";
        $this->SKTDB = \CmsDev\Sql\db_Skt::connect();
        $this->SectionValues = \CmsDev\Content\Section::get();
        $this->Language = $this->SectionValues->Language;
        $this->LoggedInAdmin = \CmsDev\Security\loginIntent::action('validateAdmin');
        if ($this->LoggedInAdmin === true) {
            $ShowHidden = "";
        }
        $result = $this->SKTDB->get_results("SELECT *
            FROM " . \DB_PREFIX . "sections
            WHERE (" . $ShowHidden . " Language = '" . $this->Language . "' AND SectionType = '1' AND DisplayOnMenu = '" . $this->Sections_Menu['Nav_DisplayMenu'] . "') 
               OR (" . $ShowHidden . " Language = '" . $this->Language . "' AND SectionType = '1' AND DisplayOnMenu = '4')  
            ORDER BY SID, Position, Title", ARRAY_A);
        //var_dump($result);
        //exit();
        if ($result) {
            $this->menu = array(
                'items' => array(),
                'parents' => array()
            );
            foreach ($result as $items) {
                $this->menu['items'][$items['ID']] = $items;
                $this->menu['parents'][$items['SID']][] = $items['ID'];
            }
            return static::globalNav();
        }
    }

}

?>
