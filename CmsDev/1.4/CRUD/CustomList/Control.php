<?php
if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    $SKTAJAX = 'AJAX';
    require_once ('../../CmsDev/DefinePath.php');
    require_once ('../../../Config.php');
    require_once ('../../../db.php');
    require_once ('../../CmsDev' . \DS . \SKT_VERSION . \DS . 'Core.php');
}
if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {

    $SKTDB = \CmsDev\sql\db_Skt::connect();
    echo str_replace('[title]', \SKT_ADMIN_TXT_Lists, \SKT_ADMIN_AdminWraperOpen);
    ?>
<style type="text/css">
    #ListActions li.disabled{display: none !important;}
</style>
    <?php require 'TOPNAV.php'; ?>
    <div class="container-fluid" id="CustomListwrapper">
        <div class="row">
            <?php require 'SIDEBAR.php'; ?>
            <div class="col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2 main">
                <h1 class="page-header"></h1>
                <h2 class="sub-header"></h2>
                <div class="table-responsive">
                    <!-- CONTENT -->
                    <form action="" method="post" id="FormLists">
                        <input name="InputSelectedListID" id="InputSelectedListID" class="InputSelectedListID" type="hidden" value="0">
                    </form>
                    <div id="Load_Item"></div>
                    <div id="CmsDevTabsContent"></div>
                    </form>
                    <!-- CONTENT -->              
                </div>
            </div>
        </div>
    </div>
    <?php require '_Scripts.php'; ?>  
    <?php
    echo \SKT_ADMIN_AdminWraperClose;
}
?>