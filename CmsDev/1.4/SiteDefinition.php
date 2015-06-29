<?php

/**
 * Description of SiteDefinition
 *
 * @author Martín Daguerre
 * martin.daguerre@negociosenred.uy
 */

namespace CmsDev\SiteDefinition;

class dataSet {

    private static $instancia;

    private function __construct() {
        
    }

    private static function dataSet($type = '', $case = '') {
        global $SKT;

        if ($type != '' && $case != '') {
            return $SKT[$type][$case];
        } else {
            return false;
        }
    }

    public static function All() {
        global $SKT;
        return $SKT;
    }

    public static function Version() {
        $DefArray = \SKT_VERSION;
        return $DefArray;
    }

    public static function Site($case = 'NAME') {
        $DefArray = self::dataSet('SITE', $case);
        return $DefArray;
    }

    public static function Url($case = 'SERVER') {
        $DefArray = self::dataSet('URL', $case);
        return $DefArray;
    }

    public function Product($case = 'TEMPLATE') {
        $DefArray = self::dataSet('PRODUCT', $case);
        return $DefArray;
    }

    public static function Editor($case = 'BODY') {
        $DefArray = self::dataSet('EDITOR', $case);
        return $DefArray;
    }

    public static function Media($case = 'ROOT') {
        $DefArray = self::dataSet('MEDIA', $case);
        return $DefArray;
    }

    public static function db($case = 'TYPE') {
        $DefArray = self::dataSet('DB', $case);
        return $DefArray;
    }

    public static function Language($case = 'DEFAULT') {
        global $SKT;

        $Request = new \CmsDev\Url\Request\get();
        $Request->reverse(false);
        $testLanguage = $Request->byLevel(0);

        $LanguageArray = $SKT['LANGUAGE']['LIST'];

        if (in_array($testLanguage, $LanguageArray)) {
            $thisLanguage = $testLanguage;
        } else {
            $thisLanguage = \LANGUAGE_DEF;
        }

        if ($case === 'DEFAULT') {
            $case = 'Prefix';
        }
        $DefArray = $SKT['LANGUAGE'][$thisLanguage][$case];
        return $DefArray;
    }

    public static function get() {
        if (!self::$instancia instanceof self) {
            self::$instancia = new self;
        }
        return self::$instancia;
    }

}
