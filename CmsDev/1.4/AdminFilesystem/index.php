<?php
if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    require ('../../../Config.php');
    require ('../../../db.php');
    require ('../Core.php');
}
$SKTDB = \CmsDev\sql\db_Skt::connect();
include_once \SKTPATH_TemplateSite. 'Config.php';

if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
    ?>

    <?php
    echo \CmsDev\Security\LoadHeader::loadOnFileSystem(TRUE);
    ?>
    <body>
        <style media="all" type="text/css">
            body { margin: 0 !important; overflow: hidden !important; padding: 0 !important; }
            .FolderSystemUL,
            .FileSystemUL { border-right: 1px solid #2E79DE; display: block; font-size: 12px; height: 100% !important; letter-spacing: 1px; line-height: 1.5; margin: 0 !important; padding: 0 !important; position: fixed; width: 30%; }
            #IframeFiles { display: block; height: 100%; overflow-x: hidden; position: fixed; left: 30%; right: 0; top: 0; width: 69.8%; }
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
    </body>
    <script type="text/javascript">
        $(document).ready(function() {
            SKTFSys.init();
        });
    </script>
<?php } ?>