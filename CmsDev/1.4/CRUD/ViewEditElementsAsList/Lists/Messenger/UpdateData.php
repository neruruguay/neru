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
        $Messenger = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Messenger\_classes;
        $Messenger->GoUpdateData($_POST['ID']);
    }
}
?>