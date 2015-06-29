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

if (\CmsDev\Security\loginIntent::action('validate', 'FolderRename') === true) {

    $DS = DIRECTORY_SEPARATOR;
    $find = array('\/', '\\/', '//', '\//', '\\', '//', '/');
    $replace = array($DS, $DS, $DS, $DS, $DS, $DS, $DS);
    //
    $folder = Code::Decode($_POST['folder']);
    $folderN = Code::Decode($_POST['folderN']);
    //
    $folder = str_replace($find, $replace, $folder);
    $folderN = str_replace($find, $replace, $folderN);
    //
    @rename($folder, $folderN);
    echo "Yes";
}
?>