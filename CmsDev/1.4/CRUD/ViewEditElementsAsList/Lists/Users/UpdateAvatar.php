<?php
if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    $SKTAJAX = 'AJAX';
    require ('../../../../../../Config.php');
    require ('../../../../../../db.php');
    require ('../../../../Core.php');
}
if (\CmsDev\Security\loginIntent::action('validate') === true) {
    if (isset($_POST['ID'])) {
        $Users = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Users\_classes;
        $Users->UpdateAvatar($_POST['Image'], $_POST['ID']);
    }
}
?>