<?php

if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    $SKTAJAX = 'AJAX';
    require ('../../../../Config.php');
    require ('../../../../db.php');
    require ('../../Core.php');
}
$email = isset($_POST['email']) ? $_POST['email'] : '';
$SKTDB = \CmsDev\sql\db_Skt::connect();
$checkemail = $SKTDB->get_var("SELECT email FROM newsletter_users where email = " . GetSQLValueString($email, "text") . "");
if (!$checkemail) {

    $insert = $SKTDB->query("INSERT INTO newsletter_users (email) VALUES (" . GetSQLValueString($email, "text") . ")");
    if ($insert) {
        echo "Su correo fue agregado a nuestra lista de Newsletter.";
    } else {
        echo "Lo sentimos, no se pudo ingresar su correo, compruebe que es correcto.";
    }
} else {
    echo "Su correo ya fu&eacute; agregado, muchas gracias.";
}
?>