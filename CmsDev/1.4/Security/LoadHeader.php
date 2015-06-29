<?php

/**
 * Description of Load
 *
 * @author Martín Daguerre
 */

namespace CmsDev\Security;

use CmsDev\Security\loginIntent as Login;

class LoadHeader {

    public static function loadEveryTime($RemoveSUBURL = false) {
        $ua = \getBrowser();
        $SKT_Header = \CmsDev\Header\Make::instance();
        $loadEveryTimeVars = ''
                . 'var SKTServerURL = "' . \SERVER_DIR . \SUBSITE . '";'
                . 'var SKTImageSized = "' . \SERVER_DIR . \SUBSITE . 'SKTSize/";'
                . 'var SKTGoTo = "' . \SERVER_DIR . \SUBSITE . 'SKTGoTo/";'
                . 'var SKTURL_BASE = "' . \SKTURL_BASE . '";'
                . 'var URL_VERSION = "' . \URL_VERSION . '";'
                . 'var SKT_VERSION = "' . \SKT_VERSION . '";'
                . 'var SKTURL_TemplateSite = "' . \SKTURL_TemplateSite . '";'
                . 'var SUBURL = "' . \SUBURL . '";'
                . 'var ASSETS = "' . \ASSETS . '"; '
                . 'var SUBSITE = "' . \SUBSITE . '";'
                . 'var SKT_SECTION_ID = "' . \SKT_SECTION_ID . '";'
                . 'var Language = "' . \THIS_LANG . '";'
                . 'var LanguageFromFile = "' . \LanguageFromFile . '";'
                . 'var SKTURL_REQUEST_URI = "' . addslashes(\SKTURL_REQUEST_URI) . '";'
                . 'var SKTURL_REQUEST_PARAMS = "' . \SKTURL_REQUEST_PARAMS . '";'
                . 'var SKTURL_Here = "' . addslashes(\SKTURL_Here) . '";'
                . 'var SKT_TEMPLATE = "' . addslashes(\SKT_TEMPLATE) . '";'
                . 'var SKTPATH = "' . addslashes(\SKTPATH) . '";'
                . 'var SKTPATH_CmsDev = "' . addslashes(\SKTPATH_CmsDev) . '";'
                . 'var SKTPATH_FileSystems = "' . addslashes(\SKTPATH_FileSystems) . '";'
                . 'var SKTPATH_TemplateSite = "' . addslashes(\SKTPATH_TemplateSite) . '";'
                . 'var SKTURL = "' . \SKTURL . '";'
                . 'var TOTAL_REQUEST = "' . \TOTAL_REQUEST . '";'
                . 'var TOTAL_REQUEST = "' . \TOTAL_REQUEST . '";'
                . 'var TOTAL_REQUEST = "' . \TOTAL_REQUEST . '";'
                . 'var SERVER_DIR = "' . \SERVER_DIR . '";'
                . 'var SKT_BROWSER = "' . $ua['name'] . '";'
                . 'var EditorLayoutsBox = "' . addslashes(\EditorLayoutsBox) . '";'
                . 'var URL_docCSSFile = "' . \SKTURL_TemplateSite . '/EditorStyles.css";'
                . 'var SKT_ADMIN_Message_Update_OK = "' . \SKT_ADMIN_Message_Update_OK . '";'
                . 'var SKT_ADMIN_Message_Update_Error = "' . \SKT_ADMIN_Message_Update_Error . '";'
                . 'var SKT_ADMIN_Message_Validating = "' . \SKT_ADMIN_Message_Validating . '"; '
                . 'var SKT_ADMIN_Message_Delete_Image = "' . \SKT_ADMIN_Message_Delete_Image . '";'
                . 'var SKT_ADMIN_Message_Upload_Image = "' . \SKT_ADMIN_Message_Upload_Image . '";'
                . 'var Msg_RefreshIn = "' . \SKT_ADMIN_Reloading . '";'
                . 'var SKT_ADMIN_Btn_Delete = "' . \SKT_ADMIN_Btn_Delete . '";'
                . 'var SKT_ADMIN_Btn_RestartCancel = "' . \SKT_ADMIN_Btn_RestartCancel . '";'
                . 'var SKT_ADMIN_Btn_Acept = "' . \SKT_ADMIN_Btn_Acept . '"; '
                . 'var SKT_ADMIN_Btn_Create = "' . \SKT_ADMIN_Btn_Create . '"; '
                . 'var SKT_ADMIN_Btn_Save = "' . \SKT_ADMIN_Btn_Save . '";'
                . 'var SKT_ADMIN_Btn_Edit = "' . \SKT_ADMIN_Btn_Edit . '";'
                . 'var SKT_ADMIN_Btn_Activate = "' . \SKT_ADMIN_Btn_Activate . '";'
                . 'var URL_CheckURLName = "' . \URL_CheckURLName . '";'
                . 'var ExtraColorsEditor = SKT_EDITOR_COLORS = "' . \SKT_EDITOR_COLORS . '";'
                . 'var ExtraFontEditor = SKT_EDITOR_FONTS = "' . \SKT_EDITOR_FONTS . '";'
                . 'var EditorLayoutsBox = "' . addslashes(\EditorLayoutsBox) . '";'
                . 'var SKT_EDITOR_BODY = SKT_EDITOR_BODY = "' . \SKT_EDITOR_BODY . '";' . \GoToURLJS . ';';
        $appPack = new \CmsDev\JavaScriptPacker($loadEveryTimeVars);
        $SKT_Header->addCss(\ASSETS . 'css/skt.let.styles.combined.php');
        $SKT_Header->addScript(\ASSETS . 'js/jquery.js', 'text/javascript', true, 'jquery');
        $SKT_Header->addScript(\ASSETS . 'js/jquery-ui.min.js', 'text/javascript', true, 'jquery-ui');
        $SKT_Header->custom('<script type="text/javascript">' . $appPack->pack() . '</script>', true, 'loadEveryTime css + vars');
        $SKT_Header->addScript(\ASSETS . 'skt.let.script.combined.php', 'text/javascript', false, 'bootstrap, bootstrap-switch, bootstrap-select,'
                . 'jquery.cookie, scrollspy, store, jquery.tmpl, jquery.tmplPlus,'
                . 'prettyPhoto, easytabs, cleditor, resizableColumns, classie, gnmenu,'
                . 'highlight, slidebars, easyTooltip');
    }

    public function loadAdmin() {
        if (Login::action('validateAdmin') === true) {
            self::loadEveryTime(true);
            $SKT_Header = \CmsDev\Header\Make::instance();
            $loadAdminVars = 'var editorCMS = "1";';
            $appPack = new \CmsDev\JavaScriptPacker($loadAdminVars);
            $SKT_Header->custom('<script type="text/javascript">' . $appPack->pack() . '</script>'
                    . '<link rel="stylesheet" type="text/css" media="all" href="' . \ASSETS . 'css/skt.la.styles.combined.php" />', true, 'la');
            $DS = DIRECTORY_SEPARATOR;
            $app = \file_get_contents(dirname(dirname(__FILE__)) . $DS . '_appjs' . $DS . 'app.js');
            $appPack = new \CmsDev\JavaScriptPacker($app);
            $SKT_Header->custom('<script type="text/javascript">' . $appPack->pack() . '</script>');
        }
    }

    public static function loadOnFileSystem() {
        $loadAdmin = '';
        if (Login::action('validateAdmin') === true) {
            self::loadEveryTime(true);
            $SKT_Header = \CmsDev\Header\Make::instance();
            $SKT_Header->addMeta('robots', 'noindex,nofollow');
            $loadOnFileSystem = ''
                    . 'var editorCMS = "1";'
                    . 'var SKTServerURL = "' . \SERVER_DIR . \SUBSITE . '";'
                    . 'var SKTURL_FileSystems = "'.\SKTURL_FileSystems.'";'
                    . 'var URL_VERSION = "../";';
            $SKT_Header->custom('<script type="text/javascript">' . $loadOnFileSystem . '</script>', true);
            $SKT_Header->addCss(\ASSETS . 'css/skt.fs.styles.combined.php');
            $SKT_Header->addScript(\ASSETS . 'skt.fs.script.combined.php', 'text/javascript', true, 'fs');
            $SKT_Header->addScript(\SKTURL_CmsDev . '_appjs/SKTFSys.js', 'text/javascript', false, 'skt');
            $SKT_Header->addScript(\SKTURL_CmsDev . '_appjs/app.js', 'text/javascript', false, 'skt2');
            return $SKT_Header->RenderHeader(false);
        }
    }

}

?>
