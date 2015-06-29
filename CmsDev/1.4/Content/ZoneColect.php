<?php

/**
 * Description of ZoneColect
 *
 * @author Martín Daguerre
 */

namespace CmsDev\Content;

class ZoneColect {

    private $Zone = '';
    private static $instance;

    public static function init() {
        if (!isset(self::$instance)) {
            $className = __CLASS__;
            self::$instance = new $className;
        }
        return self::$instance;
    }

    public function set($ID) {
        $this->Zone .= $ID;
    }

    public function Colect() {
        return $this->Zone;
    }

}

?>
