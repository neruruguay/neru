<?php

if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
    if (isset($_POST['ID'])) {
        $ID = isset($_POST['ID']) ? $_POST['ID'] : '';
        $Title = isset($_POST['Title']) ? $_POST['Title'] : '';
        $Description = isset($_POST['Description']) ? $_POST['Description'] : '';
        $Content = isset($_POST['TemplatesEditor']) ? $_POST['TemplatesEditor'] : '';
        $Image = isset($_POST['Image']) ? $_POST['Image'] : '';
        $Templates = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Templates\_classes;
        $Templates->EditItemList($ID, $Title, $Description, $Image, $Content);
    }
}
?>