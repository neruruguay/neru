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

    $Title = isset($_POST['Title']) ? $_POST['Title'] : FALSE;
    $Description = isset($_POST['Description']) ? $_POST['Description'] : '';
    $URLName = isset($_POST['URLName']) ? $_POST['URLName'] : FALSE;
    $SID = isset($_POST['SID']) ? $_POST['SID'] : FALSE;
    $RecycleBin = isset($_POST['RecycleBin']) ? $_POST['RecycleBin'] : 1;
    $SystemRequired = isset($_POST['SystemRequired']) ? $_POST['SystemRequired'] : 1;
    $Language = isset($_POST['Language']) ? $_POST['Language'] : FALSE;
    $Template = isset($_POST['Template']) ? $_POST['Template'] : FALSE;
    $Position = isset($_POST['Position']) ? $_POST['Position'] : 1;
    $MetaDataTitle = isset($_POST['MetaDataTitle']) ? $_POST['MetaDataTitle'] : '';
    $MetaDataDescription = isset($_POST['MetaDataDescription']) ? $_POST['MetaDataDescription'] : '';
    $MetaDataKeywords = isset($_POST['MetaDataKeywords']) ? $_POST['MetaDataKeywords'] : '';
    $SearchURLName = isset($_POST['SearchURLName']) ? $_POST['SearchURLName'] : $URLName;
    $DisplayOnMenu = isset($_POST['DisplayOnMenu']) ? $_POST['DisplayOnMenu'] : 1;
    $LinkActive = isset($_POST['LinkActive']) ? $_POST['LinkActive'] : 1;

    $RenderURL = isset($_POST['RenderURL']) ? $_POST['RenderURL'] : $RenderURL;
    $RenderSubDir = isset($_POST['RenderSubDir']) ? $_POST['RenderSubDir'] : \LOCAL_FILESYSTEM_SECTION;

    if ($Title === FALSE || $URLName === FALSE || $SID === FALSE || $Language === FALSE || $Template === FALSE) {
        echo 'error';
        exit();
    } else {
        $insert = $SKTDB->query("INSERT INTO " . DB_PREFIX . "sections (Title, Description, URLName, SID, RecycleBin, SystemRequired, Language, Template, Position, MetaDataTitle, MetaDataDescription, MetaDataKeywords, SearchURLName, DisplayOnMenu, LinkActive ) 
            VALUES (" .
                GetSQLValueString($Title, "text") . "," .
                GetSQLValueString($Description, "text") . "," .
                GetSQLValueString($URLName, "text") . "," .
                GetSQLValueString($SID, "int") . "," .
                GetSQLValueString($RecycleBin, "int") . "," .
                GetSQLValueString($SystemRequired, "int") . "," .
                GetSQLValueString($Language, "text") . "," .
                GetSQLValueString($Template, "text") . "," .
                GetSQLValueString($Position, "int") . "," .
                GetSQLValueString($MetaDataTitle, "text") . "," .
                GetSQLValueString($MetaDataDescription, "text") . "," .
                GetSQLValueString($MetaDataKeywords, "text") . "," .
                GetSQLValueString($SearchURLName, "text") . "," .
                GetSQLValueString($DisplayOnMenu, "text") . "," .
                GetSQLValueString($LinkActive, "int") . ")"
        );
        if ($insert) {
            echo 'okay';
            $old = umask(0077);
            $SectionDir = \LOCAL_FILESYSTEM_SECTION;
            if (!file_exists($SectionDir . '/' . $URLName)) {
                mkdir($SectionDir . '/' . $URLName, 0777, true);
                chmod($SectionDir . '/' . $URLName, 0777);
                umask($old);
            }
        } else {
            echo "error" . $SectionDir . '/' . $URLName;
        }
    }
}
?>