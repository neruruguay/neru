<?php

if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
    if (isset($_POST['TemplatesEditor'])) {
        $Title = isset($_POST['Title']) ? $_POST['Title'] : '';
        $Description = isset($_POST['Description']) ? $_POST['Description'] : '';
        $Content = isset($_POST['TemplatesEditor']) ? $_POST['TemplatesEditor'] : '';
        $Image = isset($_POST['Image']) ? $_POST['Image'] : '';
        $Templates = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Templates\_classes;
        if (isset($_POST['AddScript'])) {
            $Templates->AddToListScript($Title, $Description, $Image, $Content);
        } elseif (isset($_POST['Add'])) {
            $Templates->AddToList($Title, $Description, $Image, $Content);
        }
    }
}
?>