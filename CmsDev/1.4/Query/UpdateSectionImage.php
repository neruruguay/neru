<?php

if (isset($_POST['ID']) && $_POST['ID'] != '' && isset($_POST['SectionImage']) && $_POST['SectionImage'] != '') {
    if (!isset($GLOBALS['SKT'])) {
        if (session_id() == '') {
            session_start();
        }
        $SKTAJAX = 'AJAX';
        require ('../../../Config.php');
        require ('../../../db.php');
        require ('../Core.php');
    }

    if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
        $SKTDB = \CmsDev\sql\db_Skt::connect();
        if ($_POST['SectionImage'] == 'Null') {

            $updateSectionImage = mysql_query(sprintf("UPDATE " . DB_PREFIX . "sections Set 
							SectionImage = %s
							WHERE ID = %s", GetSQLValueString('', "text"), GetSQLValueString($_POST['ID'], "int")
            ));
            if ($updateSectionImage) {
                echo 'Null';
            } else {
                echo ': Error';
            }
        } else {

            $updateSectionImage = mysql_query(sprintf("UPDATE " . DB_PREFIX . "sections Set 
							SectionImage = %s
							WHERE ID = %s", GetSQLValueString($_POST['SectionImage'], "text"), GetSQLValueString($_POST['ID'], "int")
            ));
            if ($updateSectionImage) {
                echo ': Imagen cargada';
            } else {
                echo ': Error';
            }
        }
    }
}
?>