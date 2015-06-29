<?php

/**
 * Description of directload
 *
 * @author Martín Daguerre
 */

namespace CmsDev\Init;

class directload {

    public static function HeadStart() {
        $headStart = '<!DOCTYPE HTML><html><head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">';
        $LoadHeader = new \CmsDev\Security\LoadHeader();
        echo $headStart . $LoadHeader->loadAdmin();
    }

    public static function HeadEnd() {
        $headEnd = '</head><body>';
        echo $headEnd;
    }

    public static function BodyEnd() {
        $bodyEnd = '</body></html>';
        echo $bodyEnd;
    }

}

?>
