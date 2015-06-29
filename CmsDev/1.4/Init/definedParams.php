<?php

/**
 * Description of definedParams
 *
 * @author Martín Daguerre
 */

namespace CmsDev\Init;

use CmsDev\Sql as SKTDB;

class definedParams {

    public $DevShowParams = '';
    public $render = '';
    public $defined = "";
    private static $instancia;
    private $SESSION = false;
    private $POST = false;
    private $GET = false;

    public static function get() {
        if (!self::$instancia instanceof self) {
            self::$instancia = new self;
            self::$instancia->view('routes');
            self::$instancia->view('language');
            self::$instancia->view('user');
            self::$instancia->view('RequestGET');
            self::$instancia->view('RequestPOST');
            self::$instancia->view('section');
            self::$instancia->view('site');
        }
        return self::$instancia;
    }

    public function view($case) {
        return $this->$case();
    }

    private function RequestGET() {
        $GETcount = count($_GET);
        if ($GETcount > 0) {
            $this->GET = true;
            $this->DevShowParams .= '<h3><a href="#">GET</a></h3><table width="250" border="0" cellspacing="0" cellpadding="0" class="TableInfo"><tr><th scope="row" class="defined">$_GET[]</th><td scope="row" class="value">value</td></tr>';
            foreach ($_GET as $variable => $value) {
                $this->DevShowParams.='<tr><th class="defined"><span>$_GET[\'' . $variable . '\']</span></th><th scope="row" class="value"><span>' . $value . '</span></th></tr>';
            }
            $this->DevShowParams.='</table>';
        }
    }

    private function RequestPOST() {
        $POSTcount = count($_POST);
        if ($POSTcount > 0) {
            $this->POST = true;
            $this->DevShowParams .= '<h3><a href="#">POST</a></h3><table width="250" border="0" cellspacing="0" cellpadding="0" class="TableInfo"><tr><th scope="row" class="defined">$_POST[]</th><td scope="row" class="value">value</td></tr>';
            foreach ($_POST as $variable => $value) {
                if (!\is_array($value)) {
                    if ($variable == 'SKT_Password' or $variable == 'SKT_AdminPassword') {
                        $value = '&bull;&bull;&bull;&bull;&bull;';
                    }
                    $this->DevShowParams.='<tr><th class="defined"><span>$_POST[\'' . $variable . '\']</span></th><th scope="row" class="value"><span>' . $value . '</span></th></tr>';
                }
            }
            $this->DevShowParams.='</table>';
        }
    }

    private function language() {

        $SKT = \CmsDev\util\globals::getVar('SKT');
        $Request = new \CmsDev\Url\Request();
        $Request->reverse(false);
        $testLanguage = \trim($Request->byLevel(0), '/');

        $LanguageArray = $SKT['LANGUAGE']['LIST'];

        if (in_array($testLanguage, $LanguageArray)) {
            $thisLanguage = $testLanguage;
        } else {
            $thisLanguage = \LANGUAGE_DEF;
        }

        \define('THIS_LANG', $SKT['LANGUAGE'][$thisLanguage]['Prefix']);

        $language['LANGUAGE_DEF'] = \LANGUAGE_DEF;
        $language['THIS_LANG'] = \THIS_LANG;

        $count = count($language);
        if ($count > 0) {
            $this->DevShowParams .= '<h3><a href="#">Lenguaje</a></h3><table width="250" border="0" cellspacing="0" cellpadding="0" class="TableInfo"><tr><th scope="row" class="defined">defined</th><td scope="row" class="value">value</td></tr>';
            foreach ($language as $variable => $value) {
                $this->DevShowParams.='<tr><th class="defined"><span>' . $variable . '</span></th><th scope="row" class="value"><span>' . $value . '</span></th></tr>';
            }
            $this->DevShowParams.='</table>';
        }
    }

