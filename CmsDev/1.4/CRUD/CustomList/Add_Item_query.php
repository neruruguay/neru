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

function array2json($arr) {
    //if(function_exists('json_encode')) return json_encode($arr); //Lastest versions of PHP already has this functionality.
    $parts = array();
    $is_list = false;
    //Find out if the given array is a numerical array
    $keys = array_keys($arr);
    $max_length = count($arr) - 1;
    if (($keys[0] == 0) and ( $keys[$max_length] == $max_length)) {//See if the first key is 0 and last key is length - 1
        $is_list = true;
        for ($i = 0; $i < count($keys); $i++) { //See if each key correspondes to its position
            if ($i != $keys[$i]) { //A key fails at position check.
                $is_list = false; //It is an associative array.
                break;
            }
        }
    }

    foreach ($arr as $key => $value) {
        if (is_array($value)) { //Custom handling for arrays
            if ($is_list)
                $parts[] = array2json($value); /* :RECURSION: */
            else
                $parts[] = '"' . $key . '":' . array2json($value); /* :RECURSION: */
        } else {
            $str = '';
            if (!$is_list)
                $str = '"' . $key . '":';

            //Custom handling for multiple data types
            if (is_numeric($value))
                $str .= $value; //Numbers
            elseif ($value === false)
                $str .= 'false'; //The booleans
            elseif ($value === true)
                $str .= 'true';
            else
                $str .= '"' . addslashes($value) . '"'; //All other things

            $parts[] = $str;
        }
    }
    $json = implode(',', $parts);

    if ($is_list)
        return '[' . $json . ']'; //Return numerical JSON
    return '{' . $json . '}'; //Return associative JSON
}

//if (\CmsDev\Security\loginIntent::action('validate') === true) {

$glob = \CmsDev\util\globals::init();
$SKT = $glob->getVar('SKT');
$SKT_ADMIN = $glob->getVar('SKTADMIN');
$SKTListFieldType = $glob->getVar('SKTListFieldType');
$SKTListFieldSize = $glob->getVar('SKTListFieldSize');


$RecycleBin = isset($_POST['RecycleBin']) ? $_POST['RecycleBin'] : '0';
if ($RecycleBin == '') {
    $RecycleBin = 0;
} else {
    $RecycleBin = 1;
}

$Order = isset($_POST['Order']) ? $_POST['Order'] : '0';
$datePost = isset($_POST['datePost']) ? $_POST['datePost'] : date('Y-m-d');

$AUTO_INCREMENT = $SKTDB->get_var("SELECT MAX(ID)+1 AS IDMAX FROM lists_values ");
if ($AUTO_INCREMENT == '' or $AUTO_INCREMENT == 'null') {
    $AUTO_INCREMENT = 0;
}
$Value = array();
$Value['ID'] = $AUTO_INCREMENT;
$Value['IDLists'] = $_POST['IDLists'];
$Value['RecycleBin'] = $RecycleBin;
$Value['Position'] = $Order;
$Value['datePost'] = $datePost;
$Lists_Fields = $SKTDB->get_row("SELECT * FROM lists_fields WHERE IDLists = '$_POST[IDLists]'");

for ($i = 1; $i < $SKTListFieldSize + 1; $i++) {
    $x = 'Field' . $i;
    if ($Lists_Fields->$x != '') {
        $xTypeName = $Lists_Fields->$x;
        $xName = \explode('|', $xTypeName);
        $content = trim($_POST[utf8_decode($x)]);
        $sustituye = array("\r\n", "\n\r", "\n", "\r", "\t", "\x0B", "\0");
        $content1 = \str_replace($sustituye, "", $content);

        $Value[\utf8_decode($xName[1])] = $content1;
    }
}


$encodedArray = array2json($Value);

$Query_Lists = $SKTDB->query("INSERT INTO lists_values (IDList,Value,RecycleBin,Position,datePost)
 	VALUES (" .
        GetSQLValueString($_POST['IDLists'], "int") . "," .
        GetSQLValueString($encodedArray, "text") . "," .
        GetSQLValueString($RecycleBin, "int") . "," .
        GetSQLValueString($Order, "int") . "," .
        GetSQLValueString($datePost, "date") . ")"
);


if ($Query_Lists) {
    echo $_POST['IDLists'] . '|okay';
} else {
    echo "error";
}
?>
