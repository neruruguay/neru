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
    $rand = rand(5, 1000);
    $LinkTitle = isset($_POST['LinkTitle']) ? $_POST['LinkTitle'] : 'link' . $rand;
    $Target = isset($_POST['Target']) ? $_POST['Target'] : '_blank';
    $Link = isset($_POST['Link']) ? $_POST['Link'] : 'javascript:void(0);';
    $LinkType = isset($_POST['LinkType']) ? $_POST['LinkType'] : 0;
    $W = isset($_POST['W']) ? $_POST['W'] : '640';
    $H = isset($_POST['H']) ? $_POST['H'] : '480';

    $SID = isset($_POST['SID']) ? $_POST['SID'] : 0;
    $Position = isset($_POST['Position']) ? $_POST['Position'] : 0;
    $Language = isset($_POST['Language']) ? $_POST['Language'] : $defaultLanguage;
    $RenderURL = isset($_POST['RenderURL']) ? $_POST['RenderURL'] : $RenderURL;
    $RenderSubDir = isset($_POST['RenderSubDir']) ? $_POST['RenderSubDir'] : \LOCAL_FILESYSTEM_SECTION;
    $Description = isset($_POST['Description']) ? $_POST['Description'] : '';
    $DisplayOnMenu = isset($_POST['DisplayOnMenu']) ? $_POST['DisplayOnMenu'] : '0';
    $LinkActive = isset($_POST['LinkActive']) ? $_POST['LinkActive'] : 0;
    $css_class = isset($_POST['css_class']) ? $_POST['css_class'] : '';
    $URLName = isset($_POST['URLName']) ? $_POST['URLName'] : 'link' . $rand;

    $insertLink = $SKTDB->query("INSERT INTO " . DB_PREFIX . "links ( LinkTitle, Target, Link, LinkType, W, H, css_class) 
					VALUES (" .
            GetSQLValueString(utf8_decode($LinkTitle), "text") . "," .
            GetSQLValueString($Target, "text") . "," .
            GetSQLValueString($Link, "text") . "," .
            GetSQLValueString($LinkType, "int") . "," .
            GetSQLValueString($W, "int") . "," .
            GetSQLValueString($H, "int") . "," .
            GetSQLValueString($css_class, "text") . ")"
    );
    if ($insertLink) {

        $insertLinkID = $SKTDB->insert_id;

        $insert = $SKTDB->query("INSERT INTO " . DB_PREFIX . "sections (Title, Description, URLName, SID, RecycleBin, SystemRequired, Language, Template, Position, MetaDataTitle, MetaDataDescription, MetaDataKeywords, SearchURLName, DisplayOnMenu, LinkActive, Link_ID ) 

					VALUES (" .
                GetSQLValueString(utf8_decode($LinkTitle), "text") . "," .
                GetSQLValueString('', "text") . "," .
                GetSQLValueString($URLName, "text") . "," .
                GetSQLValueString($SID, "int") . "," .
                GetSQLValueString(0, "text") . "," .
                GetSQLValueString($_POST['SystemRequired'], "int") . "," .
                GetSQLValueString($Language, "text") . "," .
                GetSQLValueString('link', "text") . "," .
                GetSQLValueString($Position, "int") . "," .
                GetSQLValueString('', "text") . "," .
                GetSQLValueString('', "text") . "," .
                GetSQLValueString('', "text") . "," .
                GetSQLValueString('', "text") . "," .
                GetSQLValueString($DisplayOnMenu, "text") . "," .
                GetSQLValueString($LinkActive, "int") . "," .
                GetSQLValueString($insertLinkID, "int") . ")"
        );

        if ($insert) {
            echo 'okay';
        } else {
            echo "error";
        }
    } else {
        echo "error";
    }
}
?>