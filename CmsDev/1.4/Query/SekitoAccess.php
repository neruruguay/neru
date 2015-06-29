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
if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {

    $SKTDB = \CmsDev\sql\db_Skt::connect();

    $message = $CMSText_RequiredFields;

    $UID = $_SESSION['UID'];

    $USName = $_SESSION['USName'];

    //echo 'paso 1';

    if (isset($_POST['Password']) && $_POST['Password'] != '' && isset($_POST['Password2']) && $_POST['Password2'] != '') {

        //echo 'paso 2'.$userItem->UserName;

        $user = $SKTDB->get_var("SELECT id FROM admin WHERE UserName = '" . $userItem->UserName . "' AND id = '" . $userItem->id . "'  AND Password = '" . $userItem->Password . "'");

        if ($user) {

            //echo 'paso 3';

            if ($_POST['Password'] == $_POST['Password2']) {

                //echo 'paso 4';

                $update = $SKTDB->query(sprintf("UPDATE admin Set 

										UserName = %s, 

										Password = %s

										WHERE id = %s", GetSQLValueString($_POST['UserName'], "text"), GetSQLValueString($_POST['Password'], "text"), GetSQLValueString($user, "int")
                ));

                if ($update) {
                    $message = 'Sus datos fueron cambiados exitosamente!<br />Refresque la p&aacute;gina para volver a loguearse.';
                }
            } else {


                //echo 'paso 5';

                $message = $message . $CMSText_NoEqualPassword;
            }
        } else {
            $message = $message . $CMSText_NoEqualUserPassword;
        }
    }

    echo $message;
}
?>