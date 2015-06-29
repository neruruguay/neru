<?php
if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    $SKTAJAX = 'AJAX';
    $LanguageFromFile = true;
    require_once ('../../Config.php');
    require_once ('../../db.php');
    require_once ( 'Core.php');
}
$UserName = new \CmsDev\Security\UserName_ValidateName();
echo $UserName->ValidateNameExistAndClean($_POST['UserName']);

?>
