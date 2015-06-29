<?php

/**
 * Description of UserProfile
 *
 * @author Martín Daguerre
 */

namespace CmsDev\Dataset;

use \CmsDev\sql\db_Skt as SKT_DB;
use \CmsDev\Info as SKT_INFO;

class UserProfile {

    public $user;
    public $user_list;
    public $UserOk;
    public $Company;
    public $email;

    public function GetDataSet() {
        $user_row = self::UserQuery();
        if ($user_row) {
            $this->Company = $user_row->Company;
            $this->email = $user_row->email;
            $this->user_list = $user_row;
            $this->user = $user_row;
            $this->UserOk = true;
        } else {
            $this->UserOk = false;
            $MessageBox = SKT_INFO\Asistance::get();
            $MessageBox->TipError(\SKT_ADMIN_User_max_attempts . \SKT_ADMIN_User_max_attempts_TXT, true);
        }
    }

    public function GetId() {
        $user_row = self::UserQuery();
        if ($user_row) {
            return $user_row->id;
        } else {
            return false;
        }
    }

    public static function GetQuery() {
        return self::UserQuery();
    }

    private static function UserQuery() {
        $SKTDB = SKT_DB::connect();
        $USER_EXIST = \CmsDev\Security\loginIntent::action('validateUser');
        if ($USER_EXIST === true) {
            $user_row = $SKTDB->get_row("SELECT *
                    FROM users as user, userprofile as profile 
                    WHERE user.md5 = " . \GetSQLValueString($_SESSION['login'], 'text') . " AND profile.IDX = user.id ");
            if ($user_row) {
                return $user_row;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}

?>
