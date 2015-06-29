<?php

if (\CmsDev\Security\loginIntent::action('validate') === true) {
    if (isset($_POST['ID'])) {
        $ID = isset($_POST['ID']) ? $_POST['ID'] : '';
        $user_plan = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\User_plan\_classes;
        $user_plan->RemoveFromList($ID);
    }
}
?>