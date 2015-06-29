<?php

if (\CmsDev\Security\loginIntent::action('validate') === true) {
    $ID = isset($_POST['ID']) ? $_POST['ID'] : '';
    $Owner = isset($_POST['Owner']) ? $_POST['Owner'] : '';
    if ($ID != '') {
        $Messenger = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Messenger\_classes;
        $Messenger->RemoveFromList($ID, $Owner);
    }
}
?>