<?php

/**
 * Description of skt_Decode
 *
 * @author Martin
 */

namespace CmsDev;

class skt_Code {

    public static function RemoveBreakLine($str) {
        return preg_replace('/[\n\r\t]/', ' ', preg_replace('/\s(?=\s)/', '', trim($str)));
    }

    public static function Encode($str) {
        $string = trim($str, '%3D');
        return \urlencode(\base64_encode(\utf8_encode($string)));
    }

    public static function Decode($str) {
        $string = str_replace('%3D', '', \base64_decode(\urldecode(\utf8_decode($str))));
        return trim($string, '%3D');
    }

    public static function RemoveLocalFS($str) {
        return \str_replace(\LOCAL_FILESYSTEM, '', $str);
    }

    public static function AddLocalFS($str) {
        return \LOCAL_FILESYSTEM . $str;
    }

    public static function AddSlashURL($str) {
        $strFix = trim($str, '/');
        $AddSlash = '/' . $strFix . '/';
        return $AddSlash;
    }

    public static function Charset($str) {
        $Set = mb_detect_encoding($str, 'Windows-1252, ISO-8859-1, utf-8', true);
        return mb_convert_encoding($str, 'Windows-1252');
    }

    public static function Parse_Template($find = array(), $Template = 'Template not found!') {
        foreach ($find as $Field => $Value) {
            $Template = str_replace('['.$Field.']', $Value, $Template);
        }
        return $Template;
    }

}

?>
