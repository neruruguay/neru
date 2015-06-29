<?php

if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    $SKTAJAX = 'AJAX';
    require ('../../../Config.php');
    require ('../../../db.php');
    require ('../Core.php');
    $SKTDB = \CmsDev\sql\db_Skt::connect();
}

use \CmsDev\skt_Code as Code;

if (\CmsDev\Security\loginIntent::action('validate') === true) {
    if (isset($_POST['MakeFolder']) && $_POST['MakeFolder'] != '') {
        $Folder = explode('/', $_POST['MakeFolder']);
        umask(0000);
        mkdir(Code::Decode($Folder[0]).'/'.$Folder[1] . "", 0777);
        echo "Yes";
    } else {
        echo "Escriba el nombre de la carpeta.";
    }
}
?>

