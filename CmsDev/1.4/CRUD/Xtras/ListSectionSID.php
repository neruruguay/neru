<?php

$Sections_SID_Page = array();
$Sections_SID_Page['Nav_Class_Wrapper'] = 'menu';
$Sections_SID_Page['Nav_DisplayMenu'] = '1'; // 0=HiddenSections , 1=Top, 2= Footer, 3=Secundary 4=All
$Sections_SID_Page['sktRecycleBinHidden'] = 'sktRecycleBinHidden'; // Dont Change is a Admin control!!!
$Sections_SID_Page['Nav_Sub_Items_Before'] = '';
$Sections_SID_Page['Nav_Sub_Items_After'] = '';
$Sections_SID_Page['Nav_Item_Before'] = '<option value="[ID]" [Nav_Class_Item_Selected] class="[Level]">[URLName]</option>';
$Sections_SID_Page['Nav_Item_After'] = '</li>';
$Sections_SID_Page['Nav_Class_Item_Selected'] = ' selected="selected"';
$Sections_SID_Page['ThisSID'] = $SID;
// $SIDLanguage = Raiz del idioma //-// $SectionValues->ID = Seccion actual hacia adentro
$Sections_SID_Page['Nav_Init_Level'] = $SIDLanguage;
echo '<select name="IDPage" id="IDPage">';

// Select all entries from the menu table
$result = $SKTDB->get_results("SELECT *
						  FROM " . DB_PREFIX . "sections
						  ORDER BY SID, Position, Title", ARRAY_A);

if ($result) {
// Create a multidimensional array to conatin a list of items and parents
    $menu = array(
        'items' => array(),
        'parents' => array()
    );
// Builds the array lists with data from the menu table
    foreach ($result as $items) {
        // Creates entry into items array with current menu item id ie. $menu['items'][1]
        $menu['items'][$items['ID']] = $items;
        // Creates entry into parents array. Parents array contains a list of all items with children
        $menu['parents'][$items['SID']][] = $items['ID'];
    }
// Menu builder function, parentId 0 is the root
    if (!function_exists('Sections_SID_Page')) {

        function Sections_SID_Page($parent, $menu, $URLNameParent) {

            global $Sections_SID_Page;
            global $SectionValues;
            global $subSite;
            global $Language;

            $html = '';
            $Class = $Sections_SID_Page['Nav_Class_Wrapper'];
            $Sections_SID_PageClassHidden = $Sections_SID_Page['sktRecycleBinHidden'];
            $Nav_Item_Before = $Sections_SID_Page['Nav_Item_Before'];
            $Nav_Item_After = $Sections_SID_Page['Nav_Item_After'];
            $Nav_Class_Item_Selected = $Sections_SID_Page['Nav_Class_Item_Selected'];
            $PrefixURL = $subSite . $Language . '/';
            $ThisSID = $Sections_SID_Page['ThisSID'];

            if (isset($menu['parents'][$parent])) {
                $html .= str_replace('[Nav_Class_Wrapper]', $Class, $Sections_SID_Page['Nav_Sub_Items_Before']) . '';
                foreach ($menu['parents'][$parent] as $itemId) {
                    if (!isset($menu['parents'][$itemId])) {
                        if ($ThisSID == $menu['items'][$itemId]['ID']) {
                            $active = $Nav_Class_Item_Selected;
                        } else {
                            $active = '';
                        }
                        $Thisitem = $Nav_Item_Before;
                        $Thisitem = str_replace('<span>[Name]</span>', '<span><span>[Name]</span></span>', $Thisitem);
                        $Thisitem = str_replace('[Name]', $menu['items'][$itemId]['Title'], $Thisitem);
                        $Thisitem = str_replace('[ID]', $menu['items'][$itemId]['ID'], $Thisitem);
                        $Thisitem = str_replace('[Level]', $menu['items'][$itemId]['ID'], $Thisitem);
                        $Thisitem = str_replace('[URLName]', utf8_encode($menu['items'][$itemId]['URLName']), $Thisitem);
                        $Thisitem = str_replace('[Nav_Class_Item_Selected]', $active, $Thisitem);

                        $html .= $Thisitem . $Nav_Item_After;
                    }
                    if (isset($menu['parents'][$itemId])) {
                        if ($ThisSID == $menu['items'][$itemId]['ID']) {
                            $active = $Nav_Class_Item_Selected;
                        } else {
                            $active = '';
                        }
                        $Thisitem = $Nav_Item_Before;
                        $Thisitem = str_replace('[ID]', $menu['items'][$itemId]['ID'], $Thisitem);
                        $Thisitem = str_replace('[Level]', $menu['items'][$itemId]['ID'], $Thisitem);
                        $Thisitem = str_replace('[URLName]', utf8_encode($menu['items'][$itemId]['URLName']), $Thisitem);
                        $Thisitem = str_replace('[Name]', $menu['items'][$itemId]['Title'], $Thisitem);
                        $Thisitem = str_replace('[Nav_Class_Item_Selected]', $active, $Thisitem);

                        $html .= $Thisitem;
                        $html .= Sections_SID_Page($itemId, $menu, $URLNameParent . $menu['items'][$itemId]['URLName'] . '/');
                        $html .= $Nav_Item_After;
                    }
                }
                $html .= $Sections_SID_Page['Nav_Sub_Items_After'];
            }
            return $html;
        }

    }
    echo Sections_SID_Page($Sections_SID_Page['Nav_Init_Level'], $menu, '');
}
echo '</select>';
?>