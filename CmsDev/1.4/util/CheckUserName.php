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
        $nombre_correcto = str_replace("Ñ", "N", $nombre);
        $nombre_correcto = str_replace("Á", "A", $nombre_correcto);
        $nombre_correcto = str_replace("É", "E", $nombre_correcto);
        $nombre_correcto = str_replace("Í", "I", $nombre_correcto);
        $nombre_correcto = str_replace("Ó", "O", $nombre_correcto);
        $nombre_correcto = str_replace("Ú", "U", $nombre_correcto);
        $nombre_correcto = str_replace("á", "a", $nombre_correcto);
        $nombre_correcto = str_replace("é", "e", $nombre_correcto);
        $nombre_correcto = str_replace("í", "i", $nombre_correcto);
        $nombre_correcto = str_replace("ó", "o", $nombre_correcto);
        $nombre_correcto = str_replace("ú", "u", $nombre_correcto);
        $nombre_correcto = str_replace(",", "", $nombre_correcto);
        $nombre_correcto = str_replace("(", "", $nombre_correcto);
        $nombre_correcto = str_replace(")", "", $nombre_correcto);
        $nombre_correcto = str_replace("\\", "", $nombre_correcto);
        $nombre_correcto = str_replace("/", "", $nombre_correcto);
        $nombre_correcto = str_replace("`", "", $nombre_correcto);
        $nombre_correcto = str_replace("!", "", $nombre_correcto);
        $nombre_correcto = str_replace("@", "", $nombre_correcto);
        $nombre_correcto = str_replace("ñ", "n", $nombre_correcto);
        $nombre_correcto = str_replace("$", "", $nombre_correcto);
        $nombre_correcto = str_replace("#", "", $nombre_correcto);
        $nombre_correcto = str_replace("*", "", $nombre_correcto);
        $nombre_correcto = str_replace("=", "", $nombre_correcto);
        $nombre_correcto = str_replace("?", "", $nombre_correcto);
        $nombre_correcto = str_replace("¿", "", $nombre_correcto);
        $nombre_correcto = str_replace("¡", "", $nombre_correcto);
        $nombre_correcto = str_replace("!", "", $nombre_correcto);
        $nombre_correcto = str_replace("\"", "", $nombre_correcto);
        $nombre_correcto = str_replace("'", "", $nombre_correcto);
        $nombre_correcto = str_replace("&", "y", $nombre_correcto);
        $nombre_correcto = str_replace("[", "", $nombre_correcto);
        $nombre_correcto = str_replace("]", "", $nombre_correcto);
        $nombre_correcto = str_replace("{", "", $nombre_correcto);
        $nombre_correcto = str_replace("}", "", $nombre_correcto);
        $nombre_correcto = str_replace("^", "", $nombre_correcto);
        $nombre_correcto = str_replace("·", "", $nombre_correcto);
        $nombre_correcto = str_replace("<", "", $nombre_correcto);
        $nombre_correcto = str_replace(">", "", $nombre_correcto);
        $nombre_correcto = str_replace(";", "", $nombre_correcto);
        $nombre_correcto = str_replace(":", "", $nombre_correcto);
        $nombre_correcto = str_replace("Â", "a", $nombre_correcto);
        $nombre_correcto = str_replace("Ê", "e", $nombre_correcto);
        $nombre_correcto = str_replace("Î", "i", $nombre_correcto);
        $nombre_correcto = str_replace("Ô", "o", $nombre_correcto);
        $nombre_correcto = str_replace("Û", "u", $nombre_correcto);
        $nombre_correcto = str_replace("â", "a", $nombre_correcto);
        $nombre_correcto = str_replace("ê", "e", $nombre_correcto);
        $nombre_correcto = str_replace("î", "i", $nombre_correcto);
        $nombre_correcto = str_replace("ô", "o", $nombre_correcto);
        $nombre_correcto = str_replace("û", "u", $nombre_correcto);
        $nombre_correcto = str_replace("ä", "a", $nombre_correcto);
        $nombre_correcto = str_replace("ë", "e", $nombre_correcto);
        $nombre_correcto = str_replace("ï", "i", $nombre_correcto);
        $nombre_correcto = str_replace("ö", "o", $nombre_correcto);
        $nombre_correcto = str_replace("ü", "u", $nombre_correcto);
        $nombre_correcto = str_replace("Ä", "a", $nombre_correcto);
        $nombre_correcto = str_replace("Ë", "e", $nombre_correcto);
        $nombre_correcto = str_replace("Ï", "i", $nombre_correcto);
        $nombre_correcto = str_replace("Ö", "o", $nombre_correcto);
        $nombre_correcto = str_replace("Ü", "u", $nombre_correcto);
        $nombre_correcto = str_replace("ã", "a", $nombre_correcto);
        $nombre_correcto = str_replace("À", "a", $nombre_correcto);
        $nombre_correcto = str_replace("ù", "u", $nombre_correcto);
        $nombre_correcto = str_replace("?", "", $nombre_correcto);
        $nombre_correcto = str_replace("¬", "", $nombre_correcto);
        $nombre_correcto = str_replace("+", "", $nombre_correcto);
        $nombre_correcto = str_replace("Ç", "c", $nombre_correcto);
        $nombre_correcto = str_replace("ç", "c", $nombre_correcto);
        $nombre_correcto = str_replace("º", "", $nombre_correcto);
        $nombre_correcto = str_replace(" ", "_", $nombre_correcto);
        $nombre_correcto = str_replace(".", "", $nombre_correcto);
        $nombre_Nuevo = utf8_decode($nombre_correcto);
        return $nombre_Nuevo;
    }

}

?>
