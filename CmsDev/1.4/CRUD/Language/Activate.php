<?php

if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    $SKTAJAX = 'AJAX';
    require ('../../../Config.php');
    require ('../../../db.php');
    require ('../../Core.php');
}
$SKTDB = \CmsDev\sql\db_Skt::connect();
if (\CmsDev\Security\loginIntent::action('validate', 'Language', 'Edit') === true) {

    if ($_POST['Hidden'] == 0) {
        $action = 1;
    } else {
        $action = 0;
    }



    $update = $SKTDB->query(sprintf("UPDATE " . DB_PREFIX . "language Set 

					Hidden = %s

					WHERE ID = %s", GetSQLValueString($action, "int"), GetSQLValueString($_POST['ID'], "int")
    ));

    if ($update) {

        if ($_POST['Hidden'] == 0) {
            echo '<span class="ui-button-text">Mostrar</span>';
        } else {
            echo '<span class="ui-button-text">Ocultar</span>';
        }
    } else {

        echo "Ha ocurrido un error,<br>Por favor actualice la pagina [F5]";
    }
}
?>