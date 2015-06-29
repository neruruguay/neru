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
$file = Code::Decode($_POST['File']) . '.tag';

if (file_exists($file)) {

    $file = file($file);

    $lines = count($file);

    for ($i = 0; $i < $lines; $i++) {
        echo utf8_decode(Code::Decode($file[$i]));
    }
} else {

    $handle = fopen($file, "a+");

    $add = "";

    fwrite($handle, $add);

    fclose($handle);
}
?>

