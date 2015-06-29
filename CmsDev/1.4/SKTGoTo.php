<?php

/**
 * Description of SKTGoTo
 *
 * @author Martin
 */

namespace CmsDev;

class SKTGoTo {

    public static function checkAction($Go = false) {
        $e = \ludecsec($Go);
        $e2 = dirname(dirname(__FILE__)) . DS . SKT_VERSION . DS . $e . '.php';
        if (\is_file($e2)) {
            require_once($e2);
        } //else {
            //echo '<b>No se encuentra: ' . $e2 . '</b>';
        //}
    }

}
