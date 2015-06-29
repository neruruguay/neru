<?php

function on_iis() {
    $sSoftware = strtolower($_SERVER["SERVER_SOFTWARE"]);
    if (strpos($sSoftware, "microsoft-iis") !== false) {
        return true;
    } else {
        return false;
    }
}

if (!defined("DB_SERVER")) {

    if (on_iis()) {
        \define("DB_SERVER", "localhost");
        \define("DB_NAME", "NAME");
        \define("DB_USER", "USER");
        \define("DB_PASSWORD", "PASSWORD");
        //echo 'IIS'; exit();
    } else {
        \define("DB_SERVER", "localhost");
        \define("DB_NAME", "NAME");
        \define("DB_USER", "USER");
        \define("DB_PASSWORD", "PASSWORD");
        //echo 'Apache'; exit();
    }
}
?>
