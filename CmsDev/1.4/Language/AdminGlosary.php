<?php

namespace CmsDev\Language;

use \CmsDev\Info as SKT_INFO;

class AdminGlosary {

    public static function get() {
        self::getParams();
    }

    public static function UpdateFromFile() {
        self::setParamsFromFile();
    }

    private static function getParams() {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $Language = \CmsDev\Language\CheckLanguage::get();
        $query = $SKTDB->get_row("SELECT AdminParams FROM language WHERE Prefix = '" . $Language . "'");
        if ($query->AdminParams != '') {

            $params = json_decode($query->AdminParams, true);
            if (is_array($params)) {
                foreach ($params as $variable => $value) {
                    if (!defined('SKT_ADMIN_' . $variable)) {
                        if (!is_array($value)) {
                            \define('SKT_ADMIN_' . $variable, $value);
                        } else {
                            $NewvalueToArray = \json_encode($value);
                            \define('SKT_ADMIN_' . $variable, $NewvalueToArray);
                        }
                    } else {
                        break;
                    }
                }
            } else {
                $ErrorMessageBox = "Error al cargar las variables de sistema en CmsDev\Language\getParams(). Puede existir un json mal formado. Verifique la tabla de lenguaje o consulte al Administrador.";
                $MessageBox = SKT_INFO\Asistance::get();
                $MessageBox->TipError($ErrorMessageBox, true);
                //
                //$AdminParams=substr($query->AdminParams,strrpos($query->AdminParams,"\"")-200,200);
                //echo "<pre>".$AdminParams."</pre>";
            }
        } else {
            self::setParamsFromFile();
        }
    }

    private static function setParamsFromFile() {

        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $query = $SKTDB->get_results("SELECT * FROM language ORDER BY LanguageName ASC");
        global $SKT_ADMIN;
        foreach ($query as $language) {

            include ('admin/' . $language->Prefix . '.php');

            $Setparams = $SKTDB->query(sprintf("UPDATE language Set AdminParams = %s
		WHERE ID = %s", GetSQLValueString(json_encode($SKT_ADMIN), "text"), \GetSQLValueString($language->ID, "int")
            ));
            //$MessageBox = SKT_INFO\Asistance::get();
            //$MessageBox->TipOk('El archivo Language/admin/' . $language->Prefix . '.php, fue cargado correctamente.', true);
        }
        //self::getParams();
    }

    public static function getTableEdit() {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $Language = \CmsDev\Language\CheckLanguage::get();
        $query = $SKTDB->get_row("SELECT AdminParams FROM language WHERE Prefix = '" . $Language . "'");
        if ($query->AdminParams != '') {

            $params = json_decode($query->AdminParams, true);
            if (is_array($params)) {
                $HTML = '<table><tr><td>Parametro</td><td>Valor</td></tr>';
                foreach ($params as $variable => $value) {

                    if (!is_array($value)) {
                        $HTML.= '<tr><td>SKT_ADMIN_' . $variable . '</td><td>' . $value . '</td></tr>';
                    } else {
                        $NewvalueToArray = \json_encode($value);
                        $HTML.= '<tr><td>SKT_ADMIN_' . $variable . '</td><td>' . $NewvalueToArray . '</td></tr>';
                    }
                }
                $HTML.= '</table>';
                return $HTML;
            } else {
                $ErrorMessageBox = "Error al cargar las variables de sistema en CmsDev\Language\getParams(). Puede existir un json mal formado. Verifique la tabla de lenguaje o consulte al Administrador.";
                $MessageBox = SKT_INFO\Asistance::get();
                $MessageBox->TipError($ErrorMessageBox, true);
                //
                //$AdminParams=substr($query->AdminParams,strrpos($query->AdminParams,"\"")-200,200);
                //echo "<pre>".$AdminParams."</pre>";
            }
        } else {
            self::setParamsFromFile();
        }
    }

}

?>
