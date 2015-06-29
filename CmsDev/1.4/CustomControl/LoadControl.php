<?php

/**
 * Description of CustomControl
 *
 * @author Martín Daguerre
 */

namespace CmsDev\CustomControl;

use \CmsDev\sql\db_Skt as SKT_DB,
    \CmsDev\Info as SKT_INFO;

class LoadControl {

    //private $title = '';
    private $break = '';
    //private $before = '<div class="SKTCC" id="{GID}">';
    //private $after = '</div>';
    private $CC = '';
    private $location = '';
    //private $render = '';
    private $baseUrl = '';
    private $urlCmsDev = 'CmsDev/{version}';
    private $domain = '';
    private $fromTemplate = '{fromTemplate}';
    private $SKTemplate = '';

    public function Render($CC = '', $CCParams = array(), $file = 'Control.php', $location = 0, $CCID = false) {
        global $SKT;
        if ($file !== '') {
            $this->file = $file;
        } else {
            
        }
        $this->file = isset($file) && $file !== '' ? $file : 'Control.php';
        $this->location = isset($location) && $location !== '' ? $location : 0;
        $SKTDB = SKT_DB::connect();
        $this->CC = self::urlResolve($CC);
        if ($this->location === 0) {
            $this->location = \SKTPATH_TemplateSite . 'SKT_Controls' . \DS . $CC . \DS . $this->file;
        }
        $this->location = self::urlResolve($this->location);
        if ($CCID !== false) {
            $contentIDZone = $SKTDB->get_results("SELECT * FROM " . \DB_PREFIX . "content WHERE ID = '" . GetSQLValueString($CCID, "int") . "'");
            $query = $SKTDB->get_col_info($info_type = "name", $col_offset = -1);
            $cols = array();
            foreach ($query as $name) {
                array_push($cols, $name);
            }
            foreach ($contentIDZone as $Zone) {
                $this->TitleZone[$CCID] = \utf8_decode($Zone->Title);
                $this->CSSZone[$CCID] = \utf8_decode($Zone->css_class);
                $this->CustomPropertyZone[$CCID] = \utf8_decode($Zone->CustomProperty);
            }
        }
        if (\is_file($this->location)) {
            include ($this->location);
        } else {
            if ($SKT['DEBUG'] === 1) {
                echo '<span style="color:red"><i class="skt-icon-error"></i> "' . $this->CC . '"</span>';
                $MessageBox = SKT_INFO\Asistance::get();
                $MessageBox->TipError('<i class="skt-icon-frown" style="font-size: 2em; vertical-align: sub;"></i> <b>No se encuentra el control</b>: "' . $CC . '" en ' . \LOCAL_DIR . $this->location, true);
            }
        }
    }

    private function urlResolve($baseUrl = '') {
        $this->SKTemplate = \SKTURL_TemplateSite;
        $this->domain = \SERVER_DIR;
        $this->break = array('\n', '\r', '\r\n', '\n\r', '\t');
        $this->find = array('{internal}', '{fromTemplate}', '{base}');
        $this->urlCmsDev = \str_replace('{version}', \SKT_VERSION, $this->urlCmsDev);
        $this->replace = array($this->urlCmsDev, $this->SKTemplate, $this->domain);
        $this->baseUrl = \str_replace($this->break, '', $baseUrl);
        $this->baseUrl = \str_replace($this->find, $this->replace, $baseUrl);
        return $this->baseUrl;
    }

}

?>
