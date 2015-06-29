<?php

function uencsec($e) {
    return urlencode(base64_encode(utf8_encode($e)));
}

function ludecsec($e) {
    return base64_decode(urldecode(utf8_decode($e)));
}

/* ----------------------------- */
$URL = '';
$URLReal = '';
require (dirname(__FILE__) . DIRECTORY_SEPARATOR . 'DefinePath.php');
$VERSION = \SKT_VERSION;
echo $VERSION;

if (isset($_GET['URL']) && $_GET['URL'] != '') {
    $URL = uencsec($_GET['URL']);
    $URLReal = $_GET['URL'];
}

if (isset($_GET['Ucheck']) && $_GET['Ucheck'] != '') {
    $e = str_replace('[VERSION]', $VERSION, ludecsec($_GET['Ucheck']));
    //include($e . '.php');
    echo 'Ucheck = ' . $e . '.php<br /><br />';
}
if (isset($_GET['i']) && $_GET['i'] != '') {
    $e = ludecsec($_GET['i']);
    //include($e);
    echo 'i = ' . $e . '<br /><br /><br />';

    echo 'Decripted = ' . ludecsec($_GET['i']) . '<br /><br /><br />';
}
?>
<form method="GET">
    <fieldset><legend>Escribe la dirección para generar el string</legend>
        <label>URL</label>
        <input value="" name="URL" type="text" style="width: 550px; display: block;">
        <br />
        <input value="Enviar" type="submit">
    </fieldset>
</form>
<form method="GET">
    <fieldset><legend>Realizar test</legend>
        <label>( para archivos .php en la carpeta 'inc' ) No incluir ruta ni extensión</label>
        <input value="<?php echo $URL ?>" name="Ucheck" type="text" style="width: 550px; display: block;">
        <br />
        <label>( ruta/nombre del un archivo x)</label>
        <input value="<?php echo $URL ?>" name="i" type="text" style="width: 550px; display: block;">
        <br />
        <input value="Enviar" type="submit">
    </fieldset>
</form>