<?php

/**
 * Description of UserGoogleRegister
 * 
 * @author Mart&iacute;n Daguerre
 */

namespace CmsDev\Security;

use \CmsDev\Info as SKT_INFO;
use \CmsDev\skt_Code as Code;

class UserRegister {

    public static $user_list;

    public static function checkAction($Info = array()) {
        if (!isset($_SESSION['login'])) {
            if (isset($Info['ClientAuth']) && $Info['ClientAuth'] = "Google") {
                self::MakeNewUser('FromGoogle', $Info);
            } else if (isset($Info['ClientAuth']) && $Info['ClientAuth'] = "Facebook") {
                self::MakeNewUser('FromFacebook', $Info);
            } else {
                self::MakeNewUser('FromSite', $Info);
            }
        }
    }

    private static function MakeNewUser($Client = false, $Info = array(), $LevelType = 'Customers') {

        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $new_Google = false;
        $new_Facebook = false;
        $CheckUserName = new \CmsDev\util\CheckUserName();
        $username = Code::Charset(isset($Info['username']) ? $Info['username'] : '');
        $password = md5(isset($Info['password']) ? $Info['password'] : '');
        $email = Code::Charset(isset($Info['email']) ? $Info['email'] : '');
        $isactive = isset($Info['isactive']) ? $Info['isactive'] : 0;
        $activekey = isset($Info['activekey']) ? $Info['activekey'] : 0;
        $resetkey = isset($Info['resetkey']) ? $Info['resetkey'] : 0;
        $cust_no = isset($Info['cust_no']) ? $Info['cust_no'] : 0;
        $md5 = isset($Info['md5']) ? $Info['md5'] : md5($username) . $password;
        $Description = isset($Info['Description']) ? $Info['Description'] : '';
        $Lat = isset($Info['Lat']) ? $Info['Lat'] : '-35';
        $Lon = isset($Info['Lon']) ? $Info['Lon'] : '-54';
        $zoom = isset($Info['zoom']) ? $Info['zoom'] : '12';
        $Type = isset($Info['Type']) ? $Info['Type'] : $LevelType;
        $website = isset($Info['website']) ? $Info['website'] : '';
        $ViewHelp = isset($Info['ViewHelp']) ? $Info['ViewHelp'] : 0;
        $token = isset($Info['token']) ? $Info['token'] : '';
        $Company = isset($Info['Company']) ? $Info['Company'] : $Info["username"];
        $CompanyUrl = isset($Info['CompanyUrl']) ? $Info['CompanyUrl'] : $CheckUserName->Fix($username);
        $Level = isset($Info['level']) ? $Info['level'] : $Type;
        $RUT = isset($Info['RUT']) ? $Info['RUT'] : '';
        $Position = isset($Info['Position']) ? $Info['Position'] : '';
        $Name = isset($Info['Name']) ? $Info['Name'] : '';
        $Surname = isset($Info['Surname']) ? $Info['Surname'] : '';
        $Country = isset($Info['Country']) ? $Info['Country'] : '';
        $City = isset($Info['City']) ? $Info['City'] : '';
        $CP = isset($Info['CP']) ? $Info['CP'] : '';
        $Address = isset($Info['Address']) ? $Info['Address'] : '';
        $From = isset($Info['From']) ? $Info['From'] : '09';
        $To = isset($Info['To']) ? $Info['To'] : '18';
        $Phone = isset($Info['Phone']) ? $Info['Phone'] : '';
        $payment_method = isset($Info['payment_method']) ? $Info['payment_method'] : '';
        $ClientAuth = isset($Info['ClientAuth']) ? $Info['ClientAuth'] : '';
        $ClientAuth_id = isset($Info['ClientAuth_id']) ? $Info['ClientAuth_id'] : '';
        $ClientAuth_link = isset($Info['ClientAuth_link']) ? $Info['ClientAuth_link'] : '';
        $ClientAuth_name = isset($Info['ClientAuth_name']) ? $Info['ClientAuth_name'] : '';
        $ClientAuth_family_name = isset($Info['ClientAuth_family_name']) ? $Info['ClientAuth_family_name'] : '';
        $ClientAuth_given_name = isset($Info['ClientAuth_given_name']) ? $Info['ClientAuth_given_name'] : '';
        $ClientAuth_email = isset($Info['ClientAuth_email']) ? $Info['ClientAuth_email'] : '';
        $ClientAuth_picture = isset($Info['ClientAuth_picture']) ? $Info['ClientAuth_picture'] : '';
        $ClientAuth_locale = isset($Info['ClientAuth_locale']) ? $Info['ClientAuth_locale'] : '';
        $ClientAuth_gender = isset($Info['ClientAuth_gender']) ? $Info['ClientAuth_gender'] : '';
        $category1 = isset($Info['category1']) ? $Info['category1'] : '';
        $category2 = isset($Info['category2']) ? $Info['category2'] : '';
        $category3 = isset($Info['category3']) ? $Info['category3'] : '';
        $category4 = isset($Info['category4']) ? $Info['category4'] : '';
        $category5 = isset($Info['category5']) ? $Info['category5'] : '';

        if ($Client == 'FromGoogle') {
            /* ----------------------------------------------------------------------/// FromGoogle ///-------------- */
            $Name = $Info['name'];
            $Surname = $Info['family_name'];
            $ClientAuth = $Info['ClientAuth'];
            $ClientAuth_id = $Info['id'];
            $ClientAuth_link = $Info['link'];
            $ClientAuth_name = $Info['name'];
            $ClientAuth_family_name = $Info['family_name'];
            $ClientAuth_given_name = $Info['given_name'];
            $ClientAuth_email = $Info['email'];
            $ClientAuth_picture = $Info['picture'];
            $ClientAuth_locale = $Info['locale'];
            $ClientAuth_gender = $Info['gender'];
            $username = Code::Encode($Info['given_name']);
            $password = md5($Info['id']);
            $email = $Info['email'];
            $isactive = 1;
            $md5 = md5($username . $password);
            $Company = $Info['name'];
            $CompanyUrl = $CheckUserName->Fix($Info['name']);
            $Type = 'Customers';
            $user_listQuery = "SELECT *
                    FROM users as user, userprofile as profile
                    WHERE user.id = profile.IDX AND profile.ClientAuth = 'Google' AND profile.ClientAuth_id = " . \GetSQLValueString($Info["id"], 'text') . "";
            $user_list = $SKTDB->get_row($user_listQuery);
            $MessageBox = SKT_INFO\Asistance::get();
            $MessageBox->TipInfo('<b>' . $Name . '.</b><br><pre>' . $user_listQuery . '</pre><pre>' . $user_list->username . '</pre>', false);
            if ($user_list) {
                $_SESSION['UserName'] = $user_list->username;
                $session = md5(
                        $user_list->username .
                        $user_list->password
                );
                $_SESSION['login'] = $session;
                $_SESSION['UserIDU'] = $user_list->id;
                $new_Google = false;
                $header = \SERVER_DIR;
                \CmsDev\Header\refresh::refreshNow(\SITE_SERVER);
                exit();
            } else {
                $new_Google = true;
            }
            /* ------------------------------------------------------------------------------------------------------ */
        } else if ($Client == 'FromFacebook') {
            /* --------------------------------------------------------------------/// FromFacebook ///-------------- */

            /* ------------------------------------------------------------------------------------------------------ */
        } else {
            
        }
        if ($Client == 'FromSite' || $new_Google == true || $new_Facebook == true) {
            if ($username != '' || !isset($_SESSION['login'])) {
                $test = $SKTDB->get_var("SELECT id FROM users WHERE username = " . \GetSQLValueString($username, 'text') . "");
                if (!$test) {
                    $insertUserQuery = "INSERT INTO users 
                        ( username, password, email, CompanyUrl, isactive, activekey, resetkey, cust_no, Lat, Lon, zoom, md5, Type ) 
			VALUES (" .
                            GetSQLValueString($username, "text") . "," .
                            GetSQLValueString($password, "text") . "," .
                            GetSQLValueString($email, "text") . "," .
                            GetSQLValueString($CompanyUrl, "text") . "," .
                            GetSQLValueString($isactive, "int") . "," .
                            GetSQLValueString($activekey, "int") . "," .
                            GetSQLValueString($resetkey, "int") . "," .
                            GetSQLValueString($cust_no, "int") . "," .
                            GetSQLValueString($Lat, "text") . "," .
                            GetSQLValueString($Lon, "text") . "," .
                            GetSQLValueString($zoom, "int") . "," .
                            GetSQLValueString($md5, "text") . "," .
                            GetSQLValueString($Type, "text") . ")";
                    $insertUser = $SKTDB->query($insertUserQuery);
                    if ($insertUser) {
                        $FotoPerfil = '';
                        $insertUserID = $SKTDB->insert_id;
                        if (!isset($Info['FotoPerfil']) || $Info['picture'] === '') {
                            $FotoPerfil = \SKT_ACCESS_AVATAR;
                        } else {
                            $FotoPerfil = $Info['FotoPerfil'];
                        }
                        if ($new_Google == true) {
                            $FotoPerfil = $ClientAuth_picture;
                        }
                        $insertProfile = $SKTDB->query("INSERT INTO userprofile 
                            (IDX, level, Name, Surname, Company, RUT, Position, Country, City, CP, Address, eFrom, eTo, Phone, payment_method, 
                            ClientAuth,ClientAuth_id,ClientAuth_link,ClientAuth_name,ClientAuth_family_name,ClientAuth_given_name,ClientAuth_email,ClientAuth_picture,ClientAuth_locale, ClientAuth_gender)
                            VALUES (" .
                                GetSQLValueString($insertUserID, "int") . "," .
                                GetSQLValueString($Level, "text") . "," .
                                GetSQLValueString(Code::Charset($Name), "text") . "," .
                                GetSQLValueString(Code::Charset($Surname), "text") . "," .
                                GetSQLValueString(Code::Charset($Company), "text") . "," .
                                GetSQLValueString(Code::Charset($RUT), "text") . "," .
                                GetSQLValueString(Code::Charset($Position), "text") . "," .
                                GetSQLValueString(Code::Charset($Country), "text") . "," .
                                GetSQLValueString(Code::Charset($City), "text") . "," .
                                GetSQLValueString(Code::Charset($CP), "text") . "," .
                                GetSQLValueString(Code::Charset($Address), "text") . "," .
                                GetSQLValueString(Code::Charset($From), "text") . "," .
                                GetSQLValueString(Code::Charset($To), "text") . "," .
                                GetSQLValueString(Code::Charset($Phone), "text") . "," .
                                GetSQLValueString(Code::Charset($payment_method), "text") . "," .
                                GetSQLValueString(Code::Charset($ClientAuth), "text") . "," .
                                GetSQLValueString(Code::Charset($ClientAuth_id), "text") . "," .
                                GetSQLValueString(Code::Charset($ClientAuth_link), "text") . "," .
                                GetSQLValueString(Code::Charset($ClientAuth_name), "text") . "," .
                                GetSQLValueString(Code::Charset($ClientAuth_family_name), "text") . "," .
                                GetSQLValueString(Code::Charset($ClientAuth_given_name), "text") . "," .
                                GetSQLValueString(Code::Charset($ClientAuth_email), "text") . "," .
                                GetSQLValueString(Code::Charset($FotoPerfil), "text") . "," .
                                GetSQLValueString(Code::Charset($ClientAuth_locale), "text") . "," .
                                GetSQLValueString(Code::Charset($ClientAuth_gender), "text") . ")"
                        );

                        if ($LevelType == 'Publishers' || $Type == 'Publishers' || $Level == 'Publishers') {
                            $date = date('Y-m-d');
                            $Date_FinishBuild = strtotime('+ 182 day', strtotime($date));
                            $Date_Finish = date('Y-m-d', $Date_FinishBuild);
                            $query = "INSERT INTO user_plan (UID,Limit_Plan,planID,Date_Finish) "
                                    . "VALUES (" . GetSQLValueString($insertUserID, "int") . ","
                                    . GetSQLValueString("180", "int") . ","
                                    . GetSQLValueString("99", "int") . ","
                                    . GetSQLValueString($Date_Finish, "date") . ")";
                            $SKTDB->query($query);
                        }
                        if ($insertProfile) {
                            if ($Client == 'FromSite') {
                                $ValidateUserMail = new \CmsDev\Security\ValidateUserMail();
                                echo $ValidateUserMail->User($insertUserID);
                            }
                            if ($new_Google == true || $new_Facebook == true) {
                                $_SESSION['UserName'] = $ClientAuth_id;
                                $session = md5(
                                        $username .
                                        $password
                                );
                                $_SESSION['login'] = $session;
                                $_SESSION['UserIDU'] = $insertUserID;
                                \CmsDev\Header\refresh::refreshNow(SITE_SERVER);
                                exit();
                            }
                        } else {
                            $error = "error";
                        }
                    } else {
                        $error = \SKT_ADMIN_User_Invalid;
                    }
                }
            }
        }
        if ($error != '') {
            $MessageBox = SKT_INFO\Asistance::get();
            $MessageBox->TipError('<b>' . $Name . '.</b> - ' . $error . ', <pre>' . $username . '</pre>', false);
        }
    }

}

?>
