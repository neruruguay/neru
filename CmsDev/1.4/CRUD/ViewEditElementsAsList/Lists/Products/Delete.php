<?php

if (\CmsDev\Security\loginIntent::action('validate') === true) {
    if (isset($_POST['ID'])) {
        $ID = isset($_POST['ID']) ? $_POST['ID'] : '';
        $Products = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Products\_classes;
        $Products->RemoveFromList($ID);
    }
}
?>