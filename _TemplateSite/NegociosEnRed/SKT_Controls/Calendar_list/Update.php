<?php

if(!isset($ConfigSite) || $ConfigSite !=1){

	require('../../_ConfigSite.php');

}
foreach ($_GET['listItem'] as $position => $item){

	$update=$db->query(sprintf("UPDATE ".DB_PREFIX."sections SET Position = $position WHERE ID = $item"));

}

?>