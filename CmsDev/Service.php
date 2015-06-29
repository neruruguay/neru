<?php

if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    $SKTAJAX = 'AJAX';
    require_once ('DefinePath.php');
    require_once ('../Config.php');
    require_once ('../db.php');
    require_once ( \SKT_VERSION . '/Service.php');
} else {
    require_once ( \SKT_VERSION . '/Service.php');
}
?>