    private function section() {

        $SKT = \CmsDev\util\globals::getVar('SKT');
        $SKTDB = SKTDB\db_Skt::connect();
        $SectionValues = \CmsDev\Content\Section::get();
        $ParentSectionValues = $SectionValues->ParentSectionValues;
        $Parent_2_SectionValues = $SectionValues->Parent_2_SectionValues;
        $Parent_3_SectionValues = $SectionValues->Parent_3_SectionValues;
        $Parent_4_SectionValues = $SectionValues->Parent_4_SectionValues;
        $Parent_5_SectionValues = $SectionValues->Parent_5_SectionValues;
        $query = $SKTDB->query("SELECT * FROM " . \DB_PREFIX . "sections WHERE SID = '0'");
        $query2 = $SKTDB->get_col_info($info_type = "name", $col_offset = -1);
        $cols = array();
        foreach ($query2 as $name) {
            array_push($cols, $name);
        }

        foreach ($cols as $col) {
            $val[$col] = $SectionValues->$col;
            \define($this->fixdef('SKT_SECTION_' . $col), $SectionValues->$col);
        }
        if (\is_object($ParentSectionValues)) {
            foreach ($cols as $col) {
                $val['Parent\'][\'' . $col] = $ParentSectionValues->$col;
                \define($this->fixdef('SKT_PARENT_' . $col), $ParentSectionValues->$col);
            }
        } else {
            foreach ($cols as $col) {
                \define($this->fixdef('SKT_PARENT_' . $col), '');
            }
        }
        if (\is_object($Parent_2_SectionValues)) {
            foreach ($cols as $col) {
                $val['Parent2\'][\'' . $col] = $Parent_2_SectionValues->$col;
                \define($this->fixdef('SKT_PARENT2_' . $col), $Parent_2_SectionValues->$col);
            }
        } else {
            foreach ($cols as $col) {
                \define($this->fixdef('SKT_PARENT2_' . $col), '');
            }
        }
        if (\is_object($Parent_3_SectionValues)) {
            foreach ($cols as $col) {
                $val['Parent3\'][\'' . $col] = $Parent_3_SectionValues->$col;
                \define($this->fixdef('SKT_PARENT3_' . $col), $Parent_3_SectionValues->$col);
            }
        } else {
            foreach ($cols as $col) {
                \define($this->fixdef('SKT_PARENT3_' . $col), '');
            }
        }
        if (\is_object($Parent_4_SectionValues)) {
            foreach ($cols as $col) {
                $val['Parent4\'][\'' . $col] = $Parent_4_SectionValues->$col;
                \define($this->fixdef('SKT_PARENT4_' . $col), $Parent_4_SectionValues->$col);
            }
        } else {
            foreach ($cols as $col) {
                \define($this->fixdef('SKT_PARENT4_' . $col), '');
            }
        }
        if (\is_object($Parent_5_SectionValues)) {
            foreach ($cols as $col) {
                $val['Parent5\'][\'' . $col] = $Parent_5_SectionValues->$col;
                \define($this->fixdef('SKT_PARENT5_' . $col), $Parent_5_SectionValues->$col);
            }
        } else {
            foreach ($cols as $col) {
                \define($this->fixdef('SKT_PARENT5_' . $col), '');
            }
        }
        $count = count($val);
        $p1 = $p2 = $p3 = $p4 = $p5 = 0;
        $SECTION = '';

        if ($count > 0) {
            $this->DevShowParams .= '<h3><a href="#">' . \SKT_ADMIN_DP_Section . '</a></h3><table width="250" border="0" cellspacing="0" cellpadding="0" class="TableInfo"><tr><th scope="row" class="defined">defined</th><td scope="row" class="value">value</td></tr>';

            foreach ($val as $variable => $value) {
                if ($p1 === 0 && strstr($variable, 'Parent')) {
                    $this->DevShowParams.= '<tr><th scope="col" colspan="2">Parent Section ' . $val['Parent\'][\'Title'] . '</th></tr>';
                    $p1++;
                } else
                if ($p2 === 0 && strstr($variable, 'Parent2')) {
                    $this->DevShowParams.= '<tr><th scope="col" colspan="2">Parent (2) Section ' . $val['Parent2\'][\'Title'] . '</th></tr>';
                    $p2++;
                } else
                if ($p3 === 0 && strstr($variable, 'Parent3')) {
                    $this->DevShowParams.= '<tr><th scope="col" colspan="2">Parent (3) Section ' . $val['Parent3\'][\'Title'] . '</th></tr>';
                    $p3++;
                } else
                if ($p4 === 0 && strstr($variable, 'Parent4')) {
                    $this->DevShowParams.= '<tr><th scope="col" colspan="2">Parent (4) Section ' . $val['Parent4\'][\'Title'] . '</th></tr>';
                    $p4++;
                } else
                if ($p5 === 0 && strstr($variable, 'Parent5')) {
                    $this->DevShowParams.= '<tr><th scope="col" colspan="2">Parent (5) Section ' . $val['Parent5\'][\'Title'] . '</th></tr>';
                    $p5++;
                }

                if (!strstr($variable, 'Parent')) {
                    $SECTION = 'SECTION_';
                } else {
                    $SECTION = '';
                }



                $this->DevShowParams.='<tr><th class="defined" scope="row">SKT_' . $SECTION . $this->fixdef($variable) . '</th><th scope="row" class="value"><span>' . $value . '</span></th></tr>';
            }
            $this->DevShowParams.='</table>';
        }
    }

