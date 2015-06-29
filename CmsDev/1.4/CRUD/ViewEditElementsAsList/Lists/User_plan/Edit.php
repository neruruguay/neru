<?php
if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    $SKTAJAX = 'AJAX';
    require ('../../../../../../Config.php');
    require ('../../../../../../db.php');
    require ('../../../../Core.php');
}
echo \SKT_ADMIN_AdminWraperOpen;

$id = \GetSQLValueString(\str_replace('id', '', $_POST['id']), "int");
$SKTDB = \CmsDev\sql\db_Skt::connect();
$query = $SKTDB->get_row("SELECT * FROM Products as Product join Productprofile as profile WHERE Product.id = " . \GetSQLValueString($id, "int") . " AND Product.id = profile.idX");

$categories = $SKTDB->get_results("SELECT * FROM " . \DB_PREFIX . "categories ORDER BY Title ASC");

$Options1 = $Options2 = $Options3 = $Options4 = $Options5 = '<option value="">Seleccione una</option>';
foreach ($categories as $items) {
    $category1 = $category2 = $category3 = $category4 = $category5 = '';
    if ($query->category1 === $items->ID) {
        $category1 = 'selected="selected"';
    }
    if ($query->category2 === $items->ID) {
        $category2 = 'selected="selected"';
    }
    if ($query->category3 === $items->ID) {
        $category3 = 'selected="selected"';
    }
    if ($query->category4 === $items->ID) {
        $category4 = 'selected="selected"';
    }
    if ($query->category5 === $items->ID) {
        $category5 = 'selected="selected"';
    }
    $Options1 .= '<option value="' . $items->ID . '" ' . $category1 . '>' . utf8_encode($items->Title) . '</option>';
    $Options2 .= '<option value="' . $items->ID . '" ' . $category2 . '>' . utf8_encode($items->Title) . '</option>';
    $Options3 .= '<option value="' . $items->ID . '" ' . $category3 . '>' . utf8_encode($items->Title) . '</option>';
    $Options4 .= '<option value="' . $items->ID . '" ' . $category4 . '>' . utf8_encode($items->Title) . '</option>';
    $Options5 .= '<option value="' . $items->ID . '" ' . $category5 . '>' . utf8_encode($items->Title) . '</option>';
}
?>

<div class="CreateContentHtml">
    <form action="" method="post" id="Form_Products">
        <input value="Products_Edit" name="Products_Edit" type="hidden"/>
        <input value="<?php echo $query->id; ?>" name="id" type="hidden"/>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nombre de la empresa</label>
                    <input name="Company" id="Company" type="text" class="form-control"  value="<?php echo utf8_encode($query->Company); ?>" onblur="AppSKT.CheckURLName(this.value, 'url-Company');">
                </div>
                <div class="form-group">
                    <label>URL</label>
                    <input name="CompanyUrl" id="url-Company" type="text"  value="<?php echo $query->CompanyUrl; ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label>RUT</label>
                    <input name="RUT" id="RUT" type="text"  value="<?php echo $query->RUT; ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label>Descripci&oacute;n</label>
                    <textarea id="Description" name="Description" class="form-control" style="height:100px;" ><?php echo utf8_encode($query->Description); ?></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <h4>Categor&iacute;as en las que desea figurar.</h4>
                <label>Categor&iacute;a 1</label>
                <select name="category1" id="category1" class="form-control">
                    <?php echo $Options1; ?>
                </select>
                <label>Categor&iacute;a 2</label>
                <select name="category2" id="category2" class="form-control">
                    <?php echo $Options2; ?>
                </select>
                <label>Categor&iacute;a 3</label>
                <select name="category3" id="category3" class="form-control">
                    <?php echo $Options3; ?>
                </select>
                <label>Categor&iacute;a 4</label>
                <select name="category4" id="category4" class="form-control">
                    <?php echo $Options4; ?>
                </select>
                <label>Categor&iacute;a 5</label>
                <select name="category5" id="category5" class="form-control">
                    <?php echo $Options5; ?>
                </select>
            </div>
        </div>
        <div class="validateTips"></div>
    </form> 
</div>
<div class="clear"></div>


<script type="text/javascript">
    var tips = $(".validateTips");
    $(document).ready(function () {
        setTimeout('ProductsHTML()', 1000);
    });

    function  ProductsHTML() {
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
        width: 800,
        modal: false,
        title: 'Editar',
        buttons: {
            '[Save]': function () {
                var URLUPDATE = '/CRUD/ViewEditElementsAsList/Lists/Products/_Update';
                jQuery.ajax({
                    'type': 'POST',
                    'url': '/SKTGoTo/' + admd2(URLUPDATE),
                    'cache': false,
                    'data': $("#Form_Products").serialize(),
                    'success': function (htmlReturn) {
                        if ($.trim(htmlReturn) === "okay") {
                            var ROK = SKT_ADMIN_Message_Update_OK;
                            tips.html(ROK);
                            var wrapperid = '#ListViewElementsSKT';
                            $(wrapperid + ' .InputSelectedListid').val('Products');
                            var URLLIST = '/CRUD/ViewEditElementsAsList/Lists/Products/_Control';
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

<?php echo \SKT_ADMIN_AdminWraperClose ?> 