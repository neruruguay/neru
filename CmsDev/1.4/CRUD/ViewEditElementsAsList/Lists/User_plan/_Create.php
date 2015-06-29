<?php

if (\CmsDev\Security\loginIntent::action('validate') === true) {
    $user_plan = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\User_plan\_classes;
    $user_plan->AddToList();
}
?>