<?php
if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    require_once (dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'DefinePath.php');
    require_once (dirname(dirname(dirname(dirname(dirname(__FILE__))))) . DIRECTORY_SEPARATOR . 'Config.php');
    require_once (dirname(dirname(dirname(dirname(dirname(__FILE__))))) . DIRECTORY_SEPARATOR . 'db.php');
    require_once (dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'Core.php');
}
if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
    $ONTOP = true;
    /* INSTANCE HEADER */
    $SKT_Header = new \CmsDev\Header\Make;
    $SKT_Header->addMeta('robots', 'noindex,nofollow');
    echo \CmsDev\Security\LoadHeader::loadEveryTime();
    echo \CmsDev\Security\LoadHeader::loadOnFileSystem();
    echo $SKT_Header->RenderHeader();
    ?>
    <style type="text/css" media="all">
        .ui-dialog-titlebar {
            display: none !important;
        }
        .skt .dialog-form-Administrator-Files, .skt .Administrator-List {
            height: 100% !important;
            width: 100% !important;
        }
        .skt .Administrator-Files, .skt .Administrator-List {
            height: 100% !important;
            position: fixed !important;
            top: 0 !important;
        }
    </style>
    <body style="border: 0 !important">
        <?php require 'Control.php'; ?>       
    </body>
<?php } ?>