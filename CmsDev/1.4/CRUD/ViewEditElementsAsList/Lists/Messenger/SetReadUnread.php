<?php

if (\CmsDev\Security\loginIntent::action('validate') === true) {
    if (isset($_POST['UserID'])) {
        $ID = $_POST['ID'];
        $UserID = $_POST['UserID'];
        $Owner = isset($_POST['Owner']) ? $_POST['Owner'] : '';
        $Set = isset($_POST['Set']) ? $_POST['Set'] : NULL;
        $Categories = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Messenger\_classes;
        if ($Set === '1') {
            $Categories->SetRead($ID, $UserID, $Owner);
        } else {
            $Categories->SetUnread($ID, $UserID, $Owner);
        }
    }
}
?>