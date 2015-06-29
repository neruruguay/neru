<?php

if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
    if (isset($_POST['id'])) {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $Users = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Users\_classes;
        $Users->RemoveFromList($id);
    }
}
?>