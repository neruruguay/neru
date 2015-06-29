<?php

/**
 * Description of PersonMarkup
 *
 * @author Mart�n Daguerre
 */

namespace CmsDev\Security;

use \CmsDev\sql\db_Skt as SKT_DB;

class UserBoxActions {

    public function Render($SocialRegister = false) {
        $SKT = \CmsDev\util\globals::getVar('SKT');
        $TPL = \ltrim(\LOCAL_DIR . \SKTURL_TemplateSite . '/SKT_Theme_Parts/PersonMarkupUser.tpl');
        $SKT_TPL = \ltrim(\SKT_SYS . '/SKT_Theme_Parts/PersonMarkupUser.tpl', '/');
        $TPLCSS = \ltrim(\LOCAL_DIR . \SKTURL_TemplateSite . '/SKT_Theme_Parts/PersonMarkupUser.css');
        $SKT_TPLCSS = \ltrim(\SKT_SYS . '/css/PersonMarkupUser.css', '/');
        if (file_exists($TPL)) {
            $personMarkupTPL = \file_get_contents($TPL);
        } else {
            $personMarkupTPL = \file_get_contents($SKT_TPL);
        }
        if (file_exists($TPLCSS)) {
            $CSS = '<link rel="stylesheet" type="text/css" href="' . \SKTURL_TemplateSite . '/SKT_Theme_Parts/PersonMarkupUser.css" media="all"/>';
        } else {
            $CSS = '<link rel="stylesheet" type="text/css" href="' . \SKT_SYS . '/css/PersonMarkupUser.css" media="all"/>';
        }
        if ($SocialRegister == "SocialRegister") {
            $personMarkupTPL = '<a class="ConnectGoogle sktToolTip btn btn-danger" title="{GoogleLoginTitle}" href="{GoogleLoginLink}"><i class="skt-icon-google-plus"></i> {GoogleLoginText}</a>';
        }
        $USER_EXIST = \CmsDev\Security\loginIntent::action('validateUser');
        $Markup_Google = new \CmsDev\google\oauth();
        $googleUser = $Markup_Google->GoogleUser();
        if ($googleUser == true) {
            $USER_EXIST = true;
        }
        if ($USER_EXIST == true) {
            if ($SKT['Access']['GenericUser'] == 1) {
                $Build = $this->GenericUser(true, $personMarkupTPL);
            }
            if ($SKT['Access']['Google'] == 1) {
                $Build = $this->Google(true, $Build);
            }
            if ($SKT['Access']['Facebook'] == 1) {
                $Build = $this->Facebook(true, $Build);
            }
            $personMarkupTPL = $Build;
            if (!defined('TypeUser')) {
                define('TypeUser', 'Customers');
            }
            if (\TypeUser == 'Customers') {
                $personMarkupTPL = \SKTremoveTags('sktSell', $personMarkupTPL);
                $personMarkupTPL = \SKTremoveTags('sktUserOptions', $personMarkupTPL);
            } else {
                $personMarkupTPL = \SKTremoveTags('sktUserOptionsCustomer', $personMarkupTPL);
            }
            $personMarkupTPL = \str_replace('{InitSessionBotton}', $SKT['TXT_Hi'] . $_SESSION['UserName'], $personMarkupTPL);
            $personMarkupTPL = \str_replace('{Avatar}', \SKTServerURL . 'SKTSize/avatar.png?30', $personMarkupTPL);

            $personMarkupTPL = \SKTreplaceTags('sktgenericuseraccess', '', $personMarkupTPL, 1, 0);
            $personMarkupTPL = \SKTreplaceTags('sktfacebookaccess', '', $personMarkupTPL, 1, 0);
            $personMarkupTPL = \SKTreplaceTags('sktgoogleaccess', '', $personMarkupTPL, 1, 0);
            $personMarkupTPL = \SKTreplaceTags('sktAvatar', '', $personMarkupTPL, 1, 0);
            $personMarkupTPL = \SKTreplaceTags('sktUserOptions', '', $personMarkupTPL, 1, 0);
            $personMarkupTPL = \SKTreplaceTags('sktUserOptionsCustomer', '', $personMarkupTPL, 1, 0);
            $personMarkupTPL = \SKTreplaceTags('sktSell', '', $personMarkupTPL, 1, 0);
            $personMarkupTPL = \SKTremoveTags('sktloginoptions', $personMarkupTPL);
            return $CSS . $personMarkupTPL;
        } else {
            $personMarkupTPL = SKTremoveTags('sktUserOptions', $personMarkupTPL);
            $personMarkupTPL = \SKTreplaceTags('sktavataranon', '', $personMarkupTPL, 1, 0);
            $personMarkupTPL = \SKTreplaceTags('sktloginoptions', '', $personMarkupTPL, 1, 0);
            $personMarkupTPL = \SKTreplaceTags('sktgenericuseraccess', '', $personMarkupTPL, 1, 0);
            $personMarkupTPL = \SKTreplaceTags('sktfacebookaccess', '', $personMarkupTPL, 1, 0);
            $personMarkupTPL = \SKTreplaceTags('sktgoogleaccess', '', $personMarkupTPL, 1, 0);

            $personMarkupTPL = SKTremoveTags('sktAvatar', $personMarkupTPL);
            $personMarkupTPL = \str_replace('{InitSessionBotton}', $SKT['TXT_Hi'] . $SKT['TXT_anonymous'], $personMarkupTPL);
            $personMarkupTPL = \str_replace('{Avatar}', \SKTServerURL . 'SKTSize/avatar.png?30', $personMarkupTPL);


            if ($SKT['Access']['Google'] == 1) {
                $Build = $this->Google(false, $Build);
            } elseif ($SKT['Access']['Facebook'] == 1) {
                $Build = $this->Facebook(false, $Build);
            } elseif ($SKT['Access']['GenericUser'] == 1) {
                $Build = $this->GenericUser(false, $personMarkupTPL);
            } else {
                
            }
            $personMarkupTPL = \SKTreplaceTags('sktloginoptions', $this->Markup_GenericUser . $this->Markup_Google . $this->Markup_Facebook, $personMarkupTPL, 1, 0);
            $personMarkupTPL = $Build;
            echo $CSS . \CmsDev\skt_Code::Charset($personMarkupTPL);
        }
    }

