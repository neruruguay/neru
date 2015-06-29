<?php

/**
 * Description of db_Skt
 *
 * @author Martín Daguerre
 */

namespace CmsDev\Sql;

class db_Skt {

    private static $DB_SERVER = \DB_SERVER;
    private static $DB_NAME = \DB_NAME;
    private static $DB_USER = \DB_USER;
    private static $DB_PASSWORD = \DB_PASSWORD;
    private static $instance;

    public function __construct() {
        
    }

    public static function connect() {
        if (!isset(self::$instance)) {
            self::$instance = self::db();
        }
        return self::$instance;
    }

    public static function db() {
        require('shared/ez_sql_core.php');
        require('mysql/ez_sql_mysql.php');
        $SKTDB = new \ezSQL_mysql(self::$DB_USER, self::$DB_PASSWORD, self::$DB_NAME, self::$DB_SERVER);
        return $SKTDB;
    }

}

?>
