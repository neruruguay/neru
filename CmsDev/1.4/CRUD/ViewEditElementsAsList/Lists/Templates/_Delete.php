<?php

if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
    if (isset($_POST['ID'])) {
        $ID = isset($_POST['ID']) ? $_POST['ID'] : '';
        $Templates = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Templates\_classes;
        $Templates->RemoveFromList($ID);
    }
}
?>