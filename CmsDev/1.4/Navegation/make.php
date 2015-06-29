<?php

/**
 * Description of Menu
 *
 * @author Martín Daguerre
 */

namespace CmsDev\Navegation;

class Menu {

    protected static function PopUpMode($url = '', $w = '640', $h = '480', $title = '...') {
        $script = 'javascript:SKT.PopUp(\'' . $url . '\',\'_blank\',\'toolbar=no, location=no, directories=no, status=no, menubar=no, title=' . $title . ', width=' . $w . ',height=' . $h . '\');';
        if ($url != '') {
            return $script;
        }
    }

    protected static function globalNav($parent, $menu, $URLNameParent, $Sections_Menu, $wrapUL) {

        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $SectionValues = \CmsDev\Content\Section::get();
        $Language = \THIS_LANG;
        $subSite = \SUBSITE;
        if ($subSite === '') {
            $subSite = '/';
        }
        $html = '';
        $Sections_MenuClassHidden = 'sktRecycleBinHidden';

        $Class = $Sections_Menu['Class'];
        $set_Item_Template_Before = $Sections_Menu['set_Item_Template_Before'];
        $set_Item_Template_After = $Sections_Menu['set_Item_Template_After'];
        $CSS_Selected = $Sections_Menu['set_CSS_Selected'];
        $PrefixURL = $subSite; // . $Language . '/';
        $LoggedInAdmin = \CmsDev\Security\loginIntent::action('validateAdmin');
        if (!isset($parent)) {
            $parent = 0;
        }
        if (isset($menu['parents'][$parent])) {
            if ($wrapUL === true) {
                $html .= str_replace('[Class]', $Class, $Sections_Menu['Wrap_Before']) . '';
            }
            foreach ($menu['parents'][$parent] as $itemId) {

                if (!isset($menu['parents'][$itemId])) {

                    if ($SectionValues->ID == $menu['items'][$itemId]['ID']) {
                        $active = $CSS_Selected;
                    } else {
                        $active = '';
                    }
                    $Thisitem = $set_Item_Template_Before;

                    if ($menu['items'][$itemId]['Link_ID'] != '') {


                        $linkValues = $SKTDB->get_row("SELECT * FROM " . \DB_PREFIX . "links WHERE ID = '" . $menu['items'][$itemId]['Link_ID'] . "'");

                        if ($menu['items'][$itemId]['RecycleBin'] == 1) {
                            $Thisitem = str_replace('[sktRecycleBinHidden]', $Sections_MenuClassHidden, $Thisitem);
                        } else {
                            $Thisitem = str_replace('[sktRecycleBinHidden]', '', $Thisitem);
                        }

                        if ($LoggedInAdmin == true) {
                            $Thisitem = str_replace('</a>', '</a><a href="javascript:AppSKT.sktViewLinkItem(\'' . $PrefixURL . $URLNameParent . $menu['items'][$itemId]['URLName'] . '\',\'' . $menu['items'][$itemId]['Link_ID'] . '\');" class="sktViewLinkItem"><i class="skt-icon-edit"></i></a>', $Thisitem);
                        }

                        $Thisitem = str_replace('<span>[Name]</span>', '<span><span>[Name]</span></span>', $Thisitem);
                        if ($linkValues) {
                            $Thisitem = str_replace('[Name]', $linkValues->LinkTitle, $Thisitem);

                            if ($menu['items'][$itemId]['LinkActive'] == 1) {
                                if ($linkValues->LinkType == 'popup') {
                                    $Thisitem = str_replace('[URL]', self::PopUpMode($linkValues->Link, $linkValues->W, $linkValues->H, $linkValues->LinkTitle), $Thisitem);
                                }
                                $Thisitem = str_replace('[URL]', $linkValues->Link . '/', $Thisitem);
                                $Thisitem = str_replace('_self', $linkValues->Target, $Thisitem);
                            } else {
                                $Thisitem = str_replace('[URL]', 'javascript:void(0);', $Thisitem);
                                $Thisitem = str_replace('class="', 'class="CursorDefault', $Thisitem);
                            }
                            $Thisitem = str_replace('[CSS_Selected]', $linkValues->css_class . ' ' . $active, $Thisitem);
                            //$Thisitem = str_replace(' href="',' rel="'.$PrefixURL.$URLNameParent.$menu['items'][$itemId]['URLName'].'" href="',$Thisitem);
                        } else {
                            $Thisitem = '';
                        }
                    } else {

                        if ($menu['items'][$itemId]['RecycleBin'] == 1) {
                            $Thisitem = str_replace('[sktRecycleBinHidden]', $Sections_MenuClassHidden, $Thisitem);
                        } else {
                            $Thisitem = str_replace('[sktRecycleBinHidden]', '', $Thisitem);
                        }
                        $Thisitem = str_replace('<span>[Name]</span>', '<span><span>[Name]</span></span>', $Thisitem);
                        $Thisitem = str_replace('[Name]', $menu['items'][$itemId]['Title'], $Thisitem);
                        if ($menu['items'][$itemId]['LinkActive'] == 1) {
                            $Thisitem = str_replace('[URL]', $PrefixURL . $URLNameParent . $menu['items'][$itemId]['URLName'] . '/', $Thisitem);
                        } else {
                            $Thisitem = str_replace('[URL]', 'javascript:void(0);', $Thisitem);
                            $Thisitem = str_replace('class="', 'class="CursorDefault', $Thisitem);
                        }
                        $Thisitem = str_replace('[CSS_Selected]', $active, $Thisitem);
                    }
                    $Thisitem = str_replace('[CSS_WithArrow]', '', $Thisitem);

                    $html .= $Thisitem . $set_Item_Template_After . " ";
                }
                if (isset($menu['parents'][$itemId])) {
                    if ($SectionValues->ID == $menu['items'][$itemId]['ID']) {
                        $active = $CSS_Selected;
                    } else {
                        $active = '';
                    }
                    $Thisitem = $set_Item_Template_Before;

                    if ($menu['items'][$itemId]['RecycleBin'] == 1) {
                        $Thisitem = str_replace('[sktRecycleBinHidden]', $Sections_MenuClassHidden, $Thisitem);
                    } else {
                        $Thisitem = str_replace('[sktRecycleBinHidden]', '', $Thisitem);
                    }
                    $Thisitem = str_replace('[Name]', $menu['items'][$itemId]['Title'], $Thisitem);

                    if ($menu['items'][$itemId]['LinkActive'] == 1) {
                        $Thisitem = str_replace('[URL]', $PrefixURL . $URLNameParent . $menu['items'][$itemId]['URLName'] . '/', $Thisitem);
                    } else {
                        $Thisitem = str_replace('[URL]', 'javascript:void(0);', $Thisitem);
                        $Thisitem = str_replace('class="', 'class="CursorDefault', $Thisitem);
                    }
                    $Thisitem = str_replace('[CSS_Selected]', $active, $Thisitem);
                    $Thisitem = str_replace('[CSS_WithArrow]', 'with-arrow', $Thisitem);
                    $html .= $Thisitem;
                    //$html .= \CmsDev\Navegation\make::nav($Sections_Menu, $menu['items'][$itemId]['ID'], $menu['items'][$itemId]['URLName'].'/');
                    $html .= self::globalNav($itemId, $menu, $URLNameParent . $menu['items'][$itemId]['URLName'] . '/', $Sections_Menu, true);
                    $html .= '<span class="arrow skt-icon-arrow"></span>';
                    $html .= $set_Item_Template_After . " ";
                }
            }
            if ($wrapUL === true) {
                $html .= $Sections_Menu['Wrap_After'] . "";
            }
        }
        return \CmsDev\skt_Code::Charset($html);
    }

}

