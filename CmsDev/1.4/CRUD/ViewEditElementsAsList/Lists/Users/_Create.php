<?php

if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
    if (isset($_POST['Title'])) {
        $Title = isset($_POST['Title']) ? $_POST['Title'] : '';
        $Description = isset($_POST['Description']) ? $_POST['Description'] : '';
        $url = isset($_POST['url']) ? $_POST['url'] : '';
        $icon = isset($_POST['icon']) ? $_POST['icon'] : '';
        $Sid = isset($_POST['Sid']) ? $_POST['Sid'] : '0';
        $Users = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Users\_classes;
        if (isset($_POST['Add'])) {
            $Users->AddToList($Title, $Description, $url, $icon, $Sid);
        }
    }
}
?>