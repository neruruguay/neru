<?php

/**
 * Description of Footer
 *
 * @author Martín Daguerre
 * martin.daguerre@negociosenred.uy
 */

namespace CmsDev\Footer;

class Make {

    private static $instancia;
    private $baseUrl = '';
    private $urlCmsDev = 'CmsDev/{version}';
    private $domain = '';
    private $fromTemplate = '_TemplateSite/{fromTemplate}';
    private $find = '';
    private $replace = '';
    private $SKTemplate = '';
    private $break = '';
    private $render = '';
    private $renderFirst = '';
    private $instanciaCount = 0;
    private $addCss;

    public static function instance() {
        if (!self::$instancia instanceof self) {
            self::$instancia = new self;
        }
        return self::$instancia;
    }

    public function addScript($scriptUrl = '', $type = 'text/javascript', $First = false) {
        if ($scriptUrl != '') {
            $this->scriptUrl = self::urlResolve($scriptUrl);
            $this->type = $type;
            $tag = '<script src="' . $this->scriptUrl . '" type="' . $this->type . '"></script>';
            if ($First === false) {
                $this->render .= $tag;
            } else {
                $this->renderFirst .= $tag;
            }
        }
    }

    public function RegisterScripts($CombineScripts = array(), $First = false) {
        $type = 'text/javascript';
        $dataScript = '';
        foreach ($CombineScripts as $key => $value) {
            $dataScript .= \file_get_contents(\SKTPATH.self::urlResolve($value));
        }
        $appPack = new \CmsDev\JavaScriptPacker($dataScript);
        $tag = '<script type="' . $type . '">'.$appPack->pack().'</script>';
        if ($First === false) {
            $this->render .= $tag;
        } else {
            $this->renderFirst .= $tag;
        }
    }

    public function custom($content = '', $First = false) {
        if ($content != '') {
            if ($First === false) {
                $this->render .= self::urlResolve($content);
            } else {
                $this->renderFirst .= self::urlResolve($content);
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

    public function RenderFooter() {
        if ($this->instanciaCount === 0) {
            return self::clean($this->renderFirst . $this->addCss . $this->render);
            $this->instanciaCount = 1;
            new \CmsDev\Security\LoadEditorRequired();
        }
    }

    private function clean($string) {
        $string = preg_replace('/[\n\r\t]/', ' ', preg_replace('/\s(?=\s)/', '', trim($string)));
        return $string;
    }

}

?>