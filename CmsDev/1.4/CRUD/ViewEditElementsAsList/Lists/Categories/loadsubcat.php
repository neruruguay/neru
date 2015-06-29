<?php

if (\CmsDev\Security\loginIntent::action('validate') === true) {
    if (isset($_POST['parent_cat'])) {
        $parent_cat = isset($_POST['parent_cat']) ? $_POST['parent_cat'] : '';
        $SKTDB = \CmsDev\Sql\db_Skt::connect();
        $Query = "SELECT * FROM " . \DB_PREFIX . "categories WHERE category_idx = " . \GetSQLValueString($parent_cat, "int") . " Order By category_name ASC";
        $QueryResult = $SKTDB->get_results($Query);
        foreach ($QueryResult as $items) {
            echo '<option value="'.$items->category_id.'">'.utf8_encode($items->category_name).'</option>';
        }
    }
}
?>