<?php
$SKT_CC = new \CmsDev\CustomControl\LoadControl();
$SKTDB = \CmsDev\sql\db_Skt::connect();
$empresas = (int) $_GET['empresas'];
//echo '<img class="img-responsive " alt="" src="/_FileSystems/Banners/Empresas.jpg" style="width:100%">';
$CategoryTitle = 'Empresas';
$CategoryDescription = '';
$CategoryIcon = '';
$CatLevel = 0;

$sort = (int) isset($_GET['sort']) ? $_GET['sort'] : 0;
$order = (int) isset($_GET['order']) ? $_GET['order'] : 0;

$Cat1 = (int) $_GET['cat'];
$Cat2 = (int) $_GET['Subcat'];
$Cat3 = (int) $_GET['Sub2cat'];
$Level = 0;

if ($Cat1 != 0) {
    $Category = $SKTDB->get_row("SELECT * FROM " . \DB_PREFIX . "categories WHERE category_id = " . \GetSQLValueString($Cat1, "int") . " ");
    $CategoryTitle .= '' . $Category->Title;
    $CategoryDescription = '<h3>' . $Category->Description . '</h3>';
    $CategoryIcon = '<i class="fa ' . $Category->icon . '"></i>';
    $CatLevel = $Category->category_id;
    $Level = 1;
}
if ($Cat2 != 0) {
    $Category = $SKTDB->get_row("SELECT * FROM " . \DB_PREFIX . "categories WHERE category_id = " . \GetSQLValueString($Cat2, "int") . " ");
    $CategoryTitle .= ' - ' . $Category->Title;
    $CategoryDescription = '<h3>' . $Category->Description . '</h3>';
    $CategoryIcon = '<i class="fa ' . $Category->icon . '"></i>';
    $CatLevel = $Category->category_id;
    $Level = 2;
}
if ($Cat3 != 0) {
    $Category = $SKTDB->get_row("SELECT * FROM " . \DB_PREFIX . "categories WHERE category_id = " . \GetSQLValueString($Cat3, "int") . " ");
    $CategoryTitle .= ' - ' . $Category->Title;
    $CategoryDescription = '<h3>' . $Category->Description . '</h3>';
    $CategoryIcon = '<i class="fa ' . $Category->icon . '"></i>';
    $CatLevel = $Category->category_id;
    $Level = 3;
}
switch ($order) {
    case '0':
        $NameOrder = 'Nombre';
        $QueryOrder = 'Company';
        $UrlOrder = '0/';
        break;
    case '1':
        $NameOrder = 'Categor&iacute;a';
        $QueryOrder = 'Categories';
        $UrlOrder = '1/';
        break;
    default:
        $NameOrder = 'Nombre';
        $QueryOrder = 'Company';
        $UrlOrder = '0/';
        break;
}
switch ($sort) {
    case '0':
        $QuerySort = 'ASC';
        $IconSort = 'fa-angle-down';
        $sortReverse = 'DESC';
        $UrlSort = '0/';
        $UrlSortReverse = '1/';
        break;
    case '1':
        $QuerySort = 'DESC';
        $IconSort = 'fa-angle-up';
        $sortReverse = 'ASC';
        $UrlSort = '1/';
        $UrlSortReverse = '0/';
        break;
    default:
        $QuerySort = 'ASC';
        $IconSort = 'fa-angle-down';
        $sortReverse = 'DESC';
        $UrlSort = '0/';
        $UrlSortReverse = '1/';
        break;
}

$CategoryParams = array(
    'CategoryTitle' => $CategoryTitle,
    'CategoryDescription' => $CategoryDescription,
    'CategoryIcon' => $CategoryIcon,
    'Cat1' => (int) $_GET['cat'],
    'urlcat1' => $_GET['urlcat1'] . '/',
    'Cat2' => (int) $_GET['Subcat'],
    'urlSubcat' => $_GET['urlSubcat'] . '/',
    'Cat3' => (int) $_GET['Sub2cat'],
    'urlSub2cat' => $_GET['urlSub2cat'] . '/',
    'CatLevel' => (int) $CatLevel,
    'Level' => (int) $Level,
    'sort' => (int) $sort,
    'order' => (int) $order,
    'QuerySort' => $QuerySort,
    'IconSort' => $IconSort,
    'sortReverse' => $sortReverse,
    'UrlSort' => $UrlSort,
    'UrlSortReverse' => $UrlSortReverse,
    'NameOrder' => $NameOrder,
    'QueryOrder' => $QueryOrder,
    'UrlOrder' => $UrlOrder
);

//echo '<pre style="position:absolute; top:0; right:0; z-index:999; overflow:auto;">';
//var_dump($CategoryParams);
//echo '</pre>';

if ($empresas === 0) {
    $SKT_CC->Render('RedesPrincipales');
} else {
    ?>
    <div class="container">
        <div  class="row mt40">
            <div class="col-md-12"><h1 class="text-center"><?php echo $CategoryTitle; ?></h1></div>
        </div>
        <div  class="row mt40">
            <div class="col-md-3">
                <?php $SKT_CC->Render('Categories', $CategoryParams); ?>
            </div>
            <div class="col-md-9">
                <?php $SKT_CC->Render('Companies', $CategoryParams); ?>
            </div>
        </div>
    </div>
<?php } ?>

<div class="gap"></div>