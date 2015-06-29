<?php
$Detail = new CmsDev\CRUD\ViewEditElementsAsList\Lists\Products\_classes();
$DetailID = $_GET['DetailID'];
$item = $Detail->Dataset($DetailID);
$ProductType = $item->ProductType;
switch ($ProductType) {
    case 'Productos':
        include 'Detail/ProductDetail.php';
        break;
    case 'Service':
        include 'Detail/ServiceDetail.php';
        break;
    case 'Machine':
        include 'Detail/MachineDetail.php';
        break;
    case 'Feedstock':
        include 'Detail/FeedstockDetail.php';
        break;
    case 'Bussines':
        include 'Detail/BussinesDetail.php';
        break;
    default:
        include 'Detail/ProductDetail.php';
        break;
}
?>
