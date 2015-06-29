<?php

/**
 * Description of CheckUserName
 *
 * @author Martin Daguerre
 */

namespace CmsDev\util;

class CheckUserName {

    public static function Fix($UserName) {
        $nombre = utf8_decode(trim($UserName));
        $nombre_Nuevo = $UserName;
        $nombre_correcto = str_replace("�", "N", $nombre);
        $nombre_correcto = str_replace("�", "A", $nombre_correcto);
        $nombre_correcto = str_replace("�", "E", $nombre_correcto);
        $nombre_correcto = str_replace("�", "I", $nombre_correcto);
        $nombre_correcto = str_replace("�", "O", $nombre_correcto);
        $nombre_correcto = str_replace("�", "U", $nombre_correcto);
        $nombre_correcto = str_replace("�", "a", $nombre_correcto);
        $nombre_correcto = str_replace("�", "e", $nombre_correcto);
        $nombre_correcto = str_replace("�", "i", $nombre_correcto);
        $nombre_correcto = str_replace("�", "o", $nombre_correcto);
        $nombre_correcto = str_replace("�", "u", $nombre_correcto);
        $nombre_correcto = str_replace(",", "", $nombre_correcto);
        $nombre_correcto = str_replace("(", "", $nombre_correcto);
        $nombre_correcto = str_replace(")", "", $nombre_correcto);
        $nombre_correcto = str_replace("\\", "", $nombre_correcto);
        $nombre_correcto = str_replace("/", "", $nombre_correcto);
        $nombre_correcto = str_replace("`", "", $nombre_correcto);
        $nombre_correcto = str_replace("!", "", $nombre_correcto);
        $nombre_correcto = str_replace("@", "", $nombre_correcto);
        $nombre_correcto = str_replace("�", "n", $nombre_correcto);
        $nombre_correcto = str_replace("$", "", $nombre_correcto);
        $nombre_correcto = str_replace("#", "", $nombre_correcto);
        $nombre_correcto = str_replace("*", "", $nombre_correcto);
        $nombre_correcto = str_replace("=", "", $nombre_correcto);
        $nombre_correcto = str_replace("?", "", $nombre_correcto);
        $nombre_correcto = str_replace("�", "", $nombre_correcto);
        $nombre_correcto = str_replace("�", "", $nombre_correcto);
        $nombre_correcto = str_replace("!", "", $nombre_correcto);
        $nombre_correcto = str_replace("\"", "", $nombre_correcto);
        $nombre_correcto = str_replace("'", "", $nombre_correcto);
        $nombre_correcto = str_replace("&", "y", $nombre_correcto);
        $nombre_correcto = str_replace("[", "", $nombre_correcto);
        $nombre_correcto = str_replace("]", "", $nombre_correcto);
        $nombre_correcto = str_replace("{", "", $nombre_correcto);
        $nombre_correcto = str_replace("}", "", $nombre_correcto);
        $nombre_correcto = str_replace("^", "", $nombre_correcto);
        $nombre_correcto = str_replace("�", "", $nombre_correcto);
        $nombre_correcto = str_replace("<", "", $nombre_correcto);
        $nombre_correcto = str_replace(">", "", $nombre_correcto);
        $nombre_correcto = str_replace(";", "", $nombre_correcto);
        $nombre_correcto = str_replace(":", "", $nombre_correcto);
        $nombre_correcto = str_replace("�", "a", $nombre_correcto);
        $nombre_correcto = str_replace("�", "e", $nombre_correcto);
        $nombre_correcto = str_replace("�", "i", $nombre_correcto);
        $nombre_correcto = str_replace("�", "o", $nombre_correcto);
        $nombre_correcto = str_replace("�", "u", $nombre_correcto);
        $nombre_correcto = str_replace("�", "a", $nombre_correcto);
        $nombre_correcto = str_replace("�", "e", $nombre_correcto);
        $nombre_correcto = str_replace("�", "i", $nombre_correcto);
        $nombre_correcto = str_replace("�", "o", $nombre_correcto);
        $nombre_correcto = str_replace("�", "u", $nombre_correcto);
        $nombre_correcto = str_replace("�", "a", $nombre_correcto);
        $nombre_correcto = str_replace("�", "e", $nombre_correcto);
        $nombre_correcto = str_replace("�", "i", $nombre_correcto);
        $nombre_correcto = str_replace("�", "o", $nombre_correcto);
        $nombre_correcto = str_replace("�", "u", $nombre_correcto);
        $nombre_correcto = str_replace("�", "a", $nombre_correcto);
        $nombre_correcto = str_replace("�", "e", $nombre_correcto);
        $nombre_correcto = str_replace("�", "i", $nombre_correcto);
        $nombre_correcto = str_replace("�", "o", $nombre_correcto);
        $nombre_correcto = str_replace("�", "u", $nombre_correcto);
        $nombre_correcto = str_replace("�", "a", $nombre_correcto);
        $nombre_correcto = str_replace("�", "a", $nombre_correcto);
        $nombre_correcto = str_replace("�", "u", $nombre_correcto);
        $nombre_correcto = str_replace("?", "", $nombre_correcto);
        $nombre_correcto = str_replace("�", "", $nombre_correcto);
        $nombre_correcto = str_replace("+", "", $nombre_correcto);
        $nombre_correcto = str_replace("�", "c", $nombre_correcto);
        $nombre_correcto = str_replace("�", "c", $nombre_correcto);
        $nombre_correcto = str_replace("�", "", $nombre_correcto);
        $nombre_correcto = str_replace(" ", "_", $nombre_correcto);
        $nombre_correcto = str_replace(".", "", $nombre_correcto);
        $nombre_Nuevo = utf8_decode($nombre_correcto);
        return $nombre_Nuevo;
    }

}

?>
