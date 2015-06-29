<?php
if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    $SKTAJAX = 'AJAX';
    require ('../../../Config.php');
    require ('../../../db.php');
    require ('../Core.php');
}
$SKTDB = \CmsDev\sql\db_Skt::connect();
include_once \SKTPATH_TemplateSite . 'Config.php';

if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {

    echo str_replace('[title]', \SKT_ADMIN_FileSystems, \SKT_ADMIN_AdminWraperOpen);
    echo \CmsDev\Security\LoadHeader::loadOnFileSystem(FALSE);
    ?>


    <style media="all" type="text/css">
        body { margin: 0 !important; overflow: hidden !important; padding: 0 !important; }
        .FolderSystemUL,
        .FileSystemUL { border-right: 1px solid #2E79DE; display: block; font-size: 12px; height: 100% !important; letter-spacing: 1px; line-height: 1.5; margin: 0 !important; padding: 0 !important; position: fixed; width: 30%; }
        #IframeFiles { display: block; height: 100%; overflow-x: hidden; position: absolute; left: 30%; right: 0; top: 0; width: 69.8%; }
    </style>
    <div class="skt">
        <?php
        $Folder = \CmsDev\skt_Code::Encode(\LOCAL_FILESYSTEM);
        echo \CmsDev\skt_Code::RemoveBreakLine(\CmsDev\AdminFilesystem\List_Directory::FolderSystemUL(\LOCAL_FILESYSTEM, "javascript:SKTFSys.ViewFolderList('[this]');"));
        if (isset($_GET['Folder'])) {
            $Folder = $_GET['Folder'];
        }
        $RenderIframe = '<iframe id="IframeFiles" frameborder="0"  scrolling="auto" src="';
        $RenderIframe .= \SKT_URL_BASE . 'SKTFiles/' . $Folder . '/"></iframe>';
        $RenderIframe .= '<div id="LOADING2"></div>';
        $RenderIframe .= '<script type="text/javascript">SKTFSys.PopUp_SystemIframeFolder();</script>';
        echo $RenderIframe;
        ?>  
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#dialog-form-Administrator").addClass('dialog-form-Administrator-Files');


            $("#dialog").dialog("destroy");
            $("#dialog-form-Administrator").dialog({
                autoOpen: true,
                height: (($(window).height) - 50),
                width: ($(window).width()),
                position: [50, 0],
                modal: true,
                resize: false,
                close: function() {
                    AppSKT.skt_RemoveDialog();
                }
            });
            AppSKT.skt_WrapDialog();
            $(".ui-dialog").addClass('Administrator-Files');
            SKTFSys.init();
        });
    </script>
    <?php
    echo \SKT_ADMIN_AdminWraperClose;
}
?>

