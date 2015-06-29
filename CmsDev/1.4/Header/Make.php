<?php

/**
 * Description of Header
 *
 * @author Martín Daguerre
 * martin.daguerre@negociosenred.uy
 */

namespace CmsDev\Header;

class Make {

    private static $instancia;
    private $title = '...';
    private $icon = 'favicon.ico';
    private $iconType = 'image/x-icon';
    private $baseUrl = '';
    private $urlCmsDev = 'CmsDev/{version}';
    private $domain = '';
    private $fromTemplate = '_TemplateSite/{fromTemplate}';
    private $meta_description = '';
    private $meta_keywords = '';
    private $meta_robots = 'index,follow';
    private $meta_googlebot = 'index,follow,snippet';
    private $meta_viewport = 'width=device-width; height=device-height; minimum-scale=0.5; maximum-scale=1.5; initial-scale=0.5; user-scalable=yes';
    private $meta_author = \CMSDomain;
    private $meta_charset = 'windows-1252';
    private $base = '/';
    private $custom = '';
    private $find = '';
    private $replace = '';
    private $SKTemplate = '';
    private $break = '';
    private $before = '<!DOCTYPE html><html lang="{htmlLanguage}"  class="no-js"><head>';
    private $after = '</head>';
    private $render = '';
    private $renderFirst = '';
    private $htmlLanguage = 'es';
    private $iconCount = 0;
    private $baseCount = 0;
    private $langCount = 0;
    private $titleCount = 0;
    private $charsetCount = 0;
    private $instanciaCount = 0;
    private $addtitle;
    private $addcharset;
    private $addbase;
    private $addIcon;
    private $addMeta;
    private $addCss;

    public static function instance() {
        if (!self::$instancia instanceof self) {
            self::$instancia = new self;
        }
        return self::$instancia;
    }

    public function lang($htmlLanguage) {
        if ($this->langCount == 0) {
            $this->htmlLanguage = $htmlLanguage;
            $this->langCount++;
        }
    }

    public function charset($meta_charset = 'windows-1252') {
        if ($this->charsetCount == 0) {
            $tag = '<meta http-equiv="Content-Type" content="text/html; charset=' . $meta_charset . '">';
            $this->addcharset .= $tag;
            $this->charsetCount++;
        }
    }

    public function title($title = '') {
        if ($this->titleCount == 0) {
            if ($title != '') {
                $this->title = $title;
                $this->titleCount++;
            }
            $tag = '<title>' . $this->title . '</title>';
            $this->addtitle .= $tag;
        }
    }

    public function base($baseUrl = '') {
        if ($this->baseCount == 0) {
            if ($baseUrl != '' && $baseUrl != 'fs') {
                $this->baseUrl = $baseUrl;
                $tag = '<base href="' . $this->baseUrl . '"/>';
                $this->addbase .= $tag;
                $this->baseCount++;
            } elseif ($baseUrl == 'fs') {
                $this->addbase = '';
                $this->baseCount++;
            } else {
                global $SKT;
                $this->baseUrl = \SKTURL;
                $tag = '<base href="' . $this->baseUrl . '"/>';
                $this->addbase .= $tag;
                $this->baseCount++;
            }
        }
    }

    public function addIcon($icon = '', $iconType = '') {
        if ($icon != '' && $iconType != '') {
            $this->icon = self::urlResolve($icon);
            $this->iconType = $iconType;
            $tag = '<link rel="shortcut icon" href="' . $this->icon . '" type="' . $this->iconType . '"/>';
            $this->addIcon .= $tag;
            $this->iconCount++;
        }
    }

    public function customMeta($name = '', $nameValue = '', $content = '') {
        if ($name != '' && $content != '') {
            $tag = '<meta content="' . self::urlResolve($content) . '" ' . $name . '="' . $nameValue . '" />';
            $this->addMeta .= $tag;
        }
    }

    public function addMeta($name = '', $content = '') {
        if ($name != '' && $content != '') {
            $tag = '<meta  content="' . self::urlResolve($content) . '" name="' . $name . '"/>';
            $this->addMeta .= $tag;
        }
    }

    public function addScript($scriptUrl = '', $type = 'text/javascript', $First = false, $dataload = '') {
        if ($scriptUrl != '') {
            $this->scriptUrl = self::urlResolve($scriptUrl);
            $this->type = $type;
            $tag = '<!-- ' . $dataload . ' -->' . '<script src="' . $this->scriptUrl . '" type="' . $this->type . '"></script>';
            if ($First === false) {
                $this->render .= $tag;
            } else {
                $this->renderFirst .= $tag;
            }
        }
    }

    public function custom($content = '', $First = false, $dataload = '') {
        if ($content != '') {
            if ($First === false) {
                $this->render .= '<!-- ' . $dataload . ' -->' . self::urlResolve($content);
            } else {
                $this->renderFirst .= '<!-- ' . $dataload . ' -->' . self::urlResolve($content);
            }
        }
    }

    public function addCss($href = '', $media = 'all') {
        $this->href = self::urlResolve($href);
        $this->media = $media;
        if ($href != '' && $media != '') {
            $tag = '<link rel="stylesheet" type="text/css" href="' . $this->href . '" media="' . $this->media . '"/>';
            $this->addCss .= $tag;
        }
    }

    public function urlResolve($baseUrl = '') {
        global $SKT;
        $this->SKTemplate = \SKTURL_TemplateSite;
        $this->domain = \SKTURL;
        $this->break = array('\n', '\r', '\r\n', '\n\r', '\t');
        $this->find = array('{internal}', '{fromTemplate}', '{base}', '{sktAssets}');
        $this->urlCmsDev = \str_replace('{version}', \SKT_VERSION, $this->urlCmsDev);
        $this->replace = array($this->urlCmsDev, $this->SKTemplate, $this->domain, \ASSETS);
        $this->baseUrl = \str_replace($this->break, '', $baseUrl);
        $this->baseUrl = \str_replace($this->find, $this->replace, $baseUrl);
        return $this->baseUrl;
    }

    public function RenderHeader($loadThemeJSCSS = false) {
        if ($this->instanciaCount === 0) {
            $loadEveryTime = '';
            $loadAdmin = '';
            if ($loadThemeJSCSS == true) {
                $Administrator = new \CmsDev\Security\LoadHeader();
                $loadAdmin = $Administrator->loadAdmin();
                $loadEveryTime = $Administrator->loadEveryTime();
            }
            $this->renderFirst = $loadEveryTime . $loadAdmin . $this->renderFirst;
            return self::clean(str_replace('{htmlLanguage}', $this->htmlLanguage, $this->before) . $this->addcharset . $this->addtitle . $this->addMeta . $this->addbase . $this->addIcon . $this->renderFirst . $this->addCss . $this->render . $this->after);
            $this->instanciaCount = 1;
        }
    }

    private function clean($string) {
        //$string = preg_replace('/[\n\r\t]/', ' ', preg_replace('/\s(?=\s)/', '', trim($string)));
        return $string;
    }

}

?>