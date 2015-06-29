<?php
if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    $SKTAJAX = 'AJAX';
    require ('../../../Config.php');
    require ('../../../db.php');
    require ('../../Core.php');
}
include_once \SKTPATH_TemplateSite . 'Config.php';
$SKTDB = \CmsDev\sql\db_Skt::connect();
if (\CmsDev\Security\loginIntent::action('validate', 'ViewEditElementsAsList', 'Edit') === true) {

    echo \CmsDev\Security\LoadHeader::loadOnFileSystem();
    ?>
<body style="padding: 0 !important;">
        <style media="all" type="text/css">
            body { margin: 0 !important; overflow: hidden !important; padding: 0 !important; border:0 none !important}
        </style>
        <div class="skt SKTNotRemove" id="ListViewElementsSKT">

                <form action="" method="post" id="FormLists">
                    <div class="SKTrow6 bg-2-i padding">
                        <?php \CmsDev\CRUD\ViewEditElementsAsList\_ViewList::get(); ?>
                        <input name="InputSelectedListID" id="InputSelectedListID" class="InputSelectedListID" type="hidden" value="0">
                        <a id="RefreshList" href="javascript:void(0);" class="color-4-i size-4-i"><i class="skt-icon-spin3 color-4-i size-4-i"></i> Recargar esta vista</a>
                    </div>
                </form>
                <div id="CmsDevTabsContent">

                </div>
                <div id="CmsDevDialogContent">

                </div>
            </div>
            <div class="clear"></div>
            <script type="text/javascript">
                var wrapperID = '#ListViewElementsSKT';
                var ListElementsSKT = function () {
                    return {
                        SelectListsChange: function () {
                            $(wrapperID + " select#ListType").change(function () {
                                var ListSelected = $(wrapperID + " select#ListType option:selected");
                                if (ListSelected.val() !== '') {
                                    $(wrapperID + ' .InputSelectedListID').val(ListSelected.val());
                                    var URLLIST = '/CRUD/ViewEditElementsAsList/Lists/' + ListSelected.val() + '/_Control';
                                    jQuery.ajax({
                                        'type': 'POST',
                                        'url': SKTGoTo + admd2(URLLIST),
                                        'cache': false,
                                        'data': $("form#FormLists", wrapperID).serialize(),
                                        'success': function (success) {
                                            $('#CmsDevTabsContent').html(success);
                                        }
                                    });
                                }
                            });
                        }
                    };
                }();
                $(document).ready(function () {
                    ListElementsSKT.SelectListsChange();
                    $("#RefreshList").click(function () {
                        var ListSelected = $(wrapperID + " select#ListType option:selected");
                        if (ListSelected.val() !== '') {
                            $(wrapperID + ' .InputSelectedListID').val(ListSelected.val());
                            var URLLIST = '/CRUD/ViewEditElementsAsList/Lists/' + ListSelected.val() + '/_Control';
                            jQuery.ajax({
                                'type': 'POST',
                                'url': SKTGoTo + admd2(URLLIST),
                                'cache': false,
                                'data': $("form#FormLists", wrapperID).serialize(),
                                'success': function (success) {
                                    $('#CmsDevTabsContent').html(success);
                                }
                            });
                        }
                    })
                });
            </script> 

        </div>
    </body>

<?php } ?>