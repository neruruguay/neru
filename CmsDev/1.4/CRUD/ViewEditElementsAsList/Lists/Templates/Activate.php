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
$ID = \GetSQLValueString(\str_replace('ID', '', $_POST['ID']), "int");
if (isset($ID) && $ID !== '') {
    $Templates = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Templates\_classes;
    $Templates->ActivateItemList($ID);
}
?>