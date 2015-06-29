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
echo \SKT_ADMIN_AdminWraperOpen;
$SKTDB = \CmsDev\sql\db_Skt::connect();

$sections = $SKTDB->get_results("SELECT * FROM sections as Section join Sectionprofile as profile WHERE Section.id = profile.idX ORDER BY Company ASC");
$Options = '';
foreach ($sections as $items) {
    $Options .= '<option value="' . $items->id . '">' . utf8_encode($items->Title) . '</option>';
}
?>
<div class="CreateContentHtml">
    <form action="" method="post" id="Form_sections">
        <input value="Add" name="Add" type="hidden"/>
        <div class="form-group">
            <label>Crear dentr de:</label>
            <select name="Sid" id="Sid" class="form-control">
                <?php echo $Options; ?>
            </select>
        </div>
        <div class="form-group">
            <label>T&iacute;tulo de la Categor&iacute;a</label>
            <input name="Title" id="Title" type="text" class="form-control"  onblur="AppSKT.CheckURLName(this.value, 'url-tag');">
        </div>
        <div class="form-group">
            <label>URL</label>
            <input name="url" id="url-tag" type="text" class="form-control" readonly="readonly">
        </div>
        <div class="form-group">
            <label>Descripci&oacute;n</label>
            <textarea id="Description" name="Description" class="form-control" style="height:100px;" ></textarea>
        </div>
        <div class="form-group">
            <label>Icono</label>
            <input name="icon" id="icon" type="text" value="skt-icon-CmsDev" class="form-control">
        </div>
        <div class="validateTips"></div>
    </form> 
</div> 

<?php echo \SKT_ADMIN_AdminWraperClose ?> 

<script type="text/javascript">
    var tips = $(".validateTips");
    $(document).ready(function () {
        setTimeout('sectionsHTML()', 1000);
    });

    function  sectionsHTML() {
        var translations = [];
        translations['Save'] = SKT_ADMIN_Btn_Save;
        translations['Cancel'] = SKT_ADMIN_Btn_RestartCancel;
        $('.ui-dialog-buttonset button').html(function (i, v) {
            v = v.replace("[Save]", translations['Save']).replace("[Cancel]", translations['Cancel']);
            return v;
        });
    }

    $("#CmsDevDialogContent").dialog({
        autoOpen: true,
        width: 400,
        modal: false,
        title: 'Agregar',
        buttons: {
            '[Save]': function () {
                var URLUPDATE = '/CRUD/ViewEditElementsAsList/Lists/sections/_Create';
                jQuery.ajax({
                    'type': 'POST',
                    'url': '/SKTGoTo/' + admd2(URLUPDATE),
                    'cache': false,
                    'data': $("#Form_sections").serialize(),
                    'success': function (htmlReturn) {
                        if ($.trim(htmlReturn) === "okay") {
                            var ROK = SKT_ADMIN_Message_Update_OK;
                            tips.html(ROK);
                            var wrapperid = '#ListViewElementsSKT';
                            $(wrapperid + ' .InputSelectedListid').val('sections');
                            var URLLIST = '/CRUD/ViewEditElementsAsList/Lists/sections/_Control';
                            jQuery.ajax({
                                'type': 'POST',
                                'url': '/SKTGoTo/' + admd2(URLLIST),
                                'cache': false,
                                'data': $("form#FormLists", wrapperid).serialize(),
                                'success': function (success) {
                                    $('#CmsDevTabsContent').html(success);
                                }
                            });
                            AppSKT.skt_RemoveDialog("#CmsDevDialogContent");
                        } else {
                            var RKO = SKT_ADMIN_Message_Update_Error;
                            tips.html(RKO);
                        }
                    }
                });
            },
            '[Cancel]': function () {
                AppSKT.skt_RemoveDialog("#CmsDevDialogContent");
            }
        },
        close: function () {
            AppSKT.skt_RemoveDialog("#CmsDevDialogContent");
        }
    });
    AppSKT.skt_WrapDialog("#CmsDevDialogContent");
</script>