<?php

$folder = $_POST['folder'];

function FolderDelete($folder) {
    $filedelete = '';
    foreach (glob($folder . "/*") as $Files_folder) {
        $filedelete.= '<b>' . $Files_folder . '</b><br>';
        if (is_dir($Files_folder)) {
            FolderDelete($Files_folder);
        } else {
            chmod($Files_folder, 0666);
            @unlink($Files_folder);
        }
    }
    rmdir($folder);
    echo '<h3>La carpeta fu&eacute; borrada.</h3><br>' . $filedelete;
}

FolderDelete($folder);
?>