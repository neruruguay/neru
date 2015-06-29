<?php

/**
 * Description of SessionInfo
 *
 * @author Martin Daguerre
 */

namespace CmsDev\Security;

class SessionInfo {

    static public function Get($name) {
        if (isset($_SESSION[$name])) {
            echo $name . ' : ' . $_SESSION[$name] . '<br>';
        } else {
            return false;
        }
    }

}
