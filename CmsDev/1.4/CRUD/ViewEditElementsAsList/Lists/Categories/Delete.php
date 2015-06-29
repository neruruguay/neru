<?php

if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
    if (isset($_POST['ID'])) {
        $category_id = isset($_POST['ID']) ? $_POST['ID'] : '';
        $Categories = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Categories\_classes;
        $Categories->RemoveFromList($category_id);
    }
}
?>