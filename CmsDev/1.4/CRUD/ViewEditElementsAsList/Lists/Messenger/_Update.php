<?php

if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
    if (isset($_POST['id'])) {
        $ID = $_POST['id'];
        $Company = isset($_POST['Company']) ? $_POST['Company'] : '';
        $RUT = isset($_POST['RUT']) ? $_POST['RUT'] : '';
        $CompanyUrl = isset($_POST['CompanyUrl']) ? $_POST['CompanyUrl'] : '';
        $Description = isset($_POST['Description']) ? $_POST['Description'] : '';
        $category1 = isset($_POST['category1']) ? $_POST['category1'] : '';
        $category2 = isset($_POST['category2']) ? $_POST['category2'] : '';
        $category3 = isset($_POST['category3']) ? $_POST['category3'] : '';
        $category4 = isset($_POST['category4']) ? $_POST['category4'] : '';
        $category5 = isset($_POST['category5']) ? $_POST['category5'] : '';
        $Categories = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Messenger\_classes;
        $Categories->EditItemList($ID, $Company, $RUT, $CompanyUrl, $Description, $category1, $category2, $category3, $category4, $category5);
    }
}
?>