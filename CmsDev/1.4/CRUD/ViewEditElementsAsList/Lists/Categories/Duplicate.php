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

$category_id = \GetSQLValueString(\str_replace('category_id', '', $_POST['category_id']), "int");
$SKTDB = \CmsDev\sql\db_Skt::connect();
$query = $SKTDB->get_row("SELECT * FROM " . \DB_PREFIX . "categories WHERE category_id = " . \GetSQLValueString($category_id, "int") . " ");
?>

<div class="CreateContentHtml">
    <form action="" method="post" id="Form_Categories">
        <input value="Add" name="Add" type="hidden"/>
        <div class="form-group">
            <label>category_id del Padre</label>
            <input name="category_idx" id="category_idx" type="text"  value="" class="form-control">
        </div>
        <div class="form-group">
            <label>T&iacute;tulo de la Categor&iacute;a</label>
            <input name="category_name" id="category_name" type="text" class="form-control"  value="<?php echo utf8_encode($query->category_name); ?>" onblur="AppSKT.Checkcategory_urlName(this.value, 'category_url-tag');">
        </div>
        <div class="form-group">
            <label>URL</label>
            <input name="category_url" id="category_url-tag" type="text"  value="<?php echo $query->category_url; ?>" class="form-control" readonly="readonly">
        </div>
        <div class="form-group">
            <label>Descripci&oacute;n</label>
            <textarea id="category_Description" name="category_Description" class="form-control" style="height:100px;" ><?php echo utf8_encode($query->category_Description); ?></textarea>
        </div>
        <div class="form-group">
            <label>Icono</label>
            <input name="category_icon" id="category_icon" type="text" value="<?php echo $query->category_icon; ?>" class="form-control">
        </div>
        <div class="validateTips"></div>

    </form> 
</div>
<div class="clear"></div>


<script type="text/javascript">
    var tips = $(".validateTips");
    $(document).ready(function () {
        setTimeout('CategoriesHTML()', 1000);
    });

    function CategoriesHTML() {
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
        title: 'Duplicar',
        buttons: {
            '[Save]': function () {
                var URLUPDATE = '/CRUD/ViewEditElementsAsList/Lists/Categories/_Create';
                jQuery.ajax({
                    'type': 'POST',
                    'url': '/SKTGoTo/' + admd2(URLUPDATE),
                    'cache': false,
                    'data': $("#Form_Categories").serialize(),
                    'success': function (htmlReturn) {
                        if ($.trim(htmlReturn) === "okay") {
                            var ROK = SKT_ADMIN_Message_Update_OK;
                            tips.html(ROK);
                            var wrapperID = '#ListViewElementsSKT';
                            $(wrapperID + ' .InputSelectedListID').val('Categories');
                            var URLLIST = '/CRUD/ViewEditElementsAsList/Lists/Categories/_Control';
                            jQuery.ajax({
                                'type': 'POST',
                                'url': '/SKTGoTo/' + admd2(URLLIST),
                                'cache': false,
                                'data': $("form#FormLists", wrapperID).serialize(),
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