    private function user() {

        $SKT = \CmsDev\util\globals::getVar('SKT');
        $SESSIONcount = count($_SESSION);
        if ($SESSIONcount > 0) {
            $this->SESSION = true;
            $this->DevShowParams .= '<h3><a href="#">Session</a></h3><table width="250" border="0" cellspacing="0" cellpadding="0" class="TableInfo"><tr><th scope="row" class="defined">$_SESSION[]</th><td scope="row" class="value">value</td></tr>';
            foreach ($_SESSION as $variable => $value) {
                $this->DevShowParams.='<tr><th class="defined"><span>$_SESSION[\'' . $variable . '\']</span></th><th scope="row" class="value"><span>' . $value . '</span></th></tr>';
            }
            $this->DevShowParams.='</table>';
        }
        $count2 = count($_COOKIE);
        if ($count2 > 0) {
            $this->DevShowParams .= '<h3><a href="#">Cookies</a></h3><table width="250" border="0" cellspacing="0" cellpadding="0" class="TableInfo"><tr><th scope="row" class="defined">$_COOKIE[]</th><td scope="row" class="value">value</td></tr>';
            foreach ($_COOKIE as $variable => $value) {
                $this->DevShowParams.='<tr><th class="defined"><span>$_COOKIE[\'' . $variable . '\']</span></th><th scope="row" class="value"><span>' . $value . '</span></th></tr>';
            }
            $this->DevShowParams.='</table>';
        }
    }

    private static function uencsec($e) {
        return \CmsDev\skt_Code::Encode($e);
    }

    private function site() {
 
        $SKT = \CmsDev\util\globals::getVar('SKT');
        $count = count($SKT);
        if ($count > 0) {
            $this->DevShowParams .= '<h3><a href="#">Configuraciones</a></h3><table width="250" border="0" cellspacing="0" cellpadding="0" class="TableInfo"><tr><th scope="row" class="defined">defined</th><td scope="row" class="value">value</td></tr>';
            foreach ($SKT as $variable => $value) {
                if (\is_array($value)) {
                    foreach ($value as $variable2 => $value2) {
                        if (\is_array($value2)) {
                            foreach ($value2 as $variable3 => $value3) {
                                if (!defined($this->fixdef('SKT_' . $variable . '_' . $variable2 . '_' . $variable3))) {
                                    \define($this->fixdef('SKT_' . $variable . '_' . $variable2 . '_' . $variable3), $value3);
                                }
                                $this->DevShowParams.='<tr><th class="defined" scope="row">' . $this->fixdef('SKT_' . $variable . '_' . $variable2 . '_' . $variable3) . '</th><td class="value" scope="row"><span>' . $value3 . '</span></td></tr>';
                            }
                        } else {
                            if (!defined($this->fixdef('SKT_' . $variable . '_' . $variable2))) {
                                \define($this->fixdef('SKT_' . $variable . '_' . $variable2), $value2);
                            }
                            $this->DevShowParams.='<tr><th class="defined" scope="row">' . $this->fixdef('SKT_' . $variable . '_' . $variable2) . '</th><td class="value" scope="row"><span>' . $value2 . '</span></td></tr>';
                        }
                    }
                } else {
                    if (!defined($this->fixdef('SKT_' . $variable))) {
                        \define($this->fixdef('SKT_' . $variable), $value);
                    }
                    $this->DevShowParams.='<tr><th class="defined" scope="row">' . $this->fixdef('SKT_' . $variable) . '</th><td class="value" scope="row"><span>' . $value . '</span></td></tr>';
                }
            }
            $this->DevShowParams.='</table>';
        }
    }

