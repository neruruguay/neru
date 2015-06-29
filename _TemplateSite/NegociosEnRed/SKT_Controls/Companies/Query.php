<?php
if ((int) $_GET['order'] != 0 || (int) $_GET['sort'] != 0) {
    $QueryOrderSentence = " ORDER BY " . $CCParams['QueryOrder'] . " " . $CCParams['QuerySort'] . "";
} else {
    $QueryOrderSentence = " ORDER BY Company ASC ";
}
if ($CCParams['Cat1'] == 0 && $CCParams['Cat2'] == 0 && $CCParams['Cat2'] == 0) {
    $SKTDB = \CmsDev\Sql\db_Skt::connect();
    $Query = "SELECT *
FROM users as user join userprofile as profile 
ON user.id = profile.IDX 
WHERE profile.level = 'Publishers' AND user.isactive = '1'
"  . $QueryOrderSentence . " LIMIT 150";
} else {
    $QueryCatSentence = " (profile.level = 'Publishers' AND user.isactive = '1' AND profile.category1 = '" . GetSQLValueString($CCParams['CatLevel'], "int") . "' )";
    $QueryCatSentence .= " OR (profile.level = 'Publishers' AND user.isactive = '1' AND profile.category2 = '" . GetSQLValueString($CCParams['CatLevel'], "int") . "')";
    $QueryCatSentence .= " OR (profile.level = 'Publishers' AND user.isactive = '1' AND profile.category3 = '" . GetSQLValueString($CCParams['CatLevel'], "int") . "')";
    $QueryCatSentence .= " OR (profile.level = 'Publishers' AND user.isactive = '1' AND profile.category4 = '" . GetSQLValueString($CCParams['CatLevel'], "int") . "')";
    $QueryCatSentence .= " OR (profile.level = 'Publishers' AND user.isactive = '1' AND profile.category5 = '" . GetSQLValueString($CCParams['CatLevel'], "int") . "')";

    $SKTDB = \CmsDev\Sql\db_Skt::connect();
    $Query = "SELECT *
FROM users as user join userprofile as profile 
ON user.id = profile.IDX
WHERE " . $QueryCatSentence . $QueryOrderSentence . "";

//    echo '<pre>';
//    echo var_dump($CCParams);
//    echo '</pre>';
//    echo '<pre>' . $Query . '</pre>';
}
switch ((int) $CCParams['Level']) {
    case 1:
        $RevertSort = SKTURL_REQUEST_URI . '/';
        $Order1 = 'empresas/' . $CCParams['UrlSort'] . '0/' . $CCParams['Cat1'] . '/' . $CCParams['urlcat1'] . '/';
        $Order2 = 'empresas/' . $CCParams['UrlSort'] . '1/' . $CCParams['Cat1'] . '/' . $CCParams['urlcat1'] . '/';

        break;
    case 2:
        $RevertSort = 'empresas/' . $CCParams['UrlSortReverse'] . $CCParams['UrlOrder'] . $CCParams['Cat1'] . '/' . $CCParams['urlcat1'] . '/' . $CCParams['Cat2'] . '/' . $CCParams['urlSubcat'];
        $Order1 = 'empresas/' . $CCParams['UrlSort'] . '0/' . $CCParams['Cat1'] . '/' . $CCParams['urlcat1'] . '/' . $CCParams['Cat2'] . '/' . $CCParams['urlSubcat'];
        $Order2 = 'empresas/' . $CCParams['UrlSort'] . '1/' . $CCParams['Cat1'] . '/' . $CCParams['urlcat1'] . '/' . $CCParams['Cat2'] . '/' . $CCParams['urlSubcat'];

        break;
    case 3:
        $RevertSort = 'empresas/' . $CCParams['UrlSortReverse'] . $CCParams['UrlOrder'] . $CCParams['Cat1'] . '/' . $CCParams['urlcat1'] . '/' . $CCParams['Cat2'] . '/' . $CCParams['urlSubcat'] . '/' . $CCParams['Cat3'] . '/' . $CCParams['urlSub2cat'];
        $Order1 = 'empresas/' . $CCParams['UrlSort'] . '0/' . $CCParams['Cat1'] . '/' . $CCParams['urlcat1'] . '/' . $CCParams['Cat2'] . '/' . $CCParams['urlSubcat'] . '/' . $CCParams['Cat3'] . '/' . $CCParams['urlSub2cat'];
        $Order2 = 'empresas/' . $CCParams['UrlSort'] . '1/' . $CCParams['Cat1'] . '/' . $CCParams['urlcat1'] . '/' . $CCParams['Cat2'] . '/' . $CCParams['urlSubcat'] . '/' . $CCParams['Cat3'] . '/' . $CCParams['urlSub2cat'];
        break;
    default:
        $RevertSort = SKTURL_REQUEST_URI . '/';
        $Order1 = 'empresas/' . $CCParams['UrlSort'] . '0/' . $CCParams['Cat1'] . '/' . $CCParams['urlcat1'] . '/';
        $Order2 = 'empresas/' . $CCParams['UrlSort'] . '1/' . $CCParams['Cat1'] . '/' . $CCParams['urlcat1'] . '/';
        break;
}
?>