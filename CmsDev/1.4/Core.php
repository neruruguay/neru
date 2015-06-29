<?php

require_once (dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'DefinePath.php');
$SKT_ValidateType = 0;
$isPage = FALSE;
$isHome = FALSE;
$isvalid = FALSE;
$isfile = TRUE;
$SKTAJAX = FALSE;
\define('RAND_GLOBAL_INSTANCE', \md5(\rand(5, 9999999) . \microtime()));
global $SKT;
require_once 'AutoLoad.php';
require_once 'util/functions.php';
spl_autoload_register('Autoloader::autoload');
$SKTDB = \CmsDev\Sql\db_Skt::connect();
include dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "_TemplateSite" . DIRECTORY_SEPARATOR . \SKT_TEMPLATE . DIRECTORY_SEPARATOR . "Config.php";

define('SKT_ThisLaguage', CmsDev\Language\CheckLanguage::get());
\CmsDev\Language\AdminGlosary::UpdateFromFile();
\CmsDev\Language\AdminGlosary::get();
\CmsDev\Language\SiteGlosary::UpdateFromFile();
\CmsDev\Language\SiteGlosary::get();
\CmsDev\Init\definedParams::get();
$SectionValues = \CmsDev\Content\Section::get();

if (isset($_GET['SKTGoTo']) || isset($_GET['SKTFiles']) || isset($_GET['SKTDir']) || isset($_GET['SKTFiles']) || isset($_GET['SKTFSys']) || isset($_GET['SKT_HELP'])) {
    $isvalid = TRUE;
    $SKTAJAX = TRUE;
    $isfile = FALSE;
}

$RequireInit = FALSE;
if ($SectionValues->URLName != '') {
    $isvalid = TRUE;
    $SKTAJAX = FALSE;
    $isPage = TRUE;
    $isfile = FALSE;
    $SKT_ValidateType = 'URLNAME=' . $SectionValues->URLName;
}


$SKT['SKTListFieldType'] = array("int" => '0', "varchar" => '1', "text" => '2', "link" => '3', "enum" => '4', "html" => '5', "Basic html" => '7', "date" => '6');
$SKT['SKTListFieldSize'] = 40;
$glob = \CmsDev\util\globals::init();
$glob->setVar('SKT', $SKT);
$glob->setVar('SKTADMIN', $SKT_ADMIN);
$glob->setVar('SKTListFieldType', $SKT['SKTListFieldType']);
$glob->setVar('SKTListFieldSize', $SKT['SKTListFieldSize']);



$RESTRICTED_SKT = $SKT['SITE']['RESTRICTED_URL'];
$EXT = strrpos(\SKTURL_Here, ".");
if (strpos(\SKTURL_REQUEST_URI, 'SKTGoTo') !== false) {
    $SKTAJAX = TRUE;
    $isfile = FALSE;
    $checkAction = new \CmsDev\SKTGoTo();
    $checkAction->checkAction($_GET['SKTGoTo']);
    exit();
}
if (strpos(\SKTURL_REQUEST_URI, 'SKTFSys') !== false) {
    $SKTAJAX = TRUE;
    $isfile = FALSE;
    $checkAction = new \CmsDev\SKTGoTo();
    $checkAction->checkAction($_GET['SKTFSys']);
    exit();
}
if (strpos(\SKTURL_REQUEST_URI, 'SKTFiles') !== false) {
    $SKTAJAX = TRUE;
    $isfile = FALSE;
    $checkAction = new \CmsDev\SKTGoTo();
    $checkAction->checkAction($_GET['SKTFiles']);
    exit();
}
if (strpos(\SKTURL_REQUEST_URI, 'SKTDir') !== false) {
    $SKTAJAX = TRUE;
    $isfile = FALSE;
    $checkAction = new \CmsDev\SKTGoTo();
    $checkAction->checkAction($_GET['SKTDir']);
    exit();
}
if (strpos(\SKTURL_REQUEST_URI, 'SKT_HELP') !== false) {
    $SKTAJAX = TRUE;
    $isfile = FALSE;
    $Page = isset($_GET['Page']) ? $_GET['Page'] : 'Introduccion';
    if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
        require_once(dirname(__FILE__) . '/help/help.php');
    }
    exit();
}
if (strpos(\SKTURL_REQUEST_URI, '_thumb_') !== false) {
    $DecodedURL = 0;
    $e2 = dirname(dirname(dirname(__FILE__))) . DS . '_FileSystems/FlyTrumb.php';
    require_once($e2);
    exit();
}
if (strpos(\SKTURL_REQUEST_URI, 'SKTSize') !== false) {
    $DecodedURL = 1;
    $e2 = dirname(dirname(dirname(__FILE__))) . DS . '_FileSystems/FlyTrumb.php';
    require_once($e2);
    exit();
}
if ((\SKTURL_Here == '' && $EXT == '') || (\in_array(\SKTURL_Here, $SKT['LANGUAGE']['LIST']) ) || ($_SERVER['REQUEST_URI'] === '/') || ($_SERVER['REQUEST_URI'] === \SKTURL )) {
    $isvalid = TRUE;
    $isPage = TRUE;
    $isHome = TRUE;
    $isfile = FALSE;
    $SKT_ValidateType .= '*IS_HOME';
}
if (\in_array(\SKTURL_Here, $RESTRICTED_SKT) || \in_array($_SERVER['REQUEST_URI'], $RESTRICTED_SKT)) {
    $isvalid = TRUE;
    $isfile = FALSE;
    $SKT_ValidateType .= '*RESTRICTED';
}

