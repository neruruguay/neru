<?php

// Register autoload
require_once('AutoLoad.php');
require('util/functions.php');
spl_autoload_register('Autoloader::autoload');
/*
  echo 'Service = ' . $_GET['Service'] . '<br>';
  echo 'Method = ' . $_GET['Method'] . '<br>';
  echo 'Params = ' . $_GET['Params'] . '<br>';
 */
$PD = $_GET['PD'];
$Service = $_GET['Service'];
$Method = $_GET['Method'];
$Params = $_GET['Params'];
$ParamsService = explode("|", $Params);

switch ($Service) {
    case 'Lists':

        $list = isset($ParamsService[0]) ? $ParamsService[0] : '';
        $listSort = isset($ParamsService[1]) ? $ParamsService[1] : '';
        $listOrder = isset($ParamsService[2]) ? $ParamsService[2] : '';
        $listLimit = isset($ParamsService[3]) ? $ParamsService[3] : '';
        $listQuery = isset($ParamsService[4]) ? $ParamsService[4] : '';
        $ID = isset($ParamsService[5]) ? $ParamsService[5] : '';

        if ($Method === 'getJSON') {
            \CmsDev\CRUD\CustomList\List_Information::getJSON($PD, $list, $listSort, $listOrder, $listLimit, $listQuery, $ID);
        } else if ($Method === 'GetTableHTML') {
            \CmsDev\CRUD\CustomList\List_Information::GetTableHTML($PD, $list, $listSort, $listOrder, $listLimit, $ItemTemplate, $ID);
        } else if ($Method === 'GetArray') {
            \CmsDev\CRUD\CustomList\List_Information::GetArray($PD, $list, $listSort, $listOrder, $listLimit, $listQuery, $ID);
        } else if ($Method === 'GetObject') {
            \CmsDev\CRUD\CustomList\List_Information::GetObject($PD, $list, $listSort, $listOrder, $listLimit, $listQuery, $ID);
        } else if ($Method === 'GetHowUse') {
            \CmsDev\CRUD\CustomList\List_Information::GetHowUse($list);
        } else {
            echo '"Method" of return "Lists Services" is required.<br>eg. getJSON, GetTableHTML, GetArray, GetObject.';
        }
        break;
    default :
        echo 'El nombre del tipo de servicio es requerido.<br>Ej.: Lists';
        break;
}
?>
