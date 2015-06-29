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

$file = Code::Decode($_POST['File']);

if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
    if (file_exists($file)) {
        $fp = fopen($file . '.tag', "w+");
        $Title = isset($_POST['Title']) ? $_POST['Title'] : '';
        $Description = isset($_POST['TagsDescription']) ? $_POST['TagsDescription'] : '';
        $Hiperlink = isset($_POST['hiperlink']) ? $_POST['hiperlink'] : '';
        $FileOrder = isset($_POST['FileOrder']) ? $_POST['FileOrder'] : '';
        $CustomData = isset($_POST['CustomData']) ? $_POST['CustomData'] : '';
        
        $add = utf8_encode($Title) . "|" . utf8_encode($Description) . "|" . $Hiperlink . "|" . $FileOrder . "|" . $CustomData;
        $Data = Code::Encode($add);
        fwrite($fp, $Data);
        fclose($fp);
        $MessageInfo = \SKT_ADMIN_Message_TagsSaveOk;
        echo $MessageInfo;
        die;
    } else {
        $MessageInfoError = \SKT_ADMIN_Message_TagsSaveError;
        echo $MessageInfoError;
    }
}
?>