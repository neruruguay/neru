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
    $ID = $_POST['ID'];

    $LinkTitle = isset($_POST['LinkTitle']) ? $_POST['LinkTitle'] : 'link' . $rand;
    $Target = isset($_POST['Target']) ? $_POST['Target'] : '_blank';
    $Link = isset($_POST['Link']) ? $_POST['Link'] : 'javascript:void(0);';
    $LinkType = isset($_POST['LinkType']) ? $_POST['LinkType'] : 0;
    $W = isset($_POST['W']) ? $_POST['W'] : '640';
    $H = isset($_POST['H']) ? $_POST['H'] : '480';

    $SID = isset($_POST['SID']) ? $_POST['SID'] : 0;
    $Position = isset($_POST['Position']) ? $_POST['Position'] : 0;
    $DisplayOnMenu = isset($_POST['DisplayOnMenu']) ? $_POST['DisplayOnMenu'] : '1';
    $LinkActive = isset($_POST['LinkActive']) ? $_POST['LinkActive'] : 0;
    $css_class = isset($_POST['css_class']) ? $_POST['css_class'] : '';
    $URLName = isset($_POST['URLName']) ? $_POST['URLName'] : 'link' . $rand;

    $UPDATELink = $SKTDB->query(sprintf("UPDATE " . DB_PREFIX . "links 
					Set LinkTitle = %s, Target = %s, Link = %s, LinkType = %s, W = %s, H = %s, css_class = %s WHERE ID = %s", GetSQLValueString(utf8_decode($LinkTitle), "text"), GetSQLValueString($Target, "text"), GetSQLValueString($Link, "text"), GetSQLValueString($LinkType, "int"), GetSQLValueString($W, "int"), GetSQLValueString($H, "int"), GetSQLValueString($css_class, "text"), GetSQLValueString($ID, "int")
    ));
    if ($UPDATELink) {

        $UPDATE = $SKTDB->query(sprintf("UPDATE " . DB_PREFIX . "sections 
					Set Title = %s, URLName = %s, Position = %s, DisplayOnMenu = %s  WHERE Link_ID = %s", GetSQLValueString(utf8_decode($LinkTitle), "text"), GetSQLValueString($URLName, "text"), GetSQLValueString($Position, "int"), GetSQLValueString($DisplayOnMenu, "text"), GetSQLValueString($ID, "int")
        ));

        if ($UPDATE) {
            echo 'okay';
        } else {
            echo "error";
        }
    } else {
        echo "error";
    }
}
?>