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
$SKTDB = \CmsDev\sql\db_Skt::connect();
if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {

    $Language = isset($_POST['Language']) ? $_POST['Language'] : 'esp';

    $RenderURL = isset($_POST['RenderURL']) ? $_POST['RenderURL'] : $RenderURL;

    $RenderSubDir = isset($_POST['RenderSubDir']) ? $_POST['RenderSubDir'] : \LOCAL_FILESYSTEM_SECTION;

    $Description = isset($_POST['Description']) ? $_POST['Description'] : '';

    $DisplayOnMenu = isset($_POST['DisplayOnMenu']) ? $_POST['DisplayOnMenu'] : 1;

    $LinkActive = isset($_POST['LinkActive']) ? $_POST['LinkActive'] : 0;

    $NewsDescriptionHTML = isset($_POST['NewsDescriptionHTML']) ? $_POST['NewsDescriptionHTML'] : '';

    $insert = $SKTDB->query("INSERT INTO " . DB_PREFIX . "sections (Title, Description, URLName, SID, RecycleBin, SystemRequired, Language, Template, Position, MetaDataTitle, MetaDataDescription, MetaDataKeywords, SearchURLName, DisplayOnMenu, LinkActive ) 

					VALUES (" .
            GetSQLValueString(utf8_decode($_POST['Title']), "text") . "," .
            GetSQLValueString(utf8_decode($_POST['MetaDataDescription']), "text") . "," .
            GetSQLValueString($_POST['URLName'], "text") . "," .
            GetSQLValueString($_POST['SID'], "int") . "," .
            GetSQLValueString($_POST['RecycleBin'], "text") . "," .
            GetSQLValueString($_POST['SystemRequired'], "int") . "," .
            GetSQLValueString($_POST['Language'], "text") . "," .
            GetSQLValueString($_POST['Template'], "text") . "," .
            GetSQLValueString($_POST['Position'], "int") . "," .
            GetSQLValueString(utf8_decode($_POST['Title']), "text") . "," .
            GetSQLValueString(utf8_decode($_POST['MetaDataDescription']), "text") . "," .
            GetSQLValueString(utf8_decode($_POST['MetaDataKeywords']), "text") . "," .
            GetSQLValueString(utf8_decode($_POST['SearchURLName']), "text") . "," .
            GetSQLValueString($DisplayOnMenu, "text") . "," .
            GetSQLValueString($LinkActive, "text") . ")"
    );

    if ($insert) {

        echo 'okay';

        $old = umask(0077);

        $SectionDir = \LOCAL_FILESYSTEM_SECTION;

        $RenderURL = $RenderURL;

        if (!file_exists($SectionDir . '/' . $_POST['URLName'])) {

            mkdir($SectionDir . '/' . $_POST['URLName'], 0777, true);

            chmod($SectionDir . '/' . $_POST['URLName'], 0777);

            umask($old);
        }







        $id = $SKTDB->insert_id;

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
                GetSQLValueString($id, "int") . "," .
                GetSQLValueString(0, "int") . "," .
                GetSQLValueString("Noticias.Detalle", "text") . "," .
                GetSQLValueString("html", "text") . "," .
                GetSQLValueString("", "text") . "," .
                GetSQLValueString("", "text") . "," .
                GetSQLValueString($NewsDescriptionHTML, "text") . "," .
                GetSQLValueString(date('y-m-d'), "date") . "," .
                GetSQLValueString(0, "int") . "," .
                GetSQLValueString(0, "int") . "," .
                GetSQLValueString("", "text") . "," .
                GetSQLValueString("", "text") . "," .
                GetSQLValueString("", "text") . "," .
                GetSQLValueString($FileNewFileX, "text") . "," .
                GetSQLValueString($FileNewFileY, "text") . "," .
                GetSQLValueString($CCFromTemplate, "text") . "," .
                GetSQLValueString($Autor, "text") . ")"
        );
    } else {

        echo "error" . $SectionDir . '/' . $_POST['URLName'];
    }
}
?>