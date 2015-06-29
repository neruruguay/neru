<?php

if (\CmsDev\Security\loginIntent::action('validate') === true) {
    if (isset($_POST['ID'])) {
        $ID = isset($_POST['ID']) ? $_POST['ID'] : '';
        $PurchaseRequestss = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Purchase_Requests\_classes;
        $PurchaseRequestss->RemoveFromList($ID);
    }
}
?>