    private function routes() {

        $SKT = \CmsDev\util\globals::getVar('SKT');

        $HTTP = "http://" . $_SERVER['HTTP_HOST'];
        $bbase = $this->CorrectURL(basename($_SERVER['SCRIPT_FILENAME']));
        $LOC = $this->CorrectURL(str_replace($bbase, "", $_SERVER['SCRIPT_FILENAME']));
        $this->ThisURL = str_replace($bbase, "", $_SERVER['PHP_SELF']);
        $this->ThisDIR = str_replace($bbase, "", $_SERVER['SCRIPT_FILENAME']);
        define("SERVER_DIR", $HTTP);
        define('LOCAL_DIR', $this->fixDS($LOC));
        define('LOCAL_FILESYSTEM', $this->fixDS($LOC . '_FileSystems' . DIRECTORY_SEPARATOR));


        $Request = new \CmsDev\Url\Request();

        $allRequest = \trim($Request->all(), '/');
        if ($allRequest == '') {
            \define('SUBURL', $allRequest . \LANGUAGE_DEF);
        } else {
            \define('SUBURL', $allRequest);
        }
        $ThisSectionURLName = $Request->byLevel(0);
        \define('THIS_URL_REAL', $ThisSectionURLName);

        $TotalURL = $Request->all();
        \define('TOTAL_REQUEST', \SERVER_DIR . $TotalURL);

        \define('LOCAL_FILESYSTEM_SECTION', $this->fixDS(\LOCAL_FILESYSTEM . \SUBURL) . DIRECTORY_SEPARATOR);
        \define('URL_VERSION', 'CmsDev/' . \SKT_VERSION . '/');

        if (!\is_dir(\LOCAL_DIR . '/_TemplateSite/' . \SKT_TEMPLATE)) {
            $MessageBox = \CmsDev\Info\Asistance::get();
            $MessageBox->TipError('Se está mostrando el template por defecto, ya que no se encontró el directorio "<b>' . \SKT_TEMPLATE . '</b>"');
            $TemplateCustom = 'defaultSite';
            \define('SKT_TEMPLATE_ERROR', 'ERROR: Se está mostrando el template por defecto.');
        } else {
            \define('SKT_TEMPLATE_ERROR', '');
        }

        //\define('SKTURL_TemplateSite', str_replace(\SUBSITE, '/', $SKT['URL']['SUBSITE'] . '_TemplateSite/' . $TemplateCustom));

        \CmsDev\Layout\EditorLayoutsBox::get();
        \define('SKTServerURL', \SUBSITE);
        \define('SKTImageSized', \SUBSITE . 'SKTSize/');
        \define('SKTGoTo', \SUBSITE . 'SKTGoTo/');

        $arr = array('LanguageFromFile' => \LanguageFromFile,
            'SKTServerURL' => \SKTServerURL,
            'SKTURL_Here' => \SKTURL_Here,
            'SKTImageSized' => \SKTImageSized,
            'SKTGoTo' => \SKTGoTo,
            'SKTURL_REQUEST_URI' => \SKTURL_REQUEST_URI,
            'SKTURL_REQUEST_PARAMS' => \SKTURL_REQUEST_PARAMS,
            'VERSION' => \VERSION,
            'SKT_TEMPLATE' => \SKT_TEMPLATE,
            'SKTPATH' => \SKTPATH,
            'SKTPATH_CmsDev' => \SKTPATH_CmsDev,
            'SKTPATH_FileSystems' => \SKTPATH_FileSystems,
            'SKTPATH_TemplateSite' => \SKTPATH_TemplateSite,
            'SKTURL' => \SKTURL,
            'SKTURL_CmsDev' => \SKTURL_CmsDev,
            'SKTURL_FileSystems' => \SKTURL_FileSystems,
            'SKTURL_TemplateSite' => \SKTURL_TemplateSite,
            'SERVER_DIR' => \SERVER_DIR,
            'LOCAL_DIR' => \LOCAL_DIR,
            'LOCAL_FILESYSTEM' => \LOCAL_FILESYSTEM,
            'LOCAL_FILESYSTEM_SECTION' => \LOCAL_FILESYSTEM_SECTION,
            'TOTAL_REQUEST' => \TOTAL_REQUEST,
            'SUBSITE' => $SKT['URL']['SUBSITE'],
            'SUBURL' => $allRequest,
            'THIS_URL_REAL' => $ThisSectionURLName,
            'URL_VERSION' => \URL_VERSION,
            'SKT_TEMPLATE_ERROR' => \SKT_TEMPLATE_ERROR);

        $this->DevShowParams .= '<h3><a href="#">Direcciones</a></h3><table width="250" border="0" cellspacing="0" cellpadding="0" class="TableInfo"><tr><th scope="row" class="defined">defined</th><td scope="row" class="value">value</td></tr>';
        foreach ($arr as $variable => $value) {

            $this->DevShowParams.='<tr><th class="defined"><span>' . $variable . '</span></th><th scope="row" class="value"><span>' . $value . '</span></th></tr>';
        }
        $this->DevShowParams.='</table>';

        $GoTo = \SKTURL . 'SKTGoTo/';

        $GoToURL = array(
            'URL_CheckURLName' => 'CheckURLName',
            'URL_CheckUserName' => 'CheckUserName',
            'URL_QueryLanguage_Activate_Update' => 'CRUD/Language/Activate',
            'URL_QuerySectionMeta' => 'CRUD/Section/SectionMeta',
            'URL_QuerySectionData' => 'CRUD/Section/SectionData',
            'URL_QueryContentProp' => 'CRUD/Contents/ContentProp',
            'URL_Content_Add_Product' => 'CRUD/Product/Add',
            'URL_Content_Edit_Product' => 'CRUD/Product/Edit',
            'URL_Content_Add_Custom' => 'CRUD/CustomControl/Add',
            'URL_Content_Edit_Custom' => 'CRUD/CustomControl/Edit',
            'URL_Content_Add_Note' => 'CRUD/Note/Add',
            'URL_Content_Edit_Note' => 'CRUD/Note/Edit',
            'URL_Content_Add_Photo' => 'CRUD/Image/Add',
            'URL_Content_Edit_Photo' => 'CRUD/Image/Edit',
            'URL_FileSystemsPopUP' => 'AdminFilesystem/__FileSystemsPopUP',
            'URL_QueryCreateContent' => 'Query/CreateContent',
            'URL_QueryUpdateContent' => 'Query/UpdateContent',
            'URL_QueryDeleteContent' => 'Query/DeleteContent',
            'URL_Content_Edit_PlainText' => 'CRUD/PlainText/Edit',
            'URL_Content_Edit_HTML' => 'CRUD/HTML/Edit', //Q1JVRC9IVE1ML0VkaXQ
            'URL_QueryLoadPlainText' => 'Query/LoadPlainText',
            'URL_QueryUpdateFileOrder' => 'Query/UpdateFileOrder',
            'URL_QueryUpdateSectionProduct' => 'Query/UpdateSectionProduct',
            'URL_QueryCreateSectionProduct' => 'Query/CreateSectionProduct',
            'URL_View_List_Add_List' => 'CRUD/CustomList/Add_List',
            'URL_View_List_SelectList' => 'CRUD/CustomList/SelectList',
            'URL_Query_List_Add_List' => 'CRUD/CustomList/Add_List_query',
            'URL_Query_Delete_List_query' => 'CRUD/CustomList/Delete_List_query',
            'URL_View_List_Properties' => 'CRUD/CustomList/Properties',
            'URL_Query_List_Edit_Properties' => 'CRUD/CustomList/Edit_Properties',
            'URL_Query_Add_Item_query' => 'CRUD/CustomList/Add_Item_query',
            'URL_Query_Edit_Item_query' => 'CRUD/CustomList/Edit_Item_query',
            'URL_View_Add_Item' => 'CRUD/CustomList/Add_Item',
            'URL_Query_Delete_Item_query' => 'CRUD/CustomList/Delete_Item_query',
            'URL_Query_List_Edit_Item' => 'CRUD/CustomList/Edit_Item',
            'URL_View_List_Items' => 'CRUD/CustomList/List_items',
            'URL_View_List_Index' => 'CRUD/CustomList/index',
            'URL_Edit_Item' => 'CRUD/CustomList/Edit_Item',
            'URL_Link_Edit' => 'CRUD/Link/Edit',
            'URL_Query_Link_Create' => 'Query/CreateLink',
            'URL_Query_Link_Edit' => 'Query/EditLink',
            'URL_Query_Link_Delete' => 'Query/DeleteLink',
            'URL_View_List_Information' => 'CRUD/CustomList/List_Information',
            'URL_ViewEditElementsAsList' => 'CRUD/ViewEditElementsAsList/index',
            'URL_logs' => 'logs'
        );
        $GoToURLJS = '';
        foreach ($GoToURL as $variable => $value) {
            \define($variable, $GoTo . self::uencsec($value));
            $GoToURLJS .= 'var ' . $variable . '="' . $GoTo . self::uencsec($value) . '";';
        }
        $GoToURLJS .= 'var PHARLOCATION ="' . \PHARLOCATION . '"; var LOCAL_FILESYSTEM ="' . $LOC . '_FileSystems/";';
        \define('GoToURLJS', $GoToURLJS);
        \define('URL_SKTFSys', \SKTURL . 'SKTFSys/');
    }

