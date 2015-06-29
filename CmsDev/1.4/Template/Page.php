<?php

/**
 * Description of Template
 *
 * @author Mart�n Daguerre
 */

namespace CmsDev\Template;

use \CmsDev\Info as SKT_INFO;

class Page {

    public static $TemplateSite;
    public static $TemplatePage;

    public static function render() {
        $SectionValues = \CmsDev\Content\Section::get();

        $Template = $SectionValues->Template;
        if ($Template === '') {
            $Template = 'home';
        }
        /* ------------------------------------------------------------------------------- */
        /* -------------------------  LOAD SEARCH ENGINE  -------------------------------- */
        /* ------------------------------------------------------------------------------- */

        if (\SKTURL_Here == 'Google_Search') {
            $Template = 'System/Google_Search';
            $LoadTemplate = \SKTPATH_TemplateSite . 'SKT_Theme_Pages/System/Google_Search.php';
        }
        /* ------------------------------------------------------------------------------- */
        /* -------------------------  LOGIN AS ADMINISTRATOR  ---------------------------- */
        /* ------------------------------------------------------------------------------- */
        if (\SKTURL_Here === 'admin' or \SKTURL_Here === 'admin?invalid-admin' or \SKTURL_Here === 'admin') {
            if ((isset($_POST['SKT_AdminName']) && isset($_POST['SKT_AdminPassword']))) {
                $checkAction = \CmsDev\Security\loginIntent::checkAction('Admin');
            }
            $Template = 'System/admin';
        }
        if (isset($_GET['invalid-admin'])) {
            $MessageBox = SKT_INFO\Asistance::get();
            $MessageBox->TipError(\SKT_ADMIN_User_Invalid, true);
            $Template = 'System/admin';
        }
        if (\THIS_URL_REAL === 'CloseAdmin') {
            $checkAction = \CmsDev\Security\loginIntent::checkAction('close');
            exit();
        }
        /* ------------------------------------------------------------------------------- */
        /* -------------------------  USERS, LOGIN, REGISTER, CONNECT -------------------- */
        /* ------------------------------------------------------------------------------- */
        if (\SKTURL_Here === 'UserProfile') {
            $Template = 'System/Profile';
        }
        if (\SKTURL_Here === 'UserRegistration') {
            $Template = 'System/NewUser';
        }
        if (\SKTURL_Here === 'PasswordRecovery') {
            $Template = 'System/PasswordRecovery';
        }
        if (\SKTURL_Here === 'UserLogin' || \THIS_URL_REAL == 'UserLogin?invalid-user') {
            $Template = 'System/user';
        }
        if (\SKTURL_Here === 'ValidateUser') {
            $Template = 'System/ValidateUser';
        }
        if (\SKTURL_Here === 'UserLogout') {
            $checkAction = \CmsDev\Security\loginIntent::checkAction('close');
            exit();
        }
        if (\SKTURL_Here === 'index.php' || \THIS_URL_REAL === '?logout') {
            \CmsDev\Header\refresh::refreshNow(\SERVER_DIR);
            exit();
        }
        if (\THIS_URL_REAL === 'login_with_facebook') {
            \CmsDev\Header\refresh::refreshNow(\SERVER_DIR . '?login_with_facebook');
            exit();
        }
        if (isset($_POST['SKT_UserName']) && isset($_POST['SKT_Password'])) {
            \CmsDev\Security\loginIntent::checkAction('login');
        }
        if (isset($_GET['invalid-user'])) {
            $MessageBox = SKT_INFO\Asistance::get();
            $MessageBox->TipError(\SKT_ADMIN_User_Invalid, true);
        }
        if (defined("error")) {
            if (\error == 'error500') {
                $Template = 'System/500';
            } elseif (\error == 'error404') {
                $Template = 'System/404';
            } elseif (\error == 'error403') {
                $Template = 'System/403';
            }
        }
        if (isset($_GET['usr'])) {
            $Template = 'System/Company';
        }
        if (isset($_GET['empresas'])) {
            $Template = 'Empresas';
        }
        if (isset($_GET['Detail'])) {
            $Template = 'System/Detail';
        }
        if (isset($_GET['Type']) && $_GET['Type'] == 'Search') {
            $Template = 'System/Search';
            $LoadTemplate = \SKTPATH_TemplateSite . 'SKT_Theme_Pages/System/Search.php';
        }
        /* ------------------------------------------------------------------------------- */
        /* -------------------------  LOAD DYNAMIC SECTION  ------------------------------ */
        /* ------------------------------------------------------------------------------- */
        if (!isset($_GET['SKTGoTo']) && !isset($_GET['SKTFiles']) && !isset($_GET['SKTDir']) && !isset($_GET['SKTFiles']) && !isset($_GET['SKTFSys'])) {
            if (\is_file(\SKTPATH_TemplateSite . 'SKT_Theme_Pages/' . $Template . '.php')) {
                include(\SKTPATH_TemplateSite . 'SKT_Theme_Pages/' . $Template . '.php');
            } else {
                echo \SKTPATH_TemplateSite . 'SKT_Theme_Pages/' . $Template . '.php';
                include(\SKTPATH_TemplateSite . 'SKT_Theme_Pages/System/500.php');
            }
        }
    }

}

?>
