<?php

function _iscurlinstalled() {
    if (in_array('curl', get_loaded_extensions())) {
        return true;
    } else {
        return false;
    }
}

function DIR_SEPARATOR($file) {
    $ds = DIRECTORY_SEPARATOR;
    $fileFix = strtr($file, '\\', $ds);
    return $fileFix;
}

function randomId() {
    $seed = str_split('abcdefghijklmnopqrstuvwxyz'
            . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
    //.'0123456789!@#$%^&*()'); // and any other characters
    shuffle($seed); // probably optional since array_is randomized; this may be redundant
    $rand = '';
    foreach (array_rand($seed, 10) as $k) {
        $rand .= $seed[$k];
    }
    return md5($rand);
}

/**
 * Clean comments of json content and decode it with json_decode().
 * Work like the original php json_decode() function with the same params
 *
 * @param   string  $json    The json string being decoded
 * @param   bool    $assoc   When TRUE, returned objects will be converted into associative arrays.
 * @param   integer $depth   User specified recursion depth. (>=5.3)
 * @param   integer $options Bitmask of JSON decode options. (>=5.4)
 * @return  string
 */
function json_clean_decode($json, $assoc = false, $depth = 512, $options = 0) {

    // search and remove comments like /* */ and //
    $json = preg_replace("#(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|([\s\t](//).*)#", '', $json);

    if (version_compare(phpversion(), '5.4.0', '>=')) {
        $json = json_decode($json, $assoc, $depth, $options);
    } elseif (version_compare(phpversion(), '5.3.0', '>=')) {
        $json = json_decode($json, $assoc, $depth);
    } else {
        $json = json_decode($json, $assoc);
    }

    return $json;
}

function isValidJson($strJson) {
    json_decode($strJson);
    return (json_last_error() === JSON_ERROR_NONE);
}

//
////////////////////////////////////////////////////////////////////////////////////
//
function SKTImageURL($Image = 'dummy.png', $W = '', $H = '', $C = '') {
    if ($W !== '') {
        $W = '?' . $W;
    }
    if ($H !== '') {
        $H = 'x' . $H;
    }
    if ($C !== '') {
        $C = '-' . $C;
    }
    echo '/_FileSystems/_thumb_/?/' . str_replace('%3D', '', urlencode(base64_encode(utf8_encode($Image)))) . $W . $H . $C;
}

//
////////////////////////////////////////////////////////////////////////////////////
//
function admd($e) {
    return base64_decode(urldecode(utf8_decode($e)));
}

function SKTreplaceTags($Tag, $newText, $source, $removeTag = 0) {
    $Tag = '<' . $Tag . '>';
    $endTag = '</' . $Tag . '>';
    $preHTML = preg_replace('#(' . preg_quote($Tag) . ')(.*)(' . preg_quote($endTag) . ')#si', $newText, $source);
    if ($removeTag !== 0) {
        $r1 = \str_replace($Tag, '', $preHTML);
        $r2 = \str_replace($endTag, '', $r1);
        $preHTML = $r2;
    }
    return $preHTML;
}

//
////////////////////////////////////////////////////////////////////////////////////
//
function SKTremoveTags($Tag, $source) {
    $endTag = '</' . $Tag . '>';
    $Tag = '<' . $Tag . '>';
    return preg_replace('#(' . preg_quote($Tag) . ')(.*)(' . preg_quote($endTag) . ')#si', '', $source);
}

//
////////////////////////////////////////////////////////////////////////////////////
//
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
    if (PHP_VERSION < 6) {
        $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
    }

    $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

    switch ($theType) {
        case "text":
            $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
            break;
        case "long":
        case "int":
            $theValue = ($theValue != "") ? intval($theValue) : "NULL";
            break;
        case "double":
            $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
            break;
        case "date":
            $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
            break;
        case "defined":
            $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
            break;
    }
    return $theValue;
}

//
////////////////////////////////////////////////////////////////////////////////////
//
function BRtoN($str) {
    $str = str_replace(array('<br>', '<br >', '<br />'), '\n', $str);
    return $str;
}

//
////////////////////////////////////////////////////////////////////////////////////
//
function NtoBR($str) {
    $str = str_replace(array("\n", "\r"), "<br />", $str);
    return $str;
}

