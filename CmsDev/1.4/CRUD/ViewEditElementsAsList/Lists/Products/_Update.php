<?php

if (\CmsDev\Security\loginIntent::action('validate') === true) {
    if (isset($_POST['ID'])) {
        $ID = $_POST['ID'];
        $Categories = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Products\_classes;
        $Categories->EditItemList($ID);
    }
}
?>