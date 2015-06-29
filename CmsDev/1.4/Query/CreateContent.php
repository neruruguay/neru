<?php

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

// Description, css_class

    $Description = isset($_POST['Description']) ? $_POST['Description'] : '';

    $CreateContentEditor = isset($_POST['CreateContentEditor']) ? $_POST['CreateContentEditor'] : '';

    $css_class = isset($_POST['css_class']) ? $_POST['css_class'] : '';

    $CustomProperty = isset($_POST['CustomProperty']) ? $_POST['CustomProperty'] : '';

    $Autor = isset($_POST['Autor']) ? $_POST['Autor'] : '';

    $FileNewFileX = isset($_POST['FileNewFileX']) ? $_POST['FileNewFileX'] : '960';

    $FileNewFileY = isset($_POST['FileNewFileY']) ? $_POST['FileNewFileY'] : '230';

    $CCFromTemplate = isset($_POST['CCFromTemplate']) ? $_POST['CCFromTemplate'] : '';

    $insert = $SKTDB->query("INSERT INTO " . DB_PREFIX . "content (IDPage, AllPage, IDZone, Type, Title, Description, Content, Date, RecycleBin, Position, Custom, css_class, CustomProperty, X, Y, CCFromTemplate, Autor) 

					VALUES (" .
            GetSQLValueString($_POST['IDPage'], "int") . "," .
            GetSQLValueString($_POST['AllPage'], "int") . "," .
            GetSQLValueString($_POST['IDZone'], "text") . "," .
            GetSQLValueString($_POST['Type'], "text") . "," .
            GetSQLValueString($_POST['Title'], "text") . "," .
            GetSQLValueString($Description, "text") . "," .
            GetSQLValueString(utf8_decode($CreateContentEditor), "text") . "," .
            GetSQLValueString($_POST['Date'], "date") . "," .
            GetSQLValueString($_POST['RecycleBin'], "int") . "," .
            GetSQLValueString($_POST['Position'], "int") . "," .
            GetSQLValueString($_POST['Custom'], "text") . "," .
            GetSQLValueString($css_class, "text") . "," .
            GetSQLValueString($CustomProperty, "text") . "," .
            GetSQLValueString($FileNewFileX, "text") . "," .
            GetSQLValueString($FileNewFileY, "text") . "," .
            GetSQLValueString($CCFromTemplate, "text") . "," .
            GetSQLValueString($Autor, "text") . ")"
    );

    if ($insert) {

        echo 'okay';
    } else {

        echo "error";
    }
}
?>