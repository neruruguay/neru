<?php

if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
    if (isset($_POST['category_id'])) {
        $category_id = $_POST['category_id'];
        $category_name = isset($_POST['category_name']) ? $_POST['category_name'] : '';
        $category_Description = isset($_POST['category_Description']) ? $_POST['category_Description'] : '';
        $category_url = isset($_POST['category_url']) ? $_POST['category_url'] : '';
        $category_icon = isset($_POST['category_icon']) ? $_POST['category_icon'] : '';
        $category_idx = isset($_POST['category_idx']) ? $_POST['category_idx'] : '0';
        $category_level = isset($_POST['level']) ? $_POST['level'] : '0';
        $category_image = isset($_POST['category_image']) ? $_POST['category_image'] : '/_FileSystems/transparent.png';
        $Categories = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Categories\_classes;
        $Categories->EditItemList($category_id, $category_name, $category_Description, $category_url, $category_icon, $category_idx,$category_level, $category_image);
    }
}
?>