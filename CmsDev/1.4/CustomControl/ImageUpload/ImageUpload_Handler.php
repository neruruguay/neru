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
    $Foto = new \CmsDev\CustomControl\ImageUpload\ImageUpload_Control();
    $Foto->SetUpload($_GET['Params1'], $_GET['Params2']);
}
?>