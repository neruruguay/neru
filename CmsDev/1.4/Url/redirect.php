<?php
$ID = $_GET['ID'];
//echo $ID;
$URLName = $_GET['URLName'];
$URLName = base64_decode(urldecode(utf8_decode($URLName)));
require('_ConfigSite.php');

$redirectRow = $SKTDB->get_row("SELECT uid,clicks FROM redirect WHERE ID = '$ID' AND  URLName = '$URLName' AND HTTP_REFERER = '" . $_SERVER['HTTP_REFERER'] . "' ");

if ($redirectRow) {
    $uid = $redirectRow->uid;
    $clicks = $redirectRow->clicks + 1;
    $redirect = $SKTDB->query("UPDATE redirect SET clicks = '$clicks', date = '" . date('Y-m-d') . "' WHERE uid = '$uid'");
} else {
    $redirect = $SKTDB->query("INSERT INTO redirect (ID, URLName, date, HTTP_REFERER) VALUES ('" . $ID . "','" . $URLName . "','" . date('Y-m-d') . "','" . $_SERVER['HTTP_REFERER'] . "')");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Untitled Document</title>
        <meta http-equiv="refresh" content="0;URL=<?php echo $URLName ?>" />
    </head>

    <body>
    </body>
</html>