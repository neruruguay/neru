<?php

if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    $SKTAJAX = 'AJAX';
    $LanguageFromFile = true;
    require_once ('../../Config.php');
    require_once ('../../db.php');
    require_once ( 'Core.php');
}
if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {

    if (isset($_POST['del']) && isset($_POST['file'])) {
        unlink($_POST['file']);
    }
    echo \CmsDev\Security\LoadHeader::loadOnFileSystem();
    echo '<body class="skt" style="padding:20px;">'
    . '<div class="content"><p><a href="/SKTGoTo/bG9ncw?r=' . time() . '" class="btn btn-primary color-4-i"><i class="skt-icon-reload"></i> Reload</a><p><br>';
    $errorlogs = new CmsDev\skt_error_log();
    echo '<div class="accordeon">';
    $errorlogs->get(\SKTPATH, false, 'show');
    $errorlogs->get(\SKTPATH . "/error_logs/", false, 'show');
    $errorlogs->get(\SKTPATH_CmsDev, true, 'show');
    $errorlogs->get(\SKTPATH_FileSystems, true, 'show');
    $errorlogs->get(\SKTPATH_TemplateSite, true, 'show');
    echo '</div>'
    . '<script>$(".accordeon").accordion({
                heightStyle: "content",
                collapsible: true
            });</script>';
    echo '<br><br><p><a href="/SKTGoTo/bG9ncw?r=' . time() . '" class="btn btn-primary color-4-i"><i class="skt-icon-reload"></i>Reload</a><p><br>';
    echo '</div></body></html>';
}
?>


