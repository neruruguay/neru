<?php

if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
    if (isset($_POST['Templates_AddScript'])) {
        $Title = isset($_POST['Title']) ? $_POST['Title'] : '';
        $Description = isset($_POST['Description']) ? $_POST['Description'] : '';
        $Content = isset($_POST['TemplatesEditor']) ? $_POST['TemplatesEditor'] : '';
        $Image = isset($_POST['Image']) ? $_POST['Image'] : '';
        $Templates = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\classes\Templates;
        $Templates->AddToListScript($Title, $Description, $Image, $Content);
    }
}
?>