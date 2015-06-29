<?php

/**
 * Description of CheckLanguage
 *
 * @author Martín Daguerre
 */

namespace CmsDev\Language;

class CheckLanguage {

    private static $instancia;

    public static function get() {
        if (!self::$instancia instanceof self) {
            self::$instancia = new self;
        }
        return self::$instancia;
    }

    public function __toString() {
        global $SKT;
        $Request = new \CmsDev\Url\Request();
        $Request->reverse(false);
        $testLanguage = $Request->byLevel(0);
        if ($testLanguage !== '' && $testLanguage !== null) {
            $LanguageArray = $SKT['LANGUAGE']['LIST'];

            if (in_array($testLanguage, $LanguageArray)) {
                $thisLanguage = $testLanguage;
            } else {
                $thisLanguage = \LANGUAGE_DEF;
            }
        } else {
            $thisLanguage = \LANGUAGE_DEF;
        }
        return $thisLanguage;
    }

}

?>
