<?php

/**
 * Description of UserName_ValidateName
 *
 * @author usuario
 */

namespace CmsDev\Security;

class UserName_ValidateName {

    public static function ValidateNameExistAndClean($string) {

        $UserName = new \CmsDev\util\CheckUserName();
        $stringValid = $UserName->Fix($string);

        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $user = $SKTDB->get_row("SELECT username FROM users WHERE username = " . \GetSQLValueString($stringValid, 'text') . "");
        if ($user) {
            return 'exist';
        }else {
            return $stringValid;
        }
    }

}
