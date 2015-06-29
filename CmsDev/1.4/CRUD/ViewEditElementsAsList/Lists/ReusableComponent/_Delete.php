<?php

if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
    if (isset($_POST['ID'])) {
        $ID = isset($_POST['ID']) ? $_POST['ID'] : '';
        $ReusableComponent = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\ReusableComponent\_classes;
        $ReusableComponent->RemoveFromList($ID);
    }
}
?>