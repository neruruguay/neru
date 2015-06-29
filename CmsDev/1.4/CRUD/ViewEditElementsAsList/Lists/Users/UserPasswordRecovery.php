<?php
    if (isset($_POST['PasswordRecovery'])) {
        $Users = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Users\_classes;
        echo $Users->UserPassRecovery($_POST['PasswordRecovery']);
    }
?>