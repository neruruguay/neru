<?php
    if (isset($_POST['ID']) && isset($_POST['tokenValidate']) && isset($_POST['password'])) {
        $Users = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Users\_classes;
        echo $Users->UserUpdatePassword($_POST['ID'],$_POST['tokenValidate'],$_POST['password']);
    }
?>