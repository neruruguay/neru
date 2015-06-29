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
        $User_plan = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\User_plan\_classes;
        $User_plan->UpdateData($_POST['ID']);
    }
}
?>