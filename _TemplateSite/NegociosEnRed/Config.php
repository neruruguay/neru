<?php

namespace _TemplateSite\NegociosEnRed;

class Config {

    private static $instancia;

    function __construct() {

// DB_PREFIX for this template
        if (!defined("DB_PREFIX")) {
            \define("DB_PREFIX", "negocios_");
        }
        // EXTEND SITE DEFINITION
        global $SKT;

        $SKT['BODY']['ID'] = '';
        $SKT['BODY']['CLASS'] = 'sticky-header sticky-search'; //boxed bg-cover ImageBg-0'; //boxed bg-cover';
        $SKT['BODY']['STYLE'] = 'background-image: url(/_TemplateSite/NegociosEnRed/assets/img/patterns/grey_wash_wall.png);';

        $SKT['SITE']['NAME'] = utf8_encode('Negocios en Red');
        $SKT['SITE']['SLOGAN'] = utf8_encode('Mayoristas y Minoristas');
        $SKT['SITE']['TITLE'] = utf8_encode('Negocios en Red');
        $SKT['SITE']['DESCRIPTION'] = utf8_encode('Red de negocios para Mayoristas y Minoristas del Uruguay');
        $SKT['SITE']['KEYWORDS'] = utf8_encode('Negocios, Mayoristas, Minoristas, Uruguay, Compra, Vende, Nuevo, Usado');
        $SKT['SITE']['AUTHOR'] = utf8_encode('Mart&iacute;n Daguerre');
        $SKT['SITE']['EMAIL'] = utf8_encode('info@'.\CMSDomain);
        $SKT['SITE']['SKYPE'] = utf8_encode('martin.daguerre1');
        $SKT['SITE']['ADDRESS'] = utf8_encode('Hocquart 2220<br>Montevideo, Uruguay');
        $SKT['SITE']['PHONE'] = utf8_encode('0598-98.919.286');
        $SKT['SITE']['WEBMASTER'] = utf8_encode('martin.daguerre@gmail.com');
// PRODUCT
        $SKT['PRODUCT']['TEMPLATE'] = 'Productos_Nivel_5_Detalle';
        $SKT['PRODUCT']['ROOT']['esp'] = 'productos/';
        $SKT['PRODUCT']['ROOT']['eng'] = 'products/';
        $SKT['PRODUCT']['ROOT']['por'] = 'produtos/';
        $SKT['PRODUCT']['STOCK'] = 90;   // Porcentaje de respaldo = (STOCK/100) * $PercentStockSafe;
// EDITOR
        $SKT['EDITOR']['BODY'] = utf8_encode('background-image: none; margin:0px; padding: 0 15px 0 0; text-align:left; color:#000000;');
        $SKT['EDITOR']['COLORS'] = utf8_encode('1898D5 1898D5 FFFFFF 515050 515050 FFFFFF CCCCCC CCCCCC');
        $SKT['EDITOR']['FONTS'] = utf8_encode(',TrajanProRegular');
        $SKT['EDITOR']['DEFAULT_CONTENT']['esp'] = utf8_encode('<p>Escriba o pegue aqu&iacute el contenido</p>');
        $SKT['EDITOR']['DEFAULT_CONTENT']['eng'] = utf8_encode('<p>Write or paste content here</p>');


// MEDIA
        $SKT['MEDIA']['DEFAULT_X'] = '800';
        $SKT['MEDIA']['DEFAULT_Y'] = '600';
        $SKT['MEDIA']['SECTION_IMAGE_X'] = '150';
        $SKT['MEDIA']['SECTION_IMAGE_Y'] = '150';
        $SKT['MEDIA']['PRODUCT_IMAGE_X'] = '235';
        $SKT['MEDIA']['PRODUCT_IMAGE_Y'] = '285';
        $SKT['MEDIA']['AVATAR_IMAGE_X'] = '100';
        $SKT['MEDIA']['AVATAR_IMAGE_Y'] = '100';
        $SKT['MEDIA']['SIZE'] = array(
            "Medidas originales" => 'null',
            "Imagen de Producto" => '235_285',
            "Imagen de Categor&iacute;a" => '128_128',
            "Banner HomePage" => '960_200',
            "Banner Interiores" => '960_200',
            "Banner 300 x 250" => '300_250',
            "Banner 468 x 60" => '468_60',
            "Banner 728 x 90" => '728_90',
            "Banner 120 x 600" => '120_600',
            "Banner 160 x 600" => '160_600',
            "Banner 200 x 200" => '200_200',
            "Banner 336 x 280" => '336_280'
        );
        $SKT['allowedExtentions'] = array(
            'jpg', 'gif', 'png',
            'pdf',
            'doc', 'docx',
            'xls', 'xlsx',
            'ppt', 'ppp',
            'rtf',
            'zip', 'rar',
            'mov', 'mpg', 'mp3', 'avi', 'ogg',
            'swf', 'flv', 'fl4',
            'css', 'tpl', 'html', 'htm', 'js',
            'txt');

        $SKT['MAP']['InitLat'] = '-34.822259';
        $SKT['MAP']['InitLon'] = '-56.164169';

        /* ---------------------------------------------------------------------------------- */
// Acount for oAuth2 and Generic login access

        $SKT['Access']['GenericUser'] = 1;
        $SKT['Access']['Google'] = 1;
        $SKT['Access']['Facebook'] = 0;

        $SKT['Access']['AVATAR'] = utf8_encode('_FileSystems/avatar.png');

        /* ---------------------------------------------------------------------------------- */
// LANGUAGE
        $SKT['LANGUAGE']['esp'] = array('Prefix' => 'esp', 'Name' => utf8_encode('Espa&ntilde;ol'), 'Section' => utf8_encode('portada'));
        $SKT['LANGUAGE']['eng'] = array('Prefix' => 'eng', 'Name' => utf8_encode('English'), 'Section' => utf8_encode('home'));
        $SKT['LANGUAGE']['por'] = array('Prefix' => 'por', 'Name' => utf8_encode('Portugues'), 'Section' => utf8_encode('inicio'));

        $SKT['LANGUAGE']['LIST'] = array('esp', 'eng', 'por');

// Administration Language
        $SKT['ADMIN_LANG'] = 'esp';

// PAGINATION
        $SKT['PAGINATION']['esp'] = array(
            "Prev" => utf8_encode('Anterior'),
            "Next" => utf8_encode('Siguiente'),
            "First" => utf8_encode('Primero'),
            "Last" => utf8_encode('&Uacute;ltimo'),
            "Enlarge" => utf8_encode('Ampliar'),
            "Minimize" => utf8_encode('Cerrar'),
            "Page" => utf8_encode('P&aacute;gina'),
            "Image" => utf8_encode('Imagen'),
            "Of" => utf8_encode('de')
        );
// PAGINATION
        $SKT['PAGINATION']['eng'] = array(
            "Prev" => 'Prev',
            "Next" => 'Next',
            "First" => 'First',
            "Last" => 'Last',
            "Enlarge" => 'Enlarge',
            "Minimize" => 'Close',
            "Page" => 'Page',
            "Image" => 'Image',
            "Of" => 'of'
        );
// PAGINATION
        $SKT['PAGINATION']['por'] = array(
            "Prev" => utf8_encode('Prev'),
            "Next" => utf8_encode('Next'),
            "First" => utf8_encode('First'),
            "Last" => utf8_encode('Last'),
            "Enlarge" => utf8_encode('Enlarge'),
            "Minimize" => utf8_encode('Close'),
            "Page" => utf8_encode('Page'),
            "Image" => utf8_encode('Image'),
            "Of" => utf8_encode('of')
        );


// MEDIA
        $SKT['MEDIA']['ROOT'] = '_FileSystems';

// RegisterScripts
        $SKT['RegisterScriptsHeader'] = array();
        $SKT['RegisterScriptsFooter'] = array();
// GENERATE VARS   

        $glob = \CmsDev\util\globals::init();
        $glob->setVar('SKT', $SKT);
    }

    public static function get() {
        if (!self::$instancia instanceof self) {
            self::$instancia = new self;
        }
        return self::$instancia;
    }

}

new Config();
?>