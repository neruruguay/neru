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

$Dir = Code::Decode($_POST['Dir']);

if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
    foreach ($_POST['listItem'] as $position => $item) {
        $item = Code::Decode($item);
        $file = $Dir . '/' . $item . '.tag';
        if (file_exists($file)) {
            $Metadata = file_get_contents($file);
            $Exp = explode("|", $Metadata);
            //$FileOrder = $Exp[0];
            $Meta = $Exp[1];
            $fp = fopen($file, "w");
            fwrite($fp, $position . "|" . $Meta);
            fclose($fp);
        }
        echo $item.'='.$position.'<br>';
    }
    
}
?>