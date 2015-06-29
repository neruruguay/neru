<?php

$install = '../install/install.php';

if (file_exists($install)) {
    header('Location: /install');
    exit();
}
?>
