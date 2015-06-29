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
if (\CmsDev\Security\loginIntent::action('validate') === true) {
    $file = dirname(dirname(dirname(dirname(dirname(__FILE__))))) . DIRECTORY_SEPARATOR . $_POST['file'];
    if (file_exists($file)) {
        unlink($file);
        if (file_exists($file . '.tag')) {
            unlink($file . '.tag');
        }
    }
    echo $file;
}