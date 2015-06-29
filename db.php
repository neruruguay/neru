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
        \define("DB_NAME", "daguerre_cms");
        \define("DB_USER", "daguerre_cms");
        \define("DB_PASSWORD", "daguerre_cms");
        //echo 'IIS'; exit();
    } else {
        \define("DB_SERVER", "localhost");
        \define("DB_NAME", "mdaguerr_negociosenred");
        \define("DB_USER", "mdaguerr_negocio");
        \define("DB_PASSWORD", "d3d05B3");
        //echo 'Apache'; exit();
    }
}
?>