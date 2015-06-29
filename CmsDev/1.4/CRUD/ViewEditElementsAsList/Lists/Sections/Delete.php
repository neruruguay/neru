<?php

if (\CmsDev\Security\loginIntent::action('validate') === true) {
    if (isset($_POST['ID'])) {
        $ID = isset($_POST['ID']) ? $_POST['ID'] : '';
        $sections = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Sections\_classes;
        $sections->RemoveFromList($ID);
    }
}
?>