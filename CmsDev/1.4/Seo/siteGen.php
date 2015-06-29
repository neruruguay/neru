<?php

ini_set("memory_limit", "20M");
require_once("db.php");
require_once("_CmsDevCore/Admin_Glosary.php");
require_once("_CmsDevCore/SQL/shared/ez_sql_core.php");
// (MYSQL CONNECT)////////////////////////////////////////////////////////////////////////////////////
require_once("_CmsDevCore/SQL/mysql/ez_sql_mysql.php");
$SKTDB = new ezSQL_mysql(DB_USER, DB_PASSWORD, DB_NAME, DB_SERVER);
$HTTP = "http://" . $_SERVER['HTTP_HOST'];
$subSite = '';
$Language = 'esp';
$SitemapGenerator = array();
$SitemapGenerator['Wrap_Before'] = "\t\n";
$SitemapGenerator['Wrap_After'] = "\t\n";
$SitemapGenerator['set_Item_Template_Before'] = "<url><loc>" . $HTTP . $subSite . "/[URL]</loc><changefreq>weekly</changefreq></url>";
$SitemapGenerator['set_Item_Template_After'] = "\t\n";
$ShowHidden = " RecycleBin = '0'  AND";
// Select all entries from the menu table
$result = $SKTDB->get_results("SELECT ID,Title,Description,URLName,SID,Position
						  FROM " . DB_PREFIX . "sections
						  WHERE " . $ShowHidden . " Language = '" . $Language . "' 
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
    function class_SitemapGenerator($parent, $menu, $URLNameParent) {
        global $SitemapGenerator;
        global $subSite;
        global $Language;
        $html = "";
        $set_Item_Template_Before = $SitemapGenerator['set_Item_Template_Before'];
        $set_Item_Template_After = $SitemapGenerator['set_Item_Template_After'];
        $PrefixURL = $subSite . $Language . '/';

        require_once("db.php");
        require_once("_CmsDevCore/Glosary.php");
        require_once("_CmsDevCore/SQL/shared/ez_sql_core.php");
        // (MYSQL CONNECT)////////////////////////////////////////////////////////////////////////////////////
        require_once("_CmsDevCore/SQL/mysql/ez_sql_mysql.php");
        $SKTDB = new ezSQL_mysql(DB_USER, DB_PASSWORD, DB_NAME, DB_SERVER);


        if (isset($menu['parents'][$parent])) {
            $html .= $SitemapGenerator['Wrap_Before'];
            foreach ($menu['parents'][$parent] as $itemId) {
                if (!isset($menu['parents'][$itemId])) {
                    $Thisitem = $set_Item_Template_Before;
                    //$Thisitem = str_replace('[URL]',$PrefixURL.$menu['items'][$itemId]['URLName'],$Thisitem);

                    $PSID1 = $menu['items'][$itemId]['SID'];
                    if (isset($PSID1) && $PSID1 != '') {

                        $ParentURLThisProd = $PSID1 . '/' . $menu['items'][$itemId]['URLName'];

                        $PSID2 = $SKTDB->get_row("SELECT SID, URLName FROM " . DB_PREFIX . "sections WHERE ID = '$PSID1'");
                        if (isset($PSID2->SID) && $PSID2->SID != '') {

                            $ParentURLThisProd = $PSID2->URLName . '/' . $PSID1->URLName . '/' . $menu['items'][$itemId]['URLName'];

                            $PSID3 = $SKTDB->get_row("SELECT SID, URLName FROM " . DB_PREFIX . "sections WHERE ID = '$PSID2->SID'");
                            if (isset($PSID3->SID) && $PSID3->SID != '') {

                                $ParentURLThisProd = $PSID3->URLName . '/' . $PSID2->URLName . '/' . $PSID1->URLName . '/' . $menu['items'][$itemId]['URLName'];

                                $PSID4 = $SKTDB->get_row("SELECT SID, URLName FROM " . DB_PREFIX . "sections WHERE ID = '$PSID3->SID'");
                                if (isset($PSID4->SID) && $PSID4->SID != '') {

                                    $ParentURLThisProd = $PSID4->URLName . '/' . $PSID3->URLName . '/' . $PSID2->URLName . '/' . $PSID1->URLName . '/' . $menu['items'][$itemId]['URLName'];
                                }
                            }
                        }
                    }
                    $ParentURLThisProd = str_replace('//', '/', $ParentURLThisProd);
                    $Thisitem = str_replace('[URL]', $PrefixURL . $ParentURLThisProd, $Thisitem);
                    $html .= $Thisitem . $set_Item_Template_After . " ";
                    $html = str_replace('Portada/', '', $html);
                }
                if (isset($menu['parents'][$itemId])) {
                    $Thisitem = $set_Item_Template_Before;
                    //$Thisitem = str_replace('[URL]',$PrefixURL.$menu['items'][$itemId]['URLName'],$Thisitem);

                    $PSID1 = $menu['items'][$itemId]['SID'];
                    if (isset($PSID1) && $PSID1 != '') {

                        $ParentURLThisProd = $PSID1 . '/' . $menu['items'][$itemId]['URLName'];

                        $PSID2 = $SKTDB->get_row("SELECT SID, URLName FROM " . DB_PREFIX . "sections WHERE ID = '$PSID1'");
                        if (isset($PSID2->SID) && $PSID2->SID != '') {

                            $ParentURLThisProd = $PSID2->URLName . '/' . $PSID1->URLName . '/' . $menu['items'][$itemId]['URLName'];

                            $PSID3 = $SKTDB->get_row("SELECT SID, URLName FROM " . DB_PREFIX . "sections WHERE ID = '$PSID2->SID'");
                            if (isset($PSID3->SID) && $PSID3->SID != '') {

                                $ParentURLThisProd = $PSID3->URLName . '/' . $PSID2->URLName . '/' . $PSID1->URLName . '/' . $menu['items'][$itemId]['URLName'];

                                $PSID4 = $SKTDB->get_row("SELECT SID, URLName FROM " . DB_PREFIX . "sections WHERE ID = '$PSID3->SID'");
                                if (isset($PSID4->SID) && $PSID4->SID != '') {

                                    $ParentURLThisProd = $PSID4->URLName . '/' . $PSID3->URLName . '/' . $PSID2->URLName . '/' . $PSID1->URLName . '/' . $menu['items'][$itemId]['URLName'];
                                }
                            }
                        }
                    }
                    $ParentURLThisProd = str_replace('//', '/', $ParentURLThisProd);
                    $Thisitem = str_replace('[URL]', $PrefixURL . $ParentURLThisProd, $Thisitem);
                    $html .= $Thisitem . " ";
                    $html .= class_SitemapGenerator($itemId, $menu, $menu['items'][$itemId]['URLName'] . '/');
                    $html .= $set_Item_Template_After . " ";
                    $html = str_replace('Portada/', '', $html);
                }
            }
            $html .= $SitemapGenerator['Wrap_After'] . "";
        }
        return $html;
    }

    $Sitemap = class_SitemapGenerator(0, $menu, '');

    function class_SitemapGeneratorSimpleUrl($parent, $menu, $URLNameParent) {
        global $SitemapGenerator;
        global $subSite;
        global $Language;
        $html = "";
        $set_Item_Template_Before = $SitemapGenerator['set_Item_Template_Before'];
        $set_Item_Template_After = $SitemapGenerator['set_Item_Template_After'];
        $PrefixURL = $subSite . $Language . '/';

        if (isset($menu['parents'][$parent])) {
            $html .= $SitemapGenerator['Wrap_Before'];
            foreach ($menu['parents'][$parent] as $itemId) {
                if (!isset($menu['parents'][$itemId])) {
                    $Thisitem = $set_Item_Template_Before;
                    $Thisitem = str_replace('[URL]', $PrefixURL . $URLNameParent . $menu['items'][$itemId]['URLName'], $Thisitem);
                    $html .= $Thisitem . $set_Item_Template_After . " ";
                    $html = str_replace('portada/', '', $html);
                }
                if (isset($menu['parents'][$itemId])) {
                    $Thisitem = $set_Item_Template_Before;
                    $Thisitem = str_replace('[URL]', $PrefixURL . $URLNameParent . $menu['items'][$itemId]['URLName'], $Thisitem);
                    $html .= $Thisitem . " ";
                    $html .= class_SitemapGenerator($itemId, $menu, '');
                    $html .= $set_Item_Template_After . " ";
                    $html = str_replace('portada/', '', $html);
                }
            }
            $html .= $SitemapGenerator['Wrap_After'] . "";
        }
        return $html;
    }

    $SitemapSimpleUrl = class_SitemapGeneratorSimpleUrl(0, $menu, '');
}
$name = "sitemap.xml";
$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<urlset
      xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"
      xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
      xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\r";
$xml = $xml . $SitemapSimpleUrl . $Sitemap;
$xml = $mapa . $xml . "</urlset>";
$fp = fopen($name, "w");
//$xml = utf8_encode($xml);
fwrite($fp, $xml);
fclose($fp);
header("Content-Type:text/xml");
echo $xml;
?>