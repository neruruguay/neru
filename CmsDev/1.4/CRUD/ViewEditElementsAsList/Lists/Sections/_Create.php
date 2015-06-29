<?php

if (\CmsDev\Security\loginIntent::action('validate') === true) {
    $sections = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Sections\_classes;
    $sections->AddToList();
}
?>