<?php

if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    $SKTAJAX = 'AJAX';
    require ('../../../Config.php');
    require ('../../../db.php');
    require ('../../Core.php');
}
$SKTDB = \CmsDev\sql\db_Skt::connect();
if (\CmsDev\Security\loginIntent::action('validate') === true && $_POST['ID'] != '') {

    $Query_Lists_DELETE = $SKTDB->query("DELETE FROM lists WHERE ID = '$_POST[ID]' LIMIT 1");
    $Query_Lists_Fields_DELETE = $SKTDB->query("DELETE FROM lists_fields WHERE IDLists = '$_POST[ID]' ");
    $Query_Lists_Values_DELETE = $SKTDB->query("DELETE FROM lists_values WHERE IDList = '$_POST[ID]' ");

}
?>