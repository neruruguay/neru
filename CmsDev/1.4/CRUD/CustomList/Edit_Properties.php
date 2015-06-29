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
    $IDLists = $_POST['IDLists'];

    $Field = array();

    for ($i = 1; $i < 41; $i++) {
        $x = 'Field' . $i;
        $x1 = 'Field_Type_Field' . $i;
        if ($_POST['Field' . $i] != '') {
            $Field[$i] = utf8_decode($_POST['Field_Type_Field' . $i] . '|' . $_POST['Field' . $i]);
        } else {
            $Field[$i] = '';
        }
    }


    $update = $SKTDB->query(sprintf("UPDATE lists_fields Set 
	  Field1 = %s,
	  Field2 = %s, 
	  Field3 = %s, 
	  Field4 = %s,
	  Field5 = %s,
	  Field6 = %s,
	  Field7 = %s,
	  Field8 = %s,
	  Field9 = %s,
	  Field10 = %s,
	  Field11 = %s,
	  Field12 = %s,
	  Field13 = %s,	
	  Field14 = %s,
	  Field15 = %s,
          Field16 = %s,
	  Field17 = %s, 
	  Field18 = %s, 
	  Field19 = %s,
	  Field20 = %s,
	  Field21 = %s,
	  Field22 = %s,
	  Field23 = %s,
	  Field24 = %s,
	  Field25 = %s,
	  Field26 = %s,
	  Field27 = %s,
	  Field28 = %s,	
	  Field29 = %s,
	  Field30 = %s,
          Field31 = %s,
	  Field32 = %s, 
	  Field33 = %s, 
	  Field34 = %s,
	  Field35 = %s,
	  Field36 = %s,
	  Field37 = %s,
	  Field38 = %s,
	  Field39 = %s,
	  Field40 = %s
	  WHERE IDLists = %s", GetSQLValueString($Field[1], "text"), GetSQLValueString($Field[2], "text"), GetSQLValueString($Field[3], "text"), GetSQLValueString($Field[4], "text"), GetSQLValueString($Field[5], "text"), GetSQLValueString($Field[6], "text"), GetSQLValueString($Field[7], "text"), GetSQLValueString($Field[8], "text"), GetSQLValueString($Field[9], "text"), GetSQLValueString($Field[10], "text"), GetSQLValueString($Field[11], "text"), GetSQLValueString($Field[12], "text"), GetSQLValueString($Field[13], "text"), GetSQLValueString($Field[14], "text"), GetSQLValueString($Field[15], "text"), GetSQLValueString($Field[16], "text"), GetSQLValueString($Field[17], "text"), GetSQLValueString($Field[18], "text"), GetSQLValueString($Field[19], "text"), GetSQLValueString($Field[20], "text"), GetSQLValueString($Field[21], "text"), GetSQLValueString($Field[22], "text"), GetSQLValueString($Field[23], "text"), GetSQLValueString($Field[24], "text"), GetSQLValueString($Field[25], "text"), GetSQLValueString($Field[26], "text"), GetSQLValueString($Field[27], "text"), GetSQLValueString($Field[28], "text"), GetSQLValueString($Field[29], "text"), GetSQLValueString($Field[30], "text"), GetSQLValueString($Field[31], "text"), GetSQLValueString($Field[32], "text"), GetSQLValueString($Field[33], "text"), GetSQLValueString($Field[34], "text"), GetSQLValueString($Field[35], "text"), GetSQLValueString($Field[36], "text"), GetSQLValueString($Field[37], "text"), GetSQLValueString($Field[38], "text"), GetSQLValueString($Field[39], "text"), GetSQLValueString($Field[40], "text"), GetSQLValueString($IDLists, "int")
    ));
    if ($update) {
        echo 'okay';
    } else {
        echo "error";
    }
}
?>