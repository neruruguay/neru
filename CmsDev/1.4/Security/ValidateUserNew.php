<?php

/**
 * Description of LoginFormUser
 *
 * @author Martín Daguerre
 */

namespace CmsDev\Security;

use \CmsDev\sql\db_Skt as SKT_DB;
use \CmsDev\Info as SKT_INFO;

class ValidateUserNew {

    private function validateMD5($MD5 = 0) {
        $SKTDB = SKT_DB::connect();
        $user = $SKTDB->get_row("SELECT * FROM users WHERE md5 = " . \GetSQLValueString($MD5, 'text') . "");
        if ($user) {
            $updateSectionImage = mysql_query(sprintf("UPDATE users Set 
							isactive = %s
							WHERE md5 = %s", GetSQLValueString(1, "int"), GetSQLValueString($MD5, "text")
            ));
            return true;
        } else {
            $MessageBox = SKT_INFO\Asistance::get();
            $MessageBox->TipError('No se pudo validar el usuario.<br>'.$MD5, true);
            return false;
        }
    }

    function __construct() {
        if (isset($_GET['username']) && $_GET['username'] != '') {
            $Render = 'FormValidateCode';
            $Validated = false;
        } elseif (isset($_GET['codeValidate']) && $_GET['codeValidate'] != '') {
            $Render = 'DirectValidateCode';
            $Validated = self::validateMD5($_GET['codeValidate']);
        } else {
            $Validated = false;
        }
        require('Form_ValidateUserNew.php');
    }

}

?>
