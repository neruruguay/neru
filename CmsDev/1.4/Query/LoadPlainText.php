<?php

if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    $SKTAJAX = 'AJAX';
    require ('../../../../Config.php');
    require ('../../../../db.php');
    require ('../../Core.php');
}
$ID = $_POST['ID'];
$SKTDB = \CmsDev\sql\db_Skt::connect();
$contentIDZone = $SKTDB->get_var("SELECT content FROM " . DB_PREFIX . "content WHERE ID = '$ID'");

if ($contentIDZone) {
    echo $contentIDZone;
} else {
    echo "Ha ocurrido un error,<br>Por favor actualice la pagina [F5]";
}
?>