<?php

/**
 * Description of make
 *
 * @author Martín Daguerre
 */

namespace CmsDev\Url;

class Route {

    private static $instancia;

    public static function get() {
        if (!self::$instancia instanceof self) {
            self::$instancia = new self;
        }
        return self::$instancia;
    }

    private function __construct() {

        $HTTP = "http://" . $_SERVER['HTTP_HOST'];
        $bbase = $this->CorrectURL(basename($_SERVER['SCRIPT_FILENAME']));
        $LOC = $this->CorrectURL(str_replace($bbase, "", $_SERVER['SCRIPT_FILENAME']));
        $this->ThisURL = str_replace($bbase, "", $_SERVER['PHP_SELF']);
        $this->ThisDIR = str_replace($bbase, "", $_SERVER['SCRIPT_FILENAME']);
        define("SERVER_DIR", $HTTP);
        define('LOCAL_DIR', $LOC);
    }

    private function CorrectURL($str) {
        global $SKT;
        $version = '/CmsDev/' . \SKT_VERSION;
        $template = $SKT['SITE']['TEMPLATE'];
        $find = array(
            '/_TemplateSite/default/SKT_Theme_Pages',
            '/_TemplateSite/default/SKT_Editor_Parts',
            '/_TemplateSite/default/SKT_Theme_Parts',
            '/_TemplateSite/default/captcha',
            '/_TemplateSite/default/SKT_Controls',
            '/_TemplateSite/default',
            '/_FileSystems',
            '/_TemplateSite/' . $template . '/SKT_Theme_Pages',
            '/_TemplateSite/' . $template . '/SKT_Editor_Parts',
            '/_TemplateSite/' . $template . '/SKT_Theme_Parts',
            '/_TemplateSite/' . $template . '/captcha',
            '/_TemplateSite/' . $template . '/SKT_Controls',
            '/_TemplateSite/' . $template,
            '/_TemplateSite',
            $version . '/query',
            $version . '/Content',
            $version . '/Editor',
            $version . '/FileSystem',
            $version . '/Language',
            $version . '/Navegation',
            $version . '/Query',
            $version . '/Secutity',
            $version . '/Url',
            $version . '/Seo',
            $version . '/smtp',
            $version . '/tpl',
            $version);
        $fixed = str_replace($find, '', $str);
        return $fixed;
    }

}

?>
