<?php

if (\CmsDev\Security\loginIntent::action('validate') === true) {
    if (isset($_POST['IDX'])) {
        $IDX= isset($_POST['IDX']) ? $_POST['IDX'] : '';
        $Categories = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Categories\_classes;
        $Categories->RenderListSub($IDX);
    }
}
?>