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
$file = Code::Decode($_POST['file']);

if (file_exists($file)) {

    unlink($file);

    if (file_exists($file . '.tag')) {

        unlink($file . '.tag');
    }

    echo 'ok';
} else {

    echo 'error';
}
?>