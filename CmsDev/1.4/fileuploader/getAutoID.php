<?php

if (!isset($ConfigSite) || $ConfigSite != 1) {

    require('../../_ConfigSite.php');
}

require('../../_CmsDevCore/_config.php');

$Section_AutoID = $Products_AutoID = $SKTDB->get_var("SELECT MAX(ID) FROM " . DB_PREFIX . "sections") + 1;

$getAutoID = $Products_AutoID . '_' . $Section_AutoID . '_' . date('Y-m-d');
?>