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
if (\CmsDev\Security\loginIntent::action('validate') === true || (isset($_POST['tokenValidate']) && $_POST['tokenValidate'] != '')) {
    if (isset($_POST['ID'])) {
        $Users = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Users\_classes;
        $Users->GoUpdateData($_POST['ID']);
    }
}
?>