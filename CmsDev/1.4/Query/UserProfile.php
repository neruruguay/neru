<?php

/**
 * Description of UserProfile
 *
 * @author Martín Daguerre
 */

namespace CmsDev\Query;

use \CmsDev\sql\db_Skt as SKT_DB;
use \CmsDev\Info as SKT_INFO;
use \CmsDev\Url\Request;

class UserProfile {

    public $user_list;
    public $UserOk;

    public function GetDataSet() {
        $SKTDB = SKT_DB::connect();
        $USER_EXIST = \CmsDev\Security\loginIntent::action('validateUser');
        if ($USER_EXIST === true) {

            $user_list = $SKTDB->get_row("SELECT *
                    FROM users as user join userprofile as profile 
                    ON user.md5 = " . \GetSQLValueString($_SESSION['login'], 'int') . "
                    WHERE user.id = profile.IDX 
            ");
            if ($user_list) {
                $this->user_list = $user_list;
                $this->UserOk = true;
            } else {
                $this->UserOk = false;
                $MessageBox = SKT_INFO\Asistance::get();
                $MessageBox->TipError(\SKT_ADMIN_User_max_attempts . \SKT_ADMIN_User_max_attempts_TXT, true);
            }
        } else {
            $this->UserOk = false;
            $MessageBox = SKT_INFO\Asistance::get();
            $MessageBox->TipError(\SKT_ADMIN_User_max_attempts . \SKT_ADMIN_User_max_attempts_TXT, true);
        }
    }

}

?>
