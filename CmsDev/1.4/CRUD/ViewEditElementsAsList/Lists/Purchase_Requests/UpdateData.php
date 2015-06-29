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
        $PurchaseRequestss = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Purchase_Requests\_classes;
        $PurchaseRequestss->UpdateData($_POST['ID']);
    }
}
?>