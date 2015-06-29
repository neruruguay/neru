<?php

if (\CmsDev\Security\loginIntent::action('validate') === true) {
    $Products = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Products\_classes;
    $Products->AddToList();
}
?>