//
////////////////////////////////////////////////////////////////////////////////////
//
/* ---   DATA IN FILE  --- */
function DataTag($file, $Require) {
    $DataTag = new \CmsDev\AdminFilesystem\Metadata();
    return $DataTag->data($file, $Require);
}

//
////////////////////////////////////////////////////////////////////////////////////
//
function REQUEST_URI($element) {
    $REQUEST_URI_exist = \SKTURL_REQUEST_PARAMS;
    if ($REQUEST_URI_exist) {
        $REQUEST_URI_Elements_Element = explode('&', $REQUEST_URI_exist);
        foreach ($REQUEST_URI_Elements_Element as $E) {
            $conjunto = explode('=', $E);
            $N = $conjunto[0];
            $V = $conjunto[1];
            if ($element == $N) {
                return $V;
            } else {
                return '';
            }
        }
    }

//
////////////////////////////////////////////////////////////////////////////////////
//
    function format_Decimal($value) {
        $formatted = number_format($value, 2, '.', '');
        return $formatted;
    }

//
////////////////////////////////////////////////////////////////////////////////////
//
    function format_value($value) {
        $formatted = number_format($value, 2, ",", ".");
        return $formatted;
    }

    $SKTListFieldType = array(
        "int" => '0',
        "varchar" => '1',
        "text" => '2',
        "link" => '3',
        "enum" => '4',
        "html" => '5',
        "Basic html" => '7',
        "date" => '6'
    );
}

//
////////////////////////////////////////////////////////////////////////////////////
//
function CheckAbstract($titulo) {
    $nombre = utf8_encode($titulo);
    $nombre_correcto = str_replace("N", "&Ntilde;", $nombre);
    $nombre_correcto = str_replace("ñ", "&ntilde;", $nombre_correcto);
    $nombre_correcto = str_replace("Á", "&Aacute;", $nombre_correcto);
    $nombre_correcto = str_replace("É", "&Eacute;", $nombre_correcto);
    $nombre_correcto = str_replace("Í", "&Iacute;", $nombre_correcto);
    $nombre_correcto = str_replace("Ó", "&Oacute;", $nombre_correcto);
    $nombre_correcto = str_replace("Ú", "&Uacute;", $nombre_correcto);
    $nombre_correcto = str_replace("á", "&aacute;", $nombre_correcto);
    $nombre_correcto = str_replace("é", "&eacute;", $nombre_correcto);
    $nombre_correcto = str_replace("í", "&iacute;", $nombre_correcto);
    $nombre_correcto = str_replace("ó", "&oacute;", $nombre_correcto);
    $nombre_correcto = str_replace("ú", "&uacute;", $nombre_correcto);
    $nombre_correcto = str_replace(",", "", $nombre_correcto);
    $nombre_correcto = str_replace("(", " ", $nombre_correcto);
    $nombre_correcto = str_replace(")", " ", $nombre_correcto);
    $nombre_correcto = str_replace("\"", " ", $nombre_correcto);
    $nombre_correcto = str_replace("/", " ", $nombre_correcto);
    $nombre_correcto = str_replace("`", "", $nombre_correcto);
    $nombre_correcto = str_replace("!", "", $nombre_correcto);
    $nombre_correcto = str_replace("@", "", $nombre_correcto);
    $nombre_correcto = str_replace("$", "s", $nombre_correcto);
    $nombre_correcto = str_replace("&", "", $nombre_correcto);
    $nombre_Nuevo = utf8_decode($nombre_correcto);

    return $nombre_Nuevo;
}

//
////////////////////////////////////////////////////////////////////////////////////
//

function soloMostrar($string, $cantidad, $puntos = '...') {

    $count = 0;

    for ($i = 0; $i < strlen($string); $i++) {

        if ($count < $cantidad) {



            ord($string[$i]);

            echo $string[$i];
        }

        $count++;
    }

    if (strlen($string) > $cantidad) {

        echo $puntos;
    }
}

//
////////////////////////////////////////////////////////////////////////////////////
//
function cut_string($string, $charlimit) {
    if (strlen($string) > $charlimit) {
        $string = substr($string, '0', $charlimit);
        $array = explode(' ', $string);
        array_pop($array);
        $new_string = implode(' ', $array);

        return $new_string . '...';
    } else {
        return $string;
    }
}

//
////////////////////////////////////////////////////////////////////////////////////
//
function email_validate($email) {
    $regex = '/([a-z0-9_.-]+)' . # name
            '@' . # at
            '([a-z0-9.-]+){2,255}' . # domain & possibly subdomains
            '.' . # period
            '([a-z]+){2,10}/i'; # domain extension

    if ($email === '') {
        return false;
    } else {
        $eregi = preg_replace($regex, '', $email);
    }

    return empty($eregi) ? true : false;
}

function invertirFecha($fecha) {

    $fecha = substr($fecha, 0, 10);
    $fecha = implode("/", array_reverse(preg_split("/\D/", $fecha)));

    return str_replace("/", "-", $fecha);
}

//
////////////////////////////////////////////////////////////////////////////////////
//

function invertirFechaSoloDiaMes($fecha) {

    $fecha = implode("/", array_reverse(preg_split("/\D/", $fecha)));



    list($dia, $mes, $ano) = split('[/.-]', $fecha);



    return $dia . ' - ' . $mes;
}

//
////////////////////////////////////////////////////////////////////////////////////
//


function redondear($valor) {

    $float_redondeado = round($valor * 100) / 100;

    return $float_redondeado;
}

//
////////////////////////////////////////////////////////////////////////////////////
//
function redondearDos($valor) {

    $float_redondeado = round($valor * 100) / 100;

    return $float_redondeado;
}

//
////////////////////////////////////////////////////////////////////////////////////
//
function editar_textarea($str) {

    return str_replace(array('<br>', '<br >', '<br />'), '\n', $str);
}

//
////////////////////////////////////////////////////////////////////////////////////
//
function mostrar_textarea($str) {

    $str = str_replace(array("\n"), "<br />", $str);



    $car = 60;

    if (strlen($str) > $car && ObtenerNavegador($_SERVER['HTTP_USER_AGENT']) == 'Mozilla Firefox') {

        $str = wordwrap($str, $car, "<br />", 1);
    }



    return $str;
}

//
////////////////////////////////////////////////////////////////////////////////////
//
function create_htmloption($a, $select = '') {

    $formatedarray = '';
    foreach ($a as $k => $v) {
        if ($select == $v) {
            $formatedarray.= "<option value=\"$v\" selected=\"selected\">$k</option>";
        } else {
            $formatedarray.= "<option value=\"$v\">$k</option>";
        }
    }
    return $formatedarray;
}

//
////////////////////////////////////////////////////////////////////////////////////
//
function select_field($name, $id, $passarray, $select = '') {

    $optionarray = create_htmloption($passarray, $select);
    $fieldinfo = "
	<select name=\"$name\" id=\"$id\"  style=\"width: 100%; max-width: 100%;\"  class=\"form-control\">
	 $optionarray
	</select>
	";
    return $fieldinfo;
}

//
////////////////////////////////////////////////////////////////////////////////////
//
function uencsec($e) {
    return urlencode(base64_encode(utf8_encode($e)));
}

//
////////////////////////////////////////////////////////////////////////////////////
//
function luencsec($e) {
    return urlencode(base64_encode(utf8_encode($e)));
}

//
////////////////////////////////////////////////////////////////////////////////////
//
function ludecsec($e) {
    return base64_decode(urldecode(utf8_decode($e)));
}

//
////////////////////////////////////////////////////////////////////////////////////
//
function CorrectURL($str) {
    $str = str_replace(array('CRUD/'), '', $str);
    $str = str_replace(array('/Query'), '', $str);
    $str = str_replace(array('/fileuploader'), '', $str);
    $str = str_replace(array('/AdminFilesystem'), '', $str);
    $str = str_replace(array('//'), '/', $str);
    return $str;
}

//
////////////////////////////////////////////////////////////////////////////////////
//
function getBrowser() {
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version = '';
    $ub = 'Unknown';
    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'ie';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'firefox';
        $ub = "Firefox";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'safari';
        $ub = "Safari";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'opera';
        $ub = "Opera";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'netscape';
        $ub = "Netscape";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version = $matches['version'][0];
        } else {
            $version = $matches['version'][1];
        }
    } else {
        $version = $matches['version'][0];
    }

    // check if we have a number
    if ($version == null || $version == "") {
        $version = "?";
    }

    return array(
        'userAgent' => $u_agent,
        'name' => $bname,
        'version' => $version,
        'platform' => $platform,
        'pattern' => $pattern
    );
}

?>
