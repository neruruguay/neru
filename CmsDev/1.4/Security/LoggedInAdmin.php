<?php

/**
 * Description of LoggedInAdmin
 *
 * @author Martín Daguerre
 */

namespace CmsDev\Security;

// use \CmsDev\sql\db_Skt as SKT_DB;
// use \CmsDev\Info as SKT_INFO;

class LoggedInAdmin {

    private static $instancia;

    public static function get() {
        if (!self::$instancia instanceof self) {
            self::$instancia = new self;
        }
        return self::$instancia;
    }

    public static function set($name = '', $value = false) {
        $name = $value;
    }

    public static function validate() {
        $check = loginIntent::action('validate');
        return $check;
    }

}

?>
