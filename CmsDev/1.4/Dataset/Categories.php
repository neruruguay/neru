<?php

/**
 * Description of Categories
 *
 * @author usuario
 */

namespace CmsDev\Dataset;

class Categories {

    private static $instancia;
    private static $names = array();

    public static function GetDataSet() {
        if (!self::$instancia instanceof self) {
            self::$instancia = new self;
        }
        return self::$instancia;
    }

    function __construct() {
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $categories = $SKTDB->get_results("SELECT * FROM " . \DB_PREFIX . "categories");
        foreach ($categories as $Category) {
            $ListNames[$Category->category_id] = $Category->category_name;
        }
        self::$names = $ListNames;
    }

    function getName() {
        return self::$names;
    }


}
