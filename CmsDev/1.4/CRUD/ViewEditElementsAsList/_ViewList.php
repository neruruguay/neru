<?php

/**
 * Description of _ViewList
 *
 * @author Usuario
 */

namespace CmsDev\CRUD\ViewEditElementsAsList;

class _ViewList {

    private static $instancia;

    public static function get() {
        if (!self::$instancia instanceof self) {
            self::$instancia = new self;
        }
        return self::$instancia;
    }

    function __construct() {

        $ListsParams = array();
        $Safetylist = array(
            'Contents',
            'Languages',
            'ReusableComponent',
            'Roles',
            'Sections',
            'Users',
            'Products',
            'Templates',
            'Categories',
            'Messenger',
            'Purchase_Requests',
            'User_plan',
            'Mailer'
        );
        $ListsIcons = array(
            'Contents' => 'skt-icon-page-properties',
            'Languages' => 'skt-icon-language',
            'ReusableComponent' => 'skt-icon-spin3',
            'Roles' => 'skt-icon-access',
            'Sections' => 'skt-icon-document',
            'Users' => 'skt-icon-group',
            'Products' => 'skt-icon-basquet',
            'Templates' => 'skt-icon-theme-layout',
            'Categories' => 'skt-icon-tags',
            'Messenger' => 'skt-icon-icon-email',
            'Purchase_Requests' => 'skt-icon-page-properties',
            'User_plan' => 'skt-icon-group',
            'Mailer' => 'skt-icon-icon-email'
        );
        $ListsParams['esp'] = array(
            'Contents' => '<i class="skt-icon-page-properties"></i> Contenidos',
            'Languages' => '<i class="skt-icon-language"></i> Languajes',
            'ReusableComponent' => '<i class="skt-icon-spin3"></i> Contenido reutilizable',
            'Roles' => '<i class="skt-icon-access"></i> Roles',
            'Sections' => '<i class="skt-icon-document"></i> Secciones',
            'Users' => '<i class=" skt-icon-group"></i> Usuarios',
            'Products' => '<i class="skt-icon-basquet"></i> Productos',
            'Templates' => '<i class="skt-icon-theme-layout"></i> Plantillas de sitios',
            'Categories' => '<i class="skt-icon-tags"></i> Categor&iacute;as',
            'Messenger' => '<i class="skt-icon-icon-email"></i> Mensajes',
            'Purchase_Requests' => '<i class="skt-icon-page-properties"></i> Ordenes de compra',
            'User_plan' => '<i class="skt-icon-group"></i> Planes de Usuarios',
            'Mailer' => '<i class="skt-icon-icon-email"></i> Envío de mails'
        );

        $ListsParams['eng'] = array(
            'Contents' => '<i class="skt-icon-page-properties"></i> Contents',
            'Languages' => '<i class="skt-icon-language"></i> Languages',
            'ReusableComponent' => '<i class="skt-icon-spin3"></i> Reusable Component',
            'Roles' => '<i class="skt-icon-access"></i> Roles',
            'Sections' => '<i class="skt-icon-document"></i> Sections',
            'Users' => '<i class=" skt-icon-group"></i> Users',
            'Products' => '<i class="skt-icon-basquet"></i> Products',
            'Templates' => '<i class="skt-icon-theme-layout"></i> Templates',
            'Categories' => '<i class="skt-icon-tags"></i> Categories',
            'Messenger' => '<i class="skt-icon-email"></i> Mensajes',
            'Purchase_Requests' => '<i class="skt-icon-page-properties"></i> Purchase Requests',
            'User_plan' => '<i class="skt-icon-group"></i> Users Plan',
            'Mailer' => '<i class="skt-icon-icon-email"></i> Envío de mails'
        );

        $ListsParams['por'] = array(
            'Contents' => '<i class="skt-icon-page-properties"></i> Contents',
            'Languages' => '<i class="skt-icon-language"></i> Languages',
            'ReusableComponent' => '<i class="skt-icon-spin3"></i> Reusable Component',
            'Roles' => '<i class="skt-icon-access"></i> Roles',
            'Sections' => '<i class="skt-icon-document"></i> Sections',
            'Users' => '<i class=" skt-icon-group"></i> Users',
            'Products' => '<i class="skt-icon-basquet"></i> Products',
            'Templates' => '<i class="skt-icon-theme-layout"></i> Templates',
            'Categories' => '<i class="skt-icon-tags"></i> Categor&iacute;as',
            'Messenger' => '<i class="skt-icon-email"></i> Mensajes',
            'Purchase_Requests' => '<i class="skt-icon-page-properties"></i> Ordenes de compra',
            'User_plan' => '<i class="skt-icon-group"></i> Planes de Usuarios',
            'Mailer' => '<i class="skt-icon-icon-email"></i> Envío de mails'
        );

        $fileList = '';
        $Select = '<select name="ListType" id="ListType" class="text ui-corner-all margin-no" >';
        $Select.= '<option value="">' . \SKT_ADMIN_TXT_SelectDef . '</option>';
        global $SKT;
        $ListType = \SKTPATH_CmsDev . '/CRUD/ViewEditElementsAsList/Lists/';
        //if (file_exists($ListType)) {
        $handle = opendir($ListType);
        while ($file = readdir($handle)) {
            if (!\is_file($file) && $file != ".." && $file != ".") {
                if (in_array($file, $Safetylist)) {
                    $Select.= '<option value="' . $file . '" class="' . $ListsIcons[$file] . '">' . $ListsParams[\SKT_ADMIN_LANG][$file] . '</option>';
                }
            }
            //$fileList = $fileList.$file.' - ';
        }
        /* $MessageBox = \CmsDev\Info\Asistance::get();
          $MessageBox->TipInfo(var_dump($fileList));
          echo $MessageBox->Render(); */
        closedir($handle);
        //}

        $Select.= '</select>';
        echo $Select;
    }

}

?>
