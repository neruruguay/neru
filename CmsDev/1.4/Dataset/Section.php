<?php

/**
 * Description of Section
 *
 * @author usuario
 */

namespace CmsDev\Dataset;

use CmsDev\util\globals as SKTGLOBALS;
use \CmsDev\sql\db_Skt as SKT_DB;
use \CmsDev\Info as SKT_INFO;
use \CmsDev\Url\Request as Request;

class Section {

    public $ID = '';
    public $Title = '';
    public $URLName = '';
    public $SID = '';
    public $RecycleBin = '';
    public $SystemRequired = '';
    public $TemplatePage = 'home';
    public $TemplateSite = '';
    public $Position = '';
    public $SKTDB = '';
    public $Description = '';
    public $DisplayOnMenu = '';
    public $MetaDataTitle = '';
    public $MetaDataDescription = '';
    public $MetaDataKeywords = '';
    public $SectionType = '';
    public $PID = '';
    public $SearchURLName = '';
    public $SectionImage = '';
    public $LinkActive = '';
    public $Link_ID = '';
    public $datePost = '';
    public $ParentSectionValues = '';
    public $Parent_2_SectionValues = '';
    public $Parent_3_SectionValues = '';
    public $Parent_4_SectionValues = '';
    public $Parent_5_SectionValues = '';
    private static $instancia;
    public $name = "";

    public static function GetDataSet() {
        if (!self::$instancia instanceof self) {
            self::$instancia = new self;
        }
        return self::$instancia;
    }

    private function __construct() {
        if (!defined('DB_PREFIX')) {
            define('DB_PREFIX', 'default_');
        }
        $SKT = SKTGLOBALS::getVar('SKT');
        $SKTDB = SKT_DB\db_Skt::connect();

        $SectionValues = '';
        $ParentSectionValues = '';
        $Parent_2_SectionValues = '';
        $Parent_3_SectionValues = '';
        $Parent_4_SectionValues = '';
        $Parent_5_SectionValues = '';
        // new \_TemplateSite\clean\Config();
        // sections //  ID 	Title 	URLName 	SID 	RecycleBin 	SystemRequired 	Language 	Template 	Order

        $SectionValues = $SKTDB->get_row("SELECT * FROM " . \DB_PREFIX . "sections WHERE URLName = '" . \SKTURL_Here . "'");

        if (isset($SectionValues->SID) && $SectionValues->SID != '') {
            $ParentSectionValues = $SKTDB->get_row("SELECT * FROM " . \DB_PREFIX . "sections WHERE ID = '$SectionValues->SID'");
            if (isset($ParentSectionValues->SID) && $ParentSectionValues->SID != '') {
                $Parent_2_SectionValues = $SKTDB->get_row("SELECT * FROM " . \DB_PREFIX . "sections WHERE ID = '$ParentSectionValues->SID'");
                if (isset($Parent_2_SectionValues->SID) && $Parent_2_SectionValues->SID != '') {
                    $Parent_3_SectionValues = $SKTDB->get_row("SELECT * FROM " . \DB_PREFIX . "sections WHERE ID = '$Parent_2_SectionValues->SID'");
                    if (isset($Parent_3_SectionValues->SID) && $Parent_3_SectionValues->SID != '') {
                        $Parent_4_SectionValues = $SKTDB->get_row("SELECT * FROM " . \DB_PREFIX . "sections WHERE ID = '$Parent_3_SectionValues->SID'");
                        if (isset($Parent_4_SectionValues->SID) && $Parent_4_SectionValues->SID != '') {
                            $Parent_5_SectionValues = $SKTDB->get_row("SELECT * FROM " . \DB_PREFIX . "sections WHERE ID = '$Parent_4_SectionValues->SID'");
                        }
                    }
                }
            }
        }

        if (!$SectionValues) {

            $SectionValues = $SKTDB->get_row("SELECT * FROM " . \DB_PREFIX . "sections WHERE Language = '" . \SKT_ThisLaguage . "' AND SID = '0' ");
            if (!$SectionValues) {
                $SectionValues = $SKTDB->get_row("SELECT * FROM " . \DB_PREFIX . "sections WHERE SID = '0' AND Language = '" . \SKT_ThisLaguage . "'");
            }

            if (\SKTURL_Here != '' && \SKTURL_Here != trim(\SKTURL_REQUEST_URI, '/') && !\in_array(\SKTURL_Here, $SKT['LANGUAGE']['LIST']) && !\in_array(\SKTURL_Here, $SKT['SITE']['RESTRICTED_URL'])
            ) {
                if (!defined("error")) {
                    define('error', 'error404');
                }
            }
        }


        $IDSections = $SectionValues->ID;

        $_SESSION['SessionURLSection'] = $SKTDB->get_var("SELECT URLName FROM " . \DB_PREFIX . "sections WHERE ID = '$IDSections'");

        if (!defined("SectionHidden")) {
            define('SectionHidden', $SectionValues->RecycleBin);
        }

        $SKTDB->query("SELECT * FROM " . \DB_PREFIX . "sections WHERE SID = '0'");
        $query = $SKTDB->get_col_info();
        foreach ($query as $name) {
            $this->$name = $SectionValues->$name;
        }
        $this->ParentSectionValues = $ParentSectionValues;
        $this->Parent_2_SectionValues = $Parent_2_SectionValues;
        $this->Parent_3_SectionValues = $Parent_3_SectionValues;
        $this->Parent_4_SectionValues = $Parent_4_SectionValues;
        $this->Parent_5_SectionValues = $Parent_5_SectionValues;
    }

    public static function new_auto_increment_ID() {
        $SKTDB = SKT_DB::connect();
        $NewID = $SKTDB->get_var("SELECT MAX(ID) FROM " . \DB_PREFIX . "sections") + 1;
        return $NewID;
    }

}
