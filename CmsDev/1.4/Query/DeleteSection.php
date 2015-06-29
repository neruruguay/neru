<?php
if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    $SKTAJAX = 'AJAX';
    require ('../../DefinePath.php');
    require ('../../../Config.php');
    require ('../../../db.php');
    require ('../Core.php');
}
$SKTDB = \CmsDev\sql\db_Skt::connect();
if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {

    function FolderDelete($folder) {
        if (file_exists($folder)) {
            foreach (glob($folder . "/*") as $Files_folder) {
                //echo '<b>'.$Files_folder.'</b><br>';
                if (is_dir($Files_folder)) {
                    FolderDelete($Files_folder);
                } else {
                    chmod($Files_folder, 0666);
                    @unlink($Files_folder);
                }
            }
            rmdir($folder);
        }
    }

    if (isset($_POST['ID']) && $_POST['ID'] != '') {



        $ID = $_POST['ID'];

        $PID = $SKTDB->get_var("SELECT PID FROM " . DB_PREFIX . "sections WHERE ID = '$ID' LIMIT 1");

        $DeleteQuery = $SKTDB->query("DELETE FROM " . DB_PREFIX . "sections WHERE ID = '$ID' LIMIT 1");

        if ($DeleteQuery) {

            if ($PID != '') {
                $DeleteProduct = $SKTDB->query("DELETE FROM " . DB_PREFIX . "products WHERE IDSection	= '$ID' LIMIT 1");
            }

            FolderDelete($_POST['folder']);

            //rmdir($_POST['folder']);
        } else {

            echo 'error';
        }
    }
}
?>