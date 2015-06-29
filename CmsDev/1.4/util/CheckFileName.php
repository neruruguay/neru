<?php

/**
 * Description of CheckFileName
 *
 * @author Mart�n Daguerre
 */

namespace CmsDev\util;

class CheckFileName {

    public static function Fix($FileName, $lowcase = true, $ext = false, $separate = false) {
        $nombre = utf8_decode(basename(trim($FileName)));
        $extlower = '';
        $nombre_Nuevo = '';

        if ($ext === true) {
            $ext = substr($nombre, strrpos($nombre, ".") + 1, 4);
            $extlower = strtolower(substr($nombre, strrpos($nombre, ".") + 1, 4));
            if ($extlower == 'jpeg') {
                $extlower = 'jpg';
            }
            if ($extlower == 'mpeg') {
                $extlower = 'mpg';
            }
        }
        $nombre_correcto = str_replace($ext, "", $nombre);
        $nombre_correcto = str_replace("Cfakepath", "", $nombre_correcto);
        $nombre_correcto = str_replace(".", "", $nombre_correcto);
        $nombre_correcto = str_replace("�", "�", $nombre_correcto);
        $nombre_correcto = str_replace("�", "A", $nombre_correcto);
        $nombre_correcto = str_replace("�", "E", $nombre_correcto);
        $nombre_correcto = str_replace("�", "I", $nombre_correcto);
        $nombre_correcto = str_replace("�", "O", $nombre_correcto);
        $nombre_correcto = str_replace("�", "u", $nombre_correcto);
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
        $nombre_correcto = str_replace("@", "arroba", $nombre_correcto);
        $nombre_correcto = str_replace("�", "n", $nombre_correcto);
        $nombre_correcto = str_replace("�", "n", $nombre_correcto);
        $nombre_correcto = str_replace("$", "", $nombre_correcto);
        $nombre_correcto = str_replace("#", "", $nombre_correcto);
        $nombre_correcto = str_replace("*", "", $nombre_correcto);
        $nombre_correcto = str_replace("=", "", $nombre_correcto);
        $nombre_correcto = str_replace(".", "", $nombre_correcto);
        $nombre_correcto = str_replace("?", "", $nombre_correcto);
        $nombre_correcto = str_replace("�", "", $nombre_correcto);
        $nombre_correcto = str_replace("�", "", $nombre_correcto);
        $nombre_correcto = str_replace("!", "", $nombre_correcto);
        $nombre_correcto = str_replace("\"", "", $nombre_correcto);
        $nombre_correcto = str_replace("'", "", $nombre_correcto);
        $nombre_correcto = str_replace("&", "and", $nombre_correcto);
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
        $nombre_correcto = str_replace("Cfakepath", "", $nombre_correcto);
        $nombre_Nuevo = utf8_decode($nombre_correcto);

////////////////////////////////////////////////////////////////

        if ($lowcase === true) {
            $nombre_Nuevo = strtolower($nombre_Nuevo);
            $extlower = strtolower($extlower);
        }

        if ($ext === true && $separate === true) {
            return $nombre_Nuevo . '|' . $extlower;
        } elseif ($ext === true && $separate === false) {
            return $nombre_Nuevo . '.' . $extlower;
        } else {
            return $nombre_Nuevo;
        }
    }

}

?>
