<?php
if (\CmsDev\Security\loginIntent::action('validateUser') === true) {
    $PurchaseRequests = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Purchase_Requests\_classes;
    $PurchaseRequests->AddToList();
}
?>