class make extends \CmsDev\Navegation\Menu {

    public static function nav($Sections_Menu, $ID = 1, $URLNameParent = '') {

        $ShowHidden = " RecycleBin = '0'  AND";
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $SectionValues = \CmsDev\Content\Section::get();
        $Language = $SectionValues->Language;
        $LoggedInAdmin = \CmsDev\Security\loginIntent::action('validateAdmin');
        if ($LoggedInAdmin === true) {
            $ShowHidden = "";
        }
        $result = $SKTDB->get_results("SELECT ID,Title,Description,URLName,SID,Position,SectionType,RecycleBin,DisplayOnMenu, LinkActive, Link_ID
            FROM " . \DB_PREFIX . "sections
            WHERE (" . $ShowHidden . " Language = '" . $Language . "' AND SectionType = '1' AND DisplayOnMenu = '" . $Sections_Menu['DisplayMenu'] . "') 
               OR (" . $ShowHidden . " Language = '" . $Language . "' AND SectionType = '1' AND DisplayOnMenu = '4')  
            ORDER BY SID, Position, Title", ARRAY_A);
        if ($result) {
            $menu = array(
                'items' => array(),
                'parents' => array()
            );
            foreach ($result as $items) {
                $menu['items'][$items['ID']] = $items;
                $menu['parents'][$items['SID']][] = $items['ID'];
            }
            return static::globalNav($ID, $menu, $URLNameParent, $Sections_Menu, false);
        }
    }

}

?>
