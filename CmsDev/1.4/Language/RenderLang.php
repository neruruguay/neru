<?php

/**
 * Description of RenderLangLocaldata
 *
 * @author Martín Daguerre
 */

namespace CmsDev\Language;

class RenderLang {

    public static function Localdata($param) {
        $find = array('\"', '[TasksTitle]', '[Tasks1]', '[Tasks2]', '[Tasks3]', '[Tasks4]', '[Tasks5]', '[Tasks6]', '[Tasks7]', '[Tasks8]', '[Tasks9]', '[Tasks10]', '[Tasks11]', '[Tasks12]', '[Tasks13]', '[Tasks14]', '[Tasks15]', '[Tasks16]', '[Tasks17]', '[Tasks18]', '[Tasks19]', '[Tasks20]');
        $replace = array('"', \SKT_ADMIN_TasksTitle, \SKT_ADMIN_Tasks1, \SKT_ADMIN_Tasks2, \SKT_ADMIN_Tasks3, \SKT_ADMIN_Tasks4, \SKT_ADMIN_Tasks5, \SKT_ADMIN_Tasks6, \SKT_ADMIN_Tasks7, \SKT_ADMIN_Tasks8, \SKT_ADMIN_Tasks9, \SKT_ADMIN_Tasks10, \SKT_ADMIN_Tasks11, \SKT_ADMIN_Tasks12, \SKT_ADMIN_Tasks13, \SKT_ADMIN_Tasks14, \SKT_ADMIN_Tasks15, \SKT_ADMIN_Tasks16, \SKT_ADMIN_Tasks17, \SKT_ADMIN_Tasks18, \SKT_ADMIN_Tasks19, \SKT_ADMIN_Tasks20);
        $Localdata = \str_replace($find, $replace, $param);
        return $Localdata;
    }

}

?>
