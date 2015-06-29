<?php

/**
 * Description of refer
 *
 * @author usuario
 */

namespace CmsDev\Url;

class refer {

    public function __construct() {
        $_SESSION['history'] = str_replace('index.php', '', $_SERVER['HTTP_REFERER']);
        return $_SESSION['history'];
    }

}
