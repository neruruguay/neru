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
if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {

    $Query_Lists = $SKTDB->query("INSERT INTO lists (ListName) VALUES (" . GetSQLValueString(utf8_decode($_POST['ListName']), "text") . ")");

    $ListsCreatedID = $SKTDB->insert_id;

    for ($i = 1; $i < 41; $i++) {
        $x = 'Field' . $i;
        $x1 = 'Field_Type_Field' . $i;
        if (isset($_POST['Field' . $i]) && $_POST['Field' . $i] != '') {
            $Field[$i] = utf8_decode($_POST['Field_Type_Field' . $i] . '|' . $_POST['Field' . $i]);
        } else {
            $Field[$i] = '';
        }
    }


    $Lists_Fields = $SKTDB->query("INSERT INTO lists_fields (IDLists, Field1, Field2, Field3, Field4, Field5, Field6, Field7, Field8, Field9, Field10, Field11, Field12, Field13, Field14, Field15, Field16, Field17, Field18, Field19, Field20, Field21, Field22, Field23, Field24, Field25, Field26, Field27, Field28, Field29, Field30, Field31, Field32, Field33, Field34, Field35, Field36, Field37, Field38, Field39, Field40)
 	VALUES (" .
            GetSQLValueString($ListsCreatedID, "int") . "," .
            GetSQLValueString($Field[1], "text") . "," .
            GetSQLValueString($Field[2], "text") . "," .
            GetSQLValueString($Field[3], "text") . "," .
            GetSQLValueString($Field[4], "text") . "," .
            GetSQLValueString($Field[5], "text") . "," .
            GetSQLValueString($Field[6], "text") . "," .
            GetSQLValueString($Field[7], "text") . "," .
            GetSQLValueString($Field[8], "text") . "," .
            GetSQLValueString($Field[9], "text") . "," .
            GetSQLValueString($Field[10], "text") . "," .
            GetSQLValueString($Field[11], "text") . "," .
            GetSQLValueString($Field[12], "text") . "," .
            GetSQLValueString($Field[13], "text") . "," .
            GetSQLValueString($Field[14], "text") . "," .
            GetSQLValueString($Field[15], "text") . "," .
            GetSQLValueString($Field[16], "text") . "," .
            GetSQLValueString($Field[17], "text") . "," .
            GetSQLValueString($Field[18], "text") . "," .
            GetSQLValueString($Field[19], "text") . "," .
            GetSQLValueString($Field[20], "text") . "," .
            GetSQLValueString($Field[21], "text") . "," .
            GetSQLValueString($Field[22], "text") . "," .
            GetSQLValueString($Field[23], "text") . "," .
            GetSQLValueString($Field[24], "text") . "," .
            GetSQLValueString($Field[25], "text") . "," .
            GetSQLValueString($Field[26], "text") . "," .
            GetSQLValueString($Field[27], "text") . "," .
            GetSQLValueString($Field[28], "text") . "," .
            GetSQLValueString($Field[29], "text") . "," .
            GetSQLValueString($Field[30], "text") . "," .
            GetSQLValueString($Field[31], "text") . "," .
            GetSQLValueString($Field[32], "text") . "," .
            GetSQLValueString($Field[33], "text") . "," .
            GetSQLValueString($Field[34], "text") . "," .
            GetSQLValueString($Field[35], "text") . "," .
            GetSQLValueString($Field[36], "text") . "," .
            GetSQLValueString($Field[37], "text") . "," .
            GetSQLValueString($Field[38], "text") . "," .
            GetSQLValueString($Field[39], "text") . "," .
            GetSQLValueString($Field[40], "text") . ")"
    );

    /* TABLE FIELD NAMES */


    for ($i = 1; $i < 41; $i++) {
        $x = 'Field' . $i;
        if (isset($_POST['Field' . $i]) && $_POST['Field' . $i] != '') {
            $Field[$i] = utf8_decode($_POST['Field' . $i]);
        } else {
            $Field[$i] = '';
        }
    }

}

if ($Query_Lists && $Lists_Fields) {
    echo $ListsCreatedID . '|okay';
} else {
    echo "error";
}
?>
