<?php

/**
 * Description of loginIntent
 *
 * @author Martín Daguerre
 */

namespace CmsDev\Security;

use \CmsDev\sql\db_Skt as SKT_DB;
use \CmsDev\Info as SKT_INFO;

class loginIntent {

    public static function checkAction($validate = 'validate') {
        global $SKT_ADMIN;
        if ($validate === 'close' || $validate === 'CloseAdmin') {
            self::action('close');
        } elseif ((isset($_POST['SKT_UserName']) && isset($_POST['SKT_Password'])) or $validate === 'login') {
            self::action('login');
        } elseif ((isset($_POST['SKT_AdminName']) && isset($_POST['SKT_AdminPassword'])) or $validate === 'Admin') {
            self::action('Admin');
        } elseif ($validate === 'validateAdmin') {
            self::action('validateAdmin');
        } elseif ($validate === 'validateUser' or $validate === 'validate') {
            self::action('validateUser');
        } else {
            self::action('validateUser');
        }
    }

    public static function action($a = '', $selfAction = '', $arguments = '') {
        $confirm = '';
        $session = '';
        $Request = new \CmsDev\Url\Request();
        $All = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : $_SERVER['REQUEST_URI'];
        //echo $All;
        //exit();
        $find = array('/CloseAdmin', '/admin?invalid-admin', '/admin', '/UserLogin', '/UserLogin?invalid-user', '/UserLogout');
        $LOCATION = str_replace($find, '', $All);

        if ($a === 'close' || $a === 'CloseAdmin') {
            if (!isset($_SESSION)) {
                session_start();
            }
            unset($_SESSION['AccessLevel']);
            $_SESSION['language'] = THIS_LANG;
            unset($_SESSION['View_DesignCMS']);
            $_SESSION['login'] = '';
            $_SESSION['sktlogin'] = '';
            unset($_SESSION['UserID']);
            unset($_SESSION['UserName']);
            //$_SESSION['token'] = '';
            $_SESSION['SKTVersion'] = \URL_VERSION;
            $header = $LOCATION;
            \CmsDev\Header\refresh::refreshNow(\SERVER_DIR);
        } else {

            $SKTDBadmin = SKT_DB::connect();
            if ($a === 'Admin') {
                $MessageBox = SKT_INFO\Asistance::get();
                //$MessageBox->TipInfo('Administrador: ' . $_POST["SKT_AdminName"] . ' - ' . $_POST["SKT_AdminPassword"]);
                $user_list = $SKTDBadmin->get_row("SELECT UserName,Password,md5,id, AccessLevel
                    FROM admin 
                    WHERE UserName = " . \GetSQLValueString($_POST["SKT_AdminName"], 'text') . " AND Password = " . \GetSQLValueString($_POST["SKT_AdminPassword"], 'text') . "");
                if ($user_list) {
                    $session = md5(
                            $user_list->UserName .
                            $user_list->Password
                    );
                    $confirm = 'ok';
                    $_SESSION['language'] = THIS_LANG;
                    $_SESSION['View_DesignCMS'] = 0;
                    $_SESSION['sktlogin'] = $session;
                    $_SESSION['UserID'] = $user_list->id;
                    $_SESSION['AccessLevel'] = $user_list->AccessLevel;
                    $_SESSION['UserName'] = $user_list->UserName;
                    $_SESSION['SKTVersion'] = \URL_VERSION;

                    $header = $LOCATION;
                    \CmsDev\Header\refresh::refreshNow(\SERVER_DIR);
                } else {
                    $confirm = 'error';
                    $LoggedInAdmin = 0;
                    $_SESSION['language'] = THIS_LANG;
                    unset($_SESSION['View_DesignCMS']);
                    $_SESSION['sktlogin'] = '';
                    unset($_SESSION['UserID']);
                    unset($_SESSION['AccessLevel']);
                    $_SESSION['UserName'] = \SKT_ADMIN_TXT_anonymous;
                    $_SESSION['SKTVersion'] = \URL_VERSION;

                    $MessageBox = SKT_INFO\Asistance::get();
                    $MessageBox->TipError(\SKT_ADMIN_User_Invalid . \SKT_ADMIN_User_max_attempts . \SKT_ADMIN_User_max_attempts_TXT);

                    $header = \SKTURL . '?invalid-admin';
                    \CmsDev\Header\refresh::refreshNow($header);
                }
            }
            if ($a === 'login') {
                $user_list = $SKTDBadmin->get_row("SELECT *
                    FROM users 
                    WHERE username = " . \GetSQLValueString($_POST["SKT_UserName"], 'text') . " AND password = " . \GetSQLValueString(md5($_POST["SKT_Password"]), 'text') . "");
                if ($user_list) {
                    if ($user_list->isactive == 0) {
                        \CmsDev\Header\refresh::refreshNow(\SKTURL . 'ValidateUser?username=' . $user_list->username);
                        exit();
                    }
                    $session = md5(
                            $user_list->username .
                            $user_list->password
                    );
                    $_SESSION['login'] = $session;
                    $_SESSION['UserIDU'] = $user_list->id;
                    $SKTDBadmin->query(sprintf("UPDATE users SET md5 = %s WHERE ID = %s", \GetSQLValueString($session, "text"), \GetSQLValueString($user_list->id, 'int')));
                    $header = $LOCATION;
                    \CmsDev\Header\refresh::refreshNow($header);
                } else {
                    $header = \SKTURL . '?invalid-user';
                    \CmsDev\Header\refresh::refreshNow($header);
                }
            }

            if ($a === 'validateAdmin') {
                if (isset($_SESSION['sktlogin']) && $_SESSION['sktlogin'] != '') {
                    $user_list = $SKTDBadmin->get_var("SELECT md5 FROM admin WHERE md5 = " . \GetSQLValueString($_SESSION['sktlogin'], 'text') . "");
                    if ($user_list === $_SESSION['sktlogin']) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
            if ($a === 'validateUser') {
                if (isset($_SESSION['login']) && $_SESSION['login'] != '') {
                    $user_list = $SKTDBadmin->get_var("SELECT md5 FROM users WHERE md5 = " . \GetSQLValueString($_SESSION['login'], 'text') . "");
                    if ($user_list == $_SESSION['login']) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
            if ($a === 'validate') {
                if (self::action('validateAdmin') == true || self::action('validateUser') == true) {
                    if ($selfAction !== '' && $arguments !== '') {
                        return self::selfAction($selfAction, $arguments);
                    } else {
                        return true;
                    }
                } else {
                    return false;
                }
            }
        }
    }

    private static function selfAction($selfAction = '', $arguments = '') {
        switch ($selfAction) {
            case 'SelfUser':
                return self::SelfUser($arguments);
                break;
            case 'DataSelfUser':
                return self::SelfUser($arguments, true);
                break;
            default:
                return true;
                break;
        }
    }

    private static function SelfUser($id = '', $Data = false) {
        //if (self::action('validateUser') == true) {
        $SKTDBadmin = SKT_DB::connect();
        $Self = $SKTDBadmin->get_var("SELECT id FROM users WHERE md5 = " . \GetSQLValueString($_SESSION['login'], 'text') . "");
        if ($Self === $id) {
            if ($Data == true) {
                $SelfData = $SKTDBadmin->get_row("SELECT * FROM users WHERE md5 = " . \GetSQLValueString($_SESSION['login'], 'text') . "");
                return $SelfData;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

}

?>
