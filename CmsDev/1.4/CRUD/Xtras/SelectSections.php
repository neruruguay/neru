<?php

if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    $SKTAJAX = 'AJAX';
    require ('../../../Config.php');
    require ('../../../db.php');
    require ('../../Core.php');
    $SKTDB = \CmsDev\sql\db_Skt::connect();
}
echo '<style type="text/css">
ul { font-family: Verdana, Geneva, "Trebuchet MS",Tahoma,Geneva,sans-serif; font-size: 9px; margin: 0 0 20px 15px; padding: 0; }
ul li { background-color: transparent; border-bottom: 1px solid gray; border-left: 1px solid gray; list-style: none outside none; margin: 0; padding: 0; }
ul li a { color: black; display: block; line-height: 10px; padding: 4px; text-decoration: none; width: 100%; }
ul li a:hover { background-color: #555555; color: white;}
</style>';
$ID = $_GET['ID'];
$Menu = $SKTDB->get_results("SELECT ID,Title,URLName,SID FROM " . DB_PREFIX . "sections WHERE  RecycleBin = '0' AND SID = '0' ORDER BY Language,Position ASC");
echo '<ul id="SelectSections" class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">';
$i = 0;
foreach ($Menu as $Section) {
    if ($i == 0) {
        $cssfirt = 'ui-corner-left';
    } else {
        $cssfirt = '';
    }
    if ($Section->ID == $ID) {
        $cssSelect = ' ui-state-active';
    } else {
        $cssSelect = '';
    }
    echo '<li class="ui-state-default ' . $cssfirt . $cssSelect . '"><a href="javascript:SetContentSID(\'' . $Section->ID . '\',\'' . $Section->Title . '\');" class="' . $cssfirt . '">' . $Section->Title . '</a>';
    $i++;
    // SEGUNDO NIVEL
    if ($SMenu = $SKTDB->get_results("SELECT ID,Title,URLName,SID FROM " . DB_PREFIX . "sections WHERE RecycleBin = '0' AND SID = '" . $Section->ID . "' AND SID != '0'")) {
        echo '<ul>';
        foreach ($SMenu as $SSection) {
            echo '<li><a href="javascript:SetContentSID(\'' . $SSection->ID . '\',\'' . $SSection->Title . '\');">' . $SSection->Title . '</a>';
            // TERCER NIVEL
            if ($S2Menu = $SKTDB->get_results("SELECT ID,Title,URLName,SID FROM " . DB_PREFIX . "sections WHERE RecycleBin = '0' AND Language = '$Language' AND SID = '" . $SSection->ID . "' AND SID != '0'")) {
                echo '<ul>';
                foreach ($S2Menu as $S2Section) {
                    echo '<li><a href="javascript:SetContentSID(\'' . $S2Section->ID . '\',\'' . $S2Section->Title . '\');">' . $S2Section->Title . '</a></li>';
                }
                echo '</ul>';
            }
            // FIN DEL TERCER NIVEL
            echo '</li>';
        }
        echo '</ul>';
    }
    // FIN DEL SEGUNDO NIVEL
    echo '</li>';
}
echo '</ul>';
?>