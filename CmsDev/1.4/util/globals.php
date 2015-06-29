<?php

/**
 * Description of globals
 *
 * @author Martín Daguerre
 */

namespace CmsDev\util;

class globals {

    private static $instance;

    public static function init() {
        if (!isset(self::$instance)) {
            $className = __CLASS__;
            self::$instance = new $className;
        }
        return self::$instance;
    }

    public static function getVar($key) {
        return $GLOBALS[$key];
    }

    public static function setVar($key, $value) {
        $GLOBALS[$key] = $value;
    }

}

?>
