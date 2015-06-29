<?php
$glob = \CmsDev\util\globals::init();
$SKT = $glob->getVar('SKT');
if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
    $SKT_Header = \CmsDev\Header\Make::instance();
    $SKT_Header->lang('es');
    $SKT_Header->charset('windows-1252');
    $SKT_Header->base(\SKT_URL_BASE);
    $SKT_Header->custom("<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,800,600' rel='stylesheet' type='text/css'>");
    echo $SKT_Header->RenderHeader();
    ?>
    <body>
        <div class="skt">
            <div class="pft-directory">
                <span class="skt-icon-folder iconfolder iconmore"></span>
                <a href="javascript:SKTFSys.ViewFolderList('L2hvbWUvY21zZGV2L3B1YmxpY19odG1sL3NpdGlvcy8yMDE0L19GaWxlU3lzdGVtcy9pbWFnZXM');">
                    <span>Ra&iacute;z</span>
                </a>
            </div>
            <?php
            $arrayFilter = array('dir');
            echo \CmsDev\AdminFilesystem\List_Directory::FolderSystemUL(\LOCAL_FILESYSTEM, "javascript:AppSKT.ViewFolderList('[this]');", $arrayFilter);
            ?>  
        </div>
    </body>
<?php } ?>