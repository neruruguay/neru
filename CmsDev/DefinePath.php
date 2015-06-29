<?php

if (!defined("SITE_SERVER")) {
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'];
    $siteSERVER = $protocol . $domainName;
    define('SITE_SERVER', $siteSERVER);
    $SKT = array();

    /* ---------------------------------------------------------------------------------- */
// LANGUAGE
    $SKT['LANGUAGE']['esp'] = array('Prefix' => 'esp', 'Name' => utf8_encode('Español'), 'Section' => utf8_encode('portada'));
    $SKT['LANGUAGE']['eng'] = array('Prefix' => 'eng', 'Name' => utf8_encode('English'), 'Section' => utf8_encode('home'));
    $SKT['LANGUAGE']['por'] = array('Prefix' => 'por', 'Name' => utf8_encode('Portugues'), 'Section' => utf8_encode('inicio'));
    $SKT['LANGUAGE']['LIST'] = array('esp', 'eng', 'por');
// Administration Language
    $SKT['ADMIN_LANG'] = 'esp';
    $SKT['DEVSHOW'] = 1;
    $SKT['DEBUG'] = 1;
// DB
    $SKT['DB']['TYPE'] = 'mysql';
// defines

    define('DefaultLanguage', 'esp');
    define('LanguageFromFile', FALSE);
    define('SKT_VERSION', '1.4');
    define('VERSION', \SKT_VERSION);

    define('DS', DIRECTORY_SEPARATOR);
    define('SKTPATH', dirname(dirname(__FILE__)) . DS);

    $theme = file_get_contents(\SKTPATH . '_TemplateSite' . DS . 'UseTheme');
    define('SKT_TEMPLATE', $theme);
    define('TemplateCustom', $theme);
    define('SKTPATH_CmsDev', dirname(dirname(__FILE__)) . DS . 'CmsDev' . DS . SKT_VERSION . DS);
    define('SKTPATH_FileSystems', dirname(dirname(__FILE__)) . DS . '_FileSystems' . DS);
    define('SKTPATH_TemplateSite', dirname(dirname(__FILE__)) . DS . '_TemplateSite' . DS . SKT_TEMPLATE . DS);
    define('SKTURL', str_replace($_SERVER['SCRIPT_NAME'], '/', $_SERVER['PHP_SELF']));

    $REQUEST_URI = trim($_SERVER['REQUEST_URI'], '/');
    $posSlash = (int) strripos($REQUEST_URI, '/');
    $posQuery = (int) strripos($REQUEST_URI, '?');

    if ((int) $posSlash === 0 && (int) $posQuery === 0) {
        define('SKTURL_REQUEST_URI', $REQUEST_URI);
        define('SKTURL_REQUEST_PARAMS', '');
        define('SKTURL_Here', $REQUEST_URI);
        //echo 'falso - falso';
    }
    if ((int) $posSlash === 0 && (int) $posQuery !== 0) {
        define('SKTURL_REQUEST_URI', $REQUEST_URI);
        $exp = explode('?', $REQUEST_URI);
        define('SKTURL_REQUEST_PARAMS', $exp[1]);
        define('SKTURL_Here', $exp[0]);
        //echo 'falso - verdadero';
    }
    if ((int) $posSlash !== 0 && (int) $posQuery === 0) {
        define('SKTURL_REQUEST_URI', $REQUEST_URI);
        define('SKTURL_REQUEST_PARAMS', '');
        $exp = explode('/', $REQUEST_URI);
        $expCount = count($exp) - 1;
        define('SKTURL_Here', $exp[$expCount]);
        //echo 'verdadero - falso';
    }
    if ((int) $posSlash !== 0 && (int) $posQuery !== 0) {
        define('SKTURL_REQUEST_URI', $REQUEST_URI);
        $exp = explode('?', $REQUEST_URI);
        define('SKTURL_REQUEST_PARAMS', $exp[1]); 
        $exp = explode('/', $exp[0]);
        $expCount = count($exp) - 1;
        define('SKTURL_Here', $exp[$expCount]);
        //echo 'verdadero - verdadero';
    }
//    echo '<br>SKTURL_REQUEST_URI = ' . SKTURL_REQUEST_URI . '<br>';
//    echo 'SKTURL_REQUEST_PARAMS = ' . SKTURL_REQUEST_PARAMS . '<br>';
//    echo 'SKTURL_Here = ' . SKTURL_Here . '<br>';
//
//    exit();


    define('SKTURL_CmsDev', \SKTURL . 'CmsDev/' . \SKT_VERSION . '/');
    define('SKTURL_assets', \SKTURL . 'CmsDev/' . \SKT_VERSION . '.assets/');
    define('SKTURL_FileSystems', \SKTURL . '_FileSystems/');
    define('SKTURL_TemplateSite', \SKTURL . '_TemplateSite/' . \SKT_TEMPLATE . '/');

    $SKT['URL']['SERVER'] = \SITE_SERVER;
    $SKT['URL']['SUBSITE'] = \SKTURL;
    $SKT['URL']['BASE'] = \SKTURL;
    define('AssetsTheme', \SKTURL . '/_TemplateSite/NegociosEnRed/assets/');
// PHAR LOCATION CONFIG
    $SKT['Phar']['File'] = 'SKT_' . \SKT_VERSION . '.phar';
    $SKT['Phar']['Location'] = 'CmsDev/' . \SKT_VERSION . '/';
    $SKT['Phar']['Base'] = strpos($SKT['Phar']['Location'], '/CmsDev/' . \SKT_VERSION . '/');

    \define('LANGUAGE_DEF', $SKT['LANGUAGE']['LIST'][0]);
    \define('ASSETS', \SKTURL . 'CmsDev/' . \SKT_VERSION . '.assets/');
    \define('SERVER', \SKTURL);
    \define('SUBSITE', $SKT['URL']['SUBSITE']);
    \define("SKTURL_BASE", $SKT['URL']['BASE']);
    \define('BASE', \SKTURL);
    \define("SKT_SYS", \SKTURL_CmsDev);
    \define("SKT_TEMPLATE_DEFAULT", \SKTURL_BASE . '/_TemplateSite/NegociosEnRed');
    \define('PHARLOCATION', $SKT['Phar']['Location']);

    \define('SKT_ADMIN_AdminWraperOpen', utf8_encode('<div class="skt"><div id="dialog-form-Administrator"  title="[title]"><p class="validateTips text ui-corner-all">Complete los campos.</p>'));
    \define('SKT_ADMIN_AdminWraperClose', utf8_encode('</div></div>'));
}