    private function GenericUser($PreValidate = false, $personMarkupTPL) {
        $querySession = '';
        if ($PreValidate === true) {
            $SKTDB = SKT_DB::connect();
            if (isset($_SESSION['UserID'])) {
                $querySession = "user.password = " . \GetSQLValueString($_SESSION['UserID'], 'text') . " AND";
            } elseif (isset($_SESSION['login'])) {
                $querySession = "user.md5 = " . \GetSQLValueString($_SESSION['login'], 'text') . " AND";
            } else {
                $querySession = '';
            }

            $user_list = $SKTDB->get_row("SELECT *
                    FROM users as user, userprofile as profile 
                    WHERE " . $querySession . " profile.IDX = user.id ");
            if ($user_list) {
                $query = $SKTDB->get_col_info();
                foreach ($query as $name) {
                    $this->$name = $user_list->$name;
                }
                $History = new \CmsDev\Info\history($this->IDX, $_SERVER, $_POST, $_GET);

                $GenericUser = $personMarkupTPL;
                $ProfileLink = \SKTServerURL . 'UserProfile';
                if ($this->ClientAuth_picture != '') {
                    $GenericUser = \str_replace('{Avatar}', $this->ClientAuth_picture, $GenericUser);
                }
                if ($this->ClientAuth != '') {
                    $GenericUser = \str_replace('{ServiceProvider}', $this->ClientAuth, $GenericUser);
                    $GenericUser = \str_replace('{NameTitle}', \SKT_ADMIN_TXT_GotoProfileOn . $this->ClientAuth, $GenericUser);
                }
                if ($this->ClientAuth_link != '') {
                    $ProfileLink = $this->ClientAuth_link;
                    $GenericUser = \str_replace('{ProfileLink}', \SKTServerURL . 'UserProfile', $GenericUser);
                }
                if ($this->ClientAuth_name != '') {
                    $GenericUser = \str_replace('{NameText}', $this->ClientAuth_name, $GenericUser);
                }
                $MessagerCount = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Messenger\_classes();
                $MessagerCountNum = $MessagerCount->MessagerCountUnread($this->IDX);
                $urlRef = $this->CompanyUrl;
                if ($this->Type == 'Customers') {
                    $stringValid = str_replace('%3D', '', \CmsDev\skt_Code::Encode($this->username));
                    $urlRef = $stringValid;
                }

                if ($MessagerCountNum >= 1) {
                    $MessagerShow = '<li><a href="' . \SKTServerURL . 'usr/' . $this->IDX . '/' . $urlRef . '/Messager/" class="sktToolTip skt-icon-icon-email" title="Mensajes"> <span>Tiene <b class="badge">' . $MessagerCountNum . '</b> mensajes sin leer</span></a></li>';
                    $MessagerCountNumTop = '<b class="badge">' . $MessagerCountNum . '</b>';
                } else {
                    $MessagerShow = '<li><a href="' . \SKTServerURL . 'usr/' . $this->IDX . '/' . $urlRef . '/Messager/" class="sktToolTip skt-icon-icon-email" title="Mensajes"><span>Mensajes</span></a></li>';
                    $MessagerCountNumTop = '';
                }
                if (!defined('UserProfileLink')) {
                    define('UserProfileLink', \SKTServerURL . 'usr/' . $this->IDX . '/' . $urlRef . '/');
                }
                if (!defined('PublisherLink')) {
                    define('PublisherLink', \UserProfileLink . 'Publisher/');
                }
                if (!defined('EditLink')) {
                    define('EditLink', \UserProfileLink . 'Edit/');
                }
                if (!defined('DesignLink')) {
                    define('DesignLink', \UserProfileLink . 'Design/');
                }
                if (!defined('ResumenLink')) {
                    define('ResumenLink', \UserProfileLink . 'Resumen/');
                }
                if (!defined('HelpLink')) {
                    define('HelpLink', \UserProfileLink . 'Help/');
                }
                if (!defined('TypeUser')) {
                    define('TypeUser', $this->Type);
                }
                $ReplaceOnTemplate = array(
                    '{NameTitle}' => \SKT_ADMIN_TXT_ViewEditProfile,
                    '{NameText}' => $this->username,
                    '{NameLink}' => \UserProfileLink,
                    '{ProfileLink}' => \SKTServerURL . 'usr/' . $this->IDX . '/' . $urlRef . '/',
                    '{Messager}' => $MessagerShow,
                    '{MessagerCountTop}' => $MessagerCountNumTop,
                    '{ProfileText}' => \SKT_ADMIN_TXT_ConfigProfile,
                    '{ProfileTitle}' => \SKT_ADMIN_TXT_ConfigProfile,
                    '{LogoutLink}' => \SKTServerURL . 'UserLogout',
                    '{LogoutText}' => \SKT_ADMIN_TXT_LogoutText,
                    '{LogoutTitle}' => \SKT_ADMIN_TXT_LogoutText,
                    '{ServiceProvider}' => '',
                    '{ServiceProviderIcon}' => '<i class="skt-icon-config"></i>',
                    '{UserLoginLink}' => \SKTServerURL . 'UserLogin',
                    '{UserLoginTitle}' => \SKT_ADMIN_TXT_LoginText,
                    '{UserLoginText}' => \SKT_ADMIN_TXT_LoginText,
                    '{RegisterLink}' => \SKTServerURL . 'UserRegistration',
                    '{RegisterTitle}' => \SKT_ADMIN_TXT_Register,
                    '{RegisterText}' => \SKT_ADMIN_TXT_Register,
                    '{PublisherLink}' => \PublisherLink,
                    '{EditLink}' => \EditLink,
                    '{DesignLink}' => \DesignLink,
                    '{ResumenLink}' => \ResumenLink,
                    '{HelpLink}' => \HelpLink,
                    '{UserID}' => $this->id
                );

                $GenericUser = $personMarkupTPL = \str_replace(array_keys($ReplaceOnTemplate), array_values($ReplaceOnTemplate), $GenericUser);
            }
        } else {
            $GenericUser = \str_replace('{NameLinkTitle}', \SKT_ADMIN_TXT_ViewEditProfile, $personMarkupTPL);
            $GenericUser = \str_replace('{ProfileText}', \SKT_ADMIN_TXT_ViewEditProfile, $GenericUser);
            $GenericUser = \str_replace('{LogoutLink}', \SKTServerURL . 'UserLogout', $GenericUser);
            $GenericUser = \str_replace('{LogoutText}', \SKT_ADMIN_TXT_LogoutText, $GenericUser);
            $GenericUser = \str_replace('{ServiceProvider}', '', $GenericUser);
            $GenericUser = \str_replace('{ServiceProviderIcon}', '<i class="skt-icon-config"></i>', $GenericUser);
            $GenericUser = \str_replace('{UserLoginLink}', \SKTServerURL . 'UserLogin', $GenericUser);
            $GenericUser = \str_replace('{UserLoginTitle}', \SKT_ADMIN_TXT_LoginText, $GenericUser);
            $GenericUser = \str_replace('{UserLoginText}', \SKT_ADMIN_TXT_LoginText, $GenericUser);
            $GenericUser = \str_replace('{RegisterLink}', \SKTServerURL . 'UserRegistration', $GenericUser);
            $GenericUser = \str_replace('{RegisterTitle}', \SKT_ADMIN_TXT_Register, $GenericUser);
            $GenericUser = \str_replace('{RegisterText}', \SKT_ADMIN_TXT_Register, $GenericUser);
            $personMarkupTPL = $GenericUser;
        }
        return $personMarkupTPL;
    }

    private function Google($PreValidate = false, $personMarkupTPL) {
        $Markup_Google = new \CmsDev\google\oauth();
        $googleUser = $Markup_Google->GoogleUser();
        if ($googleUser == true) {
            $ProfileLink = \SKTServerURL . 'UserProfile';
            $Google = \str_replace('{ServiceProvider}', $Markup_Google->ServiceProviderImage, $personMarkupTPL);
            $GenericUser = \str_replace('{ServiceProviderIcon}', '<i class="skt-icon-google-plus"></i>', $GenericUser);
            $Google = \str_replace('{GoogleLoginLink}', $Markup_Google->createAuthUrl, $Google);
            $Google = \str_replace('{GoogleLoginTitle}', \SKT_ADMIN_TXT_ConnectTo . 'Google', $Google);
            $Google = \str_replace('{GoogleLoginText}', \SKT_ADMIN_TXT_ConnectTo . 'Google', $Google);
            $Google = \str_replace('{NameTitle}', \SKT_ADMIN_TXT_GotoProfileOn . $Markup_Google->ClientAuth, $Google);
            $Google = \str_replace('{NameLink}', $Markup_Google->Profile, $Google);
            $Google = \str_replace('{NameText}', $Markup_Google->name, $Google);
            $Google = \str_replace('{ProfileLink}', $ProfileLink, $Google);
            $Google = \str_replace('{ProfileText}', \SKT_ADMIN_TXT_ViewEditProfile, $Google);
            $Google = \str_replace('{LogoutLink}', \SKTServerURL . '?logout', $Google);
            $Google = \str_replace('{LogoutText}', \SKT_ADMIN_TXT_LogoutText, $Google);
            if ($Markup_Google->picture !== '') {
                $Google = \str_replace('{Avatar}', $Markup_Google->picture, $Google);
            }
            $personMarkupTPL = $Google;
            $SKTDB = SKT_DB::connect();
            $user_list = $SKTDB->get_row("SELECT *
                    FROM users as user join userprofile as profile 
                    ON profile.ClientAuth_id = " . \GetSQLValueString($Markup_Google->id, 'text') . "
                    WHERE user.id = profile.IDX 
            ");
            if ($user_list) {
                $session = md5(
                        $user_list->username .
                        $user_list->password
                );
                $_SESSION['login'] = $session;
                $History = new \CmsDev\Info\history($this->IDX, $_SERVER, $_POST, $_GET);
            }
        } else {
            $Google = \str_replace('{GoogleLoginLink}', $Markup_Google->createAuthUrl, $personMarkupTPL);
            $Google = \str_replace('{GoogleLoginTitle}', \SKT_ADMIN_TXT_ConnectTo . 'Google', $Google);
            $Google = \str_replace('{GoogleLoginText}', \SKT_ADMIN_TXT_ConnectTo . 'Google', $Google);
            $personMarkupTPL = $Google;
        }
        return $personMarkupTPL;
    }

    private function Facebook($PreValidate = false, $personMarkupTPL) {
        $Facebook = \str_replace('{FacebookLoginLink}', '/login_with_facebook', $personMarkupTPL);
        $Facebook = \str_replace('{FacebookLoginTitle}', \SKT_ADMIN_TXT_ConnectTo . 'Facebook', $Facebook);
        $Facebook = \str_replace('{FacebookLoginText}', \SKT_ADMIN_TXT_ConnectTo . 'Facebook', $Facebook);
        $personMarkupTPL = $Facebook;
        return $personMarkupTPL;
    }

}

?>
