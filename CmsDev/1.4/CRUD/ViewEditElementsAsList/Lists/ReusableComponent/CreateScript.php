<?php

if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
    if (isset($_POST['ReusableComponent_AddScript'])) {
        $Title = isset($_POST['Title']) ? $_POST['Title'] : '';
        $Description = isset($_POST['Description']) ? $_POST['Description'] : '';
        $Content = isset($_POST['ReusableComponentEditor']) ? $_POST['ReusableComponentEditor'] : '';
        $Image = isset($_POST['Image']) ? $_POST['Image'] : '';
        $ReusableComponent = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\classes\ReusableComponent;
        $ReusableComponent->AddToListScript($Title, $Description, $Image, $Content);
    }
}
?>