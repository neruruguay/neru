<?php

if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
    if (isset($_POST['ID'])) {
        $ID = isset($_POST['ID']) ? $_POST['ID'] : '';
        $Title = isset($_POST['Title']) ? $_POST['Title'] : '';
        $Description = isset($_POST['Description']) ? $_POST['Description'] : '';
        $Content = isset($_POST['ReusableComponentEditor']) ? $_POST['ReusableComponentEditor'] : '';
        $Image = isset($_POST['Image']) ? $_POST['Image'] : '';
        $ReusableComponent = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\ReusableComponent\_classes;
        $ReusableComponent->EditItemList($ID, $Title, $Description, $Image, $Content);
    }
}
?>