if ($SKTAJAX == FALSE && $isvalid == TRUE) {
    $RequireInit = TRUE;
    $isfile = FALSE;
    $SKT_ValidateType .= '*SKTAJAX=FALSE';
}
if ($isPage == TRUE) {
    $RequireInit = TRUE;
    $isfile = FALSE;
    $SKTAJAX = FALSE;
    $SKT_ValidateType .= '*IS_PAGE';
}
if ($isHome == TRUE) {
    $RequireInit = TRUE;
    $isfile = FALSE;
    $SKTAJAX = FALSE;
    $SKT_ValidateType .= '*IS_HOME=TRUE';
}
if (\in_array($_SERVER['REQUEST_URI'], $SKT['SITE']['RESTRICTED_URL'])) {
    $RequireInit = TRUE;
    $isfile = FALSE;
    $SKT_ValidateType .= '*RESTRICTED=TRUE';
}
if ($RequireInit === TRUE) {
    $isfile = FALSE;
    $SKT_ValidateType .= '*IS_REQUIRED';
}
if ($SKTAJAX == FALSE && $isvalid == FALSE) {
    if (!defined("error")) {
        define('error', 'error404');
    }
    $SKT_ValidateType .= '*IS_404';
    $isfile = FALSE;
}
if ($SKTAJAX == FALSE) {
    $SKT_ValidateType .= '*SKTAJAX=FALSE';
    $isfile = FALSE;
}

\define('SKT_ValidateType', $SKT_ValidateType);
\define('SKT_isvalid', intval($isvalid));
\define('SKT_isPage', intval($isPage));
\define('SKT_isHome', intval($isHome));
\define('SKT_isFile', intval($isfile));
\define('SKT_EXT', intval($EXT));
\define('SKT_SKTAJAX', intval($SKTAJAX));

function ShowValdatePageType() {
    $PATH = 'SKT_PageTemplate = ' . \TemplateCustom . '<br>';
    $PATH .= 'SKT_ValidateType = ' . \SKT_ValidateType . '<br>';
    $PATH .= 'SKT_isvalid = ' . \SKT_isvalid . '<br>';
    $PATH .= 'SKT_isPage = ' . \SKT_isPage . '<br>';
    $PATH .= 'SKT_isHome = ' . \SKT_isHome . '<br>';
    $PATH .= 'SKT_isFile = ' . \SKT_isFile . '<br>';
    $PATH .= 'SKT_EXT = ' . \SKT_EXT . '<br>';
    $PATH .= 'SKT_SKTAJAX = ' . \SKT_SKTAJAX . '<br>';
    return $PATH;
}

if ($RequireInit === TRUE) {
    require_once 'Init/init.php';
}
?>