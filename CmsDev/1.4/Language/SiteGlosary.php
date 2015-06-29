<?php

namespace CmsDev\Language;

use \CmsDev\Info as SKT_INFO;

class SiteGlosary {

    public static function get() {
        self::getParams();
    }

    public static function UpdateFromFile() {
        self::setParamsFromFile();
    }

    private static function getParams() {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $Language = \CmsDev\Language\CheckLanguage::get();
        $query = $SKTDB->get_row("SELECT SiteParams FROM language WHERE Prefix = '" . $Language . "'");
        if ($query->SiteParams != '') {
            $params = json_decode($query->SiteParams, true);
            foreach ($params as $variable => $value) {
                if (!\defined('SKT' . $variable)) {
                    if (!\is_array($value)) {
                        \define('SKT' . $variable, $value);
                    } else {
                        $NewvalueToArray = \json_encode($value);
                        \define('SKT' . $variable, $NewvalueToArray);
                    }
                } else {
                    break;
                }
            }
        } else {
            self::setParamsFromFile();
        }
    }

    private static function setParamsFromFile() {

        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $query = $SKTDB->get_results("SELECT * FROM language ORDER BY LanguageName ASC");
        global $SKT;
        foreach ($query as $language) {

            include ('site/' . $language->Prefix . '.php');

            $Setparams = $SKTDB->query(\sprintf("UPDATE language Set SiteParams = %s
		WHERE ID = %s", GetSQLValueString(json_encode($SKT), "text"), GetSQLValueString($language->ID, "int")
            ));
            //$MessageBox = SKT_INFO\Asistance::get();
            //$MessageBox->TipOk('El archivo Language/site/' . $language->Prefix . '.php, fue cargado correctamente.', true);
        }
        //self::getParams();
    }

}

?>
