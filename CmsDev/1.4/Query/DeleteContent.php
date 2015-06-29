<?php

if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    $SKTAJAX = 'AJAX';
    require ('../../../../Config.php');
    require ('../../../../db.php');
    require ('../../Core.php');
}
$SKTDB = \CmsDev\sql\db_Skt::connect();
if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
    echo 'ok';
    if (isset($_POST['ID']) && $_POST['ID'] != '' && isset($_POST['action']) && $_POST['action'] != '') {
        $ID = $_POST['ID'];
        $action = $_POST['action'];
        $content = $SKTDB->get_row("SELECT ID,Title,RecycleBin FROM " . DB_PREFIX . "content WHERE ID = '$ID'");
        if ($content) {
            if ($action == 'Delete') {
                $DeleteQuery = $SKTDB->query("DELETE FROM " . DB_PREFIX . "content WHERE ID = '$ID' LIMIT 1");
                if ($DeleteQuery) {
                    echo \SKT_ADMIN_Message_Confirm_Delete_OK;
                } else {
                    echo \SKT_ADMIN_Message_Update_Error;
                }
            }
            if ($action == 'Recycle') {
                if ($content->RecycleBin == 0) {
                    $e = 1;
                    $RequestText = \SKT_ADMIN_ConfirmRecycleTrue1;
                } else {
                    $e = 0;
                    $RequestText = \SKT_ADMIN_ConfirmRecycleTrue0;
                };
                $RecycleQuery = $SKTDB->query("UPDATE " . DB_PREFIX . "content SET RecycleBin = '$e' WHERE ID = '$ID' LIMIT 1");
                if ($RecycleQuery) {
                    echo $RequestText;
                } else {
                    echo \SKT_ADMIN_Message_Update_Error;
                }
            }
        } else {
            echo \SKT_ADMIN_Message_Item_NoExist;
        }
    }
}
?>