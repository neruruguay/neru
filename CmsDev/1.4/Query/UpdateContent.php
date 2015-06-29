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

    function ConvertSimbols($var) {
        $var = str_replace('\"', '"', $var);
        $var = str_replace("\'", "'", $var);
        return html_entity_decode($var, ENT_QUOTES);
    }

    $ID = $_POST['ID'];
    $c = $SKTDB->get_row("SELECT * FROM " . DB_PREFIX . "content WHERE ID = '$ID'");

    if (isset($_POST['editor'])) {
        $Content = $_POST['editor'];
    } else {
        $Content = $c->Content;
    }

    if (isset($_POST['Date'])) {
        $Date = $_POST['Date'];
    } else {
        $Date = $c->Date;
    }

    if (isset($_POST['IDZone'])) {
        $IDZone = $_POST['IDZone'];
    } else {
        $IDZone = $c->IDZone;
    }

    if (isset($_POST['IDPage'])) {
        $IDPage = $_POST['IDPage'];
    } else {
        $IDPage = $c->IDPage;
    }

    if (isset($_POST['Custom'])) {
        $Custom = $_POST['Custom'];
    } else {
        $Custom = $c->Custom;
    }

    if (isset($_POST['Type'])) {
        $Type = $_POST['Type'];
    } else {
        $Type = $c->Type;
    }

    if (isset($_POST['AllPage'])) {
        $AllPage = $_POST['AllPage'];
    } else {
        $AllPage = $c->AllPage;
    }

    if (isset($_POST['RecycleBin'])) {
        $RecycleBin = $_POST['RecycleBin'];
    } else {
        $RecycleBin = $c->RecycleBin;
    }

    if (isset($_POST['Position'])) {
        $Position = $_POST['Position'];
    } else {
        $Position = $c->Position;
    }

    if (isset($_POST['Title'])) {
        $Title = $_POST['Title'];
    } else {
        $Title = $c->Title;
    }

    if (isset($_POST['Description'])) {
        $Description = $_POST['Description'];
    } else {
        $Description = $c->Description;
    }

    if (isset($_POST['css_class'])) {
        $css_class = $_POST['css_class'];
    } else {
        $css_class = $c->css_class;
    }

    if (isset($_POST['CustomProperty'])) {
        $CustomProperty = $_POST['CustomProperty'];
    } else {
        $CustomProperty = $c->CustomProperty;
    }

    $X = isset($_POST['FileNewFileX']) ? $_POST['FileNewFileX'] : '960';

    $Y = isset($_POST['FileNewFileY']) ? $_POST['FileNewFileY'] : '230';

    $CCFromTemplate = isset($_POST['CCFromTemplate']) ? $_POST['CCFromTemplate'] : '';

    if (isset($_POST['Autor'])) {
        $Autor = $_POST['Autor'];
    } else {
        $Autor = $c->Autor;
    }

// 	ID	IDPage	AllPage	IDZone	Type	Title	Description	Content	Date	RecycleBin	Position	Custom	css_class	CustomProperty



    $update = $SKTDB->query(sprintf("UPDATE " . DB_PREFIX . "content Set 

					Content = %s,

					Date = %s, 

					IDZone = %s, 

					IDPage = %s,

					Custom = %s,

					Type = %s,

					AllPage = %s,

					RecycleBin = %s,

					Position = %s,

					Title = %s,

					Description = %s,

					CustomProperty = %s,

					css_class = %s,
					
					X = %s,
					
					Y = %s,
					
					CCFromTemplate = %s,
					
					Autor = %s

					WHERE ID = %s", GetSQLValueString($Content, "text"), GetSQLValueString($Date, "date"), GetSQLValueString($IDZone, "text"), GetSQLValueString($IDPage, "int"), GetSQLValueString($Custom, "text"), GetSQLValueString($Type, "text"), GetSQLValueString($AllPage, "int"), GetSQLValueString($RecycleBin, "int"), GetSQLValueString($Position, "int"), GetSQLValueString($Title, "text"), GetSQLValueString($Description, "text"), GetSQLValueString($CustomProperty, "text"), GetSQLValueString($css_class, "text"), GetSQLValueString($X, "text"), GetSQLValueString($Y, "text"), GetSQLValueString($CCFromTemplate, "text"), GetSQLValueString($Autor, "text"), GetSQLValueString($ID, "int")
    ));



    if ($update) {

        if ($Type != 'SKT_Controls' && $Type != 'Photo' && $Type != 'Note') {

            echo ConvertSimbols($Content);
        }

        echo 'okay';
    } else {

        echo "error";
    }
}
?>