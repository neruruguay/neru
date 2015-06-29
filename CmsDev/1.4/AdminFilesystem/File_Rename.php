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

if (\CmsDev\Security\loginIntent::action('validate', 'FileRename') === true) {
    $DS = DIRECTORY_SEPARATOR;
    $find = array('\/', '\\/', '//', '\//', '\\', '//', '/');
    $replace = array($DS, $DS, $DS, $DS, $DS, $DS, $DS);
    //
    $file = Code::Decode($_POST['File']);
    $FileN = Code::Decode($_POST['FileN']);
    $NameEXT = trim($_POST['NameEXT']);
    //
    $file = str_replace($find, $replace, $file);
    $FileN = str_replace($find, $replace, $FileN);
    //
    //echo "Yes <br>File=" . $file . "<br>FileN=" . $FileN . "<br>" . $NameEXT;
    rename($file, $FileN . $NameEXT);
    rename($file . '.tag', $FileN . $NameEXT . '.tag');
    echo "Yes";
}
?>