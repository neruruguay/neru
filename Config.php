<?php

\define("SITE_SERVER", "http://2015.negociosenred.uy/");
\define("CMSDomain", "negociosenred.uy");
\define("DEBUG_MAILSEND", false);

$SKT['BODY']['ID'] = '';
$SKT['BODY']['CLASS'] = 'bg-cover';
$SKT['BODY']['STYLE'] = '';
$SKT['SITE']['NAME'] = utf8_encode('OnSkate CMS');
$SKT['SITE']['SLOGAN'] = utf8_encode('Web tools');
$SKT['SITE']['TITLE'] = utf8_encode('OnSkate CMS');
$SKT['SITE']['DESCRIPTION'] = utf8_encode('Dise&ntilde;o y desarrollo de sitios web');
$SKT['SITE']['KEYWORDS'] = utf8_encode('Dise&ntilde;o, Desarrollo, web, sitios, CMS, Uruguay, PHP, HTML, HTML5, JQuery, Hosting');
$SKT['SITE']['AUTHOR'] = utf8_encode('Mart&iacute;n Daguerre - martin.daguerre@gmail.com');
$SKT['SITE']['EMAIL'] = utf8_encode('info@'.\CMSDomain);
$SKT['SITE']['SKYPE'] = utf8_encode('martin.daguerre1');
$SKT['SITE']['ADDRESS'] = utf8_encode('Hocquart 2220<br>Montevideo, Uruguay');
$SKT['SITE']['PHONE'] = utf8_encode('0598-98.919.286');
$SKT['SITE']['WEBMASTER'] = utf8_encode('martin.daguerre@gmail.com');
$SKT['SITE']['CHARSET'] = 'windows-1252';
$SKT['SITE']['RESTRICTED_URL'] = array('empresas', 'usr', 'ValidateUser','PasswordRecovery', 'CloseAdmin', 'admin?invalid-admin', 'admin', 'UserLogin', 'UserLogin?invalid-user', 'UserLogout', 'UserRegistration', 'esp', 'eng', 'por', 'ita', 'fra', 'irs', 'chi', 'cor', 'jap', "license", "promos", "Info", "_Service_", "SKT_HELP", "_thumb_", "SKTGoTo", "SKTDir", "SKTSize", "SKTFiles", "SKTFSys", "Google_Search","Search");
$SKT['JQUERY_VERSION'] = '1.9.1';

// PRODUCT
$SKT['PRODUCT']['TEMPLATE'] = 'Productos_Nivel_5_Detalle';
$SKT['PRODUCT']['ROOT']['esp'] = 'productos/';
$SKT['PRODUCT']['ROOT']['eng'] = 'products/';
$SKT['PRODUCT']['ROOT']['por'] = 'produtos/';
$SKT['PRODUCT']['STOCK'] = 90;   // Porcentaje de respaldo = (STOCK/100) * $PercentStockSafe;
// EDITOR
$SKT['EDITOR']['BODY'] = utf8_encode('background-image: none; margin:0px; padding: 0 15px 0 0; text-align:left; color:#000000;');
$SKT['EDITOR']['COLORS'] = utf8_encode('1898D5 1898D5 FFFFFF 515050 515050 FFFFFF CCCCCC CCCCCC');
$SKT['EDITOR']['FONTS'] = utf8_encode(',Trebuchet MS');
$SKT['EDITOR']['DEFAULT_CONTENT']['esp'] = utf8_encode('<p>Escriba o pegue aqu&iacute el contenido</p>');
$SKT['EDITOR']['DEFAULT_CONTENT']['eng'] = utf8_encode('<p>Write or paste content here</p>');
$SKT['EDITOR']['DEFAULT_CONTENT']['por'] = utf8_encode('<p>Escrever ou colar conte&Uacute;do aqui</p>');
$SKT['TXT_Administrator'] = utf8_encode("Administrador");
$SKT['TXT_Password'] = utf8_encode("Contase&ntilde;a");
// GRID CLASSES
$SKT['GRID']['CONTAINER'] = 'row';
$SKT['GRID']['SIZE'] = array(
    "Columnas [1]" => 'col-md-1',
    "Columnas [2]" => 'col-md-2',
    "Columnas [3]" => 'col-md-3',
    "Columnas [4]" => 'col-md-4',
    "Columnas [5]" => 'col-md-5',
    "Columnas [6]" => 'col-md-6',
    "Columnas [7]" => 'col-md-7',
    "Columnas [8]" => 'col-md-8',
    "Columnas [9]" => 'col-md-9',
    "Columnas [10]" => 'col-md-10',
    "Columnas [11]" => 'col-md-11',
    "Columnas [12]" => 'col-md-12'
);
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
    'mov', 'mpg', 'mp3', 'avi', 'ogg', 'mp4',
    'swf', 'flv', 'fl4',
    'css', 'tpl', 'html', 'htm', 'js',
    'txt');

$SKT['MAP']['InitLat'] = '-34.822259';
$SKT['MAP']['InitLon'] = '-56.164169';


$SKT['CustomTasks'] = array(
    'Add_News' => array(1, 100, 'news'),
    'Contact_List' => array(1, 101, 'email')
);

/* ---------------------------------------------------------------------------------- */
// Acount for oAuth2 and Generic login access

$SKT['Access']['GenericUser'] = 1;
$SKT['Access']['Google'] = 1;
$SKT['Access']['Facebook'] = 0;

$SKT['Access']['AVATAR'] = utf8_encode('_FileSystems/avatar.png');

$SKT['GoogleoAuth2']['setApplicationName'] = 'Negocios en Red';
$SKT['GoogleoAuth2']['setClientId'] = '496144361420-f84kjcoccmo99a2pntbibhuaqkf1umt6.apps.googleusercontent.com';
$SKT['GoogleoAuth2']['setClientSecret'] = '-MZG0o27g6S9yT8u99O5Ea5L';
$SKT['GoogleoAuth2']['setRedirectUri'] = \SITE_SERVER . '/login_with_google/';
$SKT['GoogleoAuth2']['setDeveloperKey'] = '496144361420-f84kjcoccmo99a2pntbibhuaqkf1umt6@developer.gserviceaccount.com';

$SKT['FacebookoAuth2']['server'] = 'Facebook';
$SKT['FacebookoAuth2']['client_id'] = '408862819208483';
$SKT['FacebookoAuth2']['client_secret'] = '73e3bbc982ddbadf890f4bdf67f312e7';
$SKT['FacebookoAuth2']['redirect_uri'] = \SITE_SERVER . '/login_with_facebook/';
$SKT['FacebookoAuth2']['scope'] = 'email';

$SKT['TXT_Hi'] = 'Hola, ';
$SKT['TXT_anonymous'] = 'An&oacute;nimo';
$SKT['TXT_Profile'] = 'Perfil de usuario';

$SKT['TXT_403'] = 'Hola, ';
$SKT['TXT_404_1'] = 'Ops! <small>Error 404</small>';
$SKT['TXT_404_2'] = 'Lo sentimos pero el contenido que b&uacute;sca no se encuentra disponible';
$SKT['TXT_404_3'] = 'Intente buscarlo desde aqu&iacute;.';
$SKT['TXT_404_4'] = 'Buscar';

// MEDIA
$SKT['MEDIA']['ROOT'] = '_FileSystems';
?>