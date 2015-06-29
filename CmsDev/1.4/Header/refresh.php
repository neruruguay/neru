<?php

/**
 * Description of refresh
 *
 * @author Martín Daguerre
 * martin.daguerre@negociosenred.uy
 */

namespace CmsDev\Header;

class refresh {

    public static function refreshNow($value = '/') {
        if (!headers_sent())
            header('Location: ' . $value);
        else {
            echo '<script type="text/javascript">';
            echo 'document.body.innerHTML = "";';
            echo 'window.location.href="' . $value . '";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url=' . $value . '" />';
            echo '</noscript>';
            exit();
        }
    }

}

?>
