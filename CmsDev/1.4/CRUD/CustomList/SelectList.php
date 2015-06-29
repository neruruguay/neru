<?php

if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    $SKTAJAX = 'AJAX';

require_once ('../../CmsDev/DefinePath.php');
require_once ('../../../Config.php');
require_once ('../../../db.php');
require_once ('../../CmsDev' . \DS . \SKT_VERSION . \DS . 'Core.php');
}
$SKTDB = \CmsDev\sql\db_Skt::connect();
$InputSelectedListID = isset($_POST['InputSelectedListID']) ? $_POST['InputSelectedListID'] : 0;
$selected = '';
$Query_Lists = $SKTDB->get_results("SELECT ID, ListName FROM lists");
if ($Query_Lists) {
    echo '<div id="Lists" class="selectLists"><h3>Listas</h3><ul class="nav nav-sidebar">';
    foreach ($Query_Lists as $Lists) {
        if ($Lists->ID == $InputSelectedListID) {
            $selected = 'active';
        } else {
            $selected = '';
        }
        echo '<li><a href="javascript:CustomListSKT.SelectListsChange(\'' . $Lists->ID . '\',\''. CmsDev\skt_Code::Charset($Lists->ListName) .'\',this)" class="' . $selected . '"><span>' . CmsDev\skt_Code::Charset($Lists->ListName) . '</span></a></li>';
    }
    echo "</ul></div>";
}
?>