    private function CorrectURL($str) {
        $SKT = \CmsDev\util\globals::getVar('SKT');
        $version = '/CmsDev/' . \SKT_VERSION;

        $find = array(
            '/_TemplateSite/' . \TemplateCustom . '/SKT_Theme_Pages',
            '/_TemplateSite/' . \TemplateCustom . '/SKT_Editor_Parts',
            '/_TemplateSite/' . \TemplateCustom . '/SKT_Theme_Parts',
            '/_TemplateSite/' . \TemplateCustom . '/captcha',
            '/_TemplateSite/' . \TemplateCustom . '/SKT_Controls',
            '/_TemplateSite/' . \TemplateCustom . '',
            '/_FileSystems',
            '/AdminFiles',
            $version . '/AdminFilesystem',
            $version . '/CRUD',
            $version . '/Content',
            $version . '/CustomControl',
            $version . '/Header',
            $version . '/Init',
            $version . '/Language',
            $version . '/Layout',
            $version . '/Query',
            $version . '/Navegation',
            $version . '/Editor',
            $version . '/fileuploader',
            $version . '/Product',
            $version . '/Template',
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

    private static function fixDS($param) {
        $find = array('/', '\\');
        $replace = array(DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR);
        $defined = \str_replace($find, $replace, $param);
        return $defined;
    }

    private static function fixdef($param) {
        $param = \trim(\strtolower($param));
        $find = array(' ', '&aacute;', '&eacute;', '&iacute;', '&oacute;', '&uacute;', '][', ']', '[', '\'', '\\');
        $replace = array('_', 'a', 'e', 'i', 'o', 'u', '_', '', '', '', '');
        $defined = \str_replace($find, $replace, $param);
        return \strtoupper($defined);
    }

    public function render() {
        $SKT = \CmsDev\util\globals::getVar('SKT');
        $DBG = '';
        $DBGText = '';
        $this->defined = '';
        if ($SKT['DEBUG'] === 1) {
            $DBG = 'debug';
            $DBGText = '<b>Debug Mode On</b>';
        }
        $script = '<script type="text/javascript"> $(document).ready(function() {   $("#DevShowParams #Variables").accordion({ header: "h3", collapsible: true, heightStyle: "content" }); });</script>';
        $this->render = '<div id="DevShowParams" class="scrolling skt SKTNotRemove"><div id="Variables">' . $this->DevShowParams . '</div><div id="defined">' . $this->defined . '</div></div>' . $script;
        if ($SKT['DEVSHOW'] === 1) {
            echo $this->render;
        }
    }

}

?>