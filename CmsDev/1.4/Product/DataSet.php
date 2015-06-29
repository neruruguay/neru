<?php

/**
 * Description of Product\DataSet
 *
 * @author Martín Daguerre
 */

namespace CmsDev\Product;

use CmsDev\util\globals as SKTGLOBALS,
    CmsDev\Url,
    CmsDev\sql as SKTDB;

class DataSet {

    private static $instancia;

    public static function get() {
        if (!self::$instancia instanceof self) {
            self::$instancia = new self;
        }
        return self::$instancia;
    }

    private function __construct() {

        $SKT = SKTGLOBALS::getVar('SKT');
        $SKTDB = SKTDB\db_Skt::connect();

        $Request = new \CmsDev\Url\Request();
        $URLName = $Request->byLevel(0);

        $RequestReverse = new \CmsDev\Url\Request();
        $RequestReverse->reverse(false);
        $testLanguage = $RequestReverse->byLevel(0);

        $LanguageArray = $SKT['LANGUAGE']['LIST'];

        if (in_array($testLanguage, $LanguageArray)) {
            $Language = $testLanguage;
        } else {
            $Language = \LANGUAGE_DEF;
        }
        if (\SKT_SECTION_PID != '') {
            $ProductsValues = $SKTDB->query("SELECT * FROM " . \DB_PREFIX . "products WHERE ProductID = '" . \SKT_SECTION_PID . "'");
        }
        $SKTDB->query("SELECT * FROM " . \DB_PREFIX . "products WHERE UID != '0' LIMIT 1");
        $query = $SKTDB->get_col_info();
        if ($ProductsValues) {
            foreach ($query as $name) {
                $this->$name = $ProductsValues->$name;
            }
        } else {
            foreach ($query as $name) {
                $this->$name = '';
            }
        }
    }

}

?>
