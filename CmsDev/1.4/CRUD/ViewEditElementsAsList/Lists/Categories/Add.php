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
$category_id = \GetSQLValueString($_POST['ID'], "int");
$category_idx = \GetSQLValueString($_POST['IDX'], "int");
$categories = $SKTDB->get_row("SELECT * FROM " . \DB_PREFIX . "categories WHERE category_id = '" . GetSQLValueString($category_idx, 'int') . "'");

$Optionslevel = '<option value="0">Todos</option>';
$Optionslevel .= '<option value="1">Empresas</option>';
$Optionslevel .= '<option value="2">Usuarios</option>';
?>
<style>
    input.inputUpload, input[type="file"]{
        z-index: 9999999999999999999 !important;
    }
</style>
<div class="CreateContentHtml">
    <form action="" method="post" id="Form_Categories">
        <input value="Add" name="Add" type="hidden"/>
        <input name="category_idx" id="category_idx" type="hidden" value="<?php echo $categories->category_id; ?>" class="form-control">
        <h4>Crear dentro de: <b>"<?php echo utf8_encode($categories->category_name); ?>"</b></h4>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Destino</label>
                    <select name="level" id="level" class="form-control">
                        <?php echo $Optionslevel; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>T&iacute;tulo de la Categor&iacute;a</label>
                    <input name="category_name" id="category_name" type="text" class="form-control"  onblur="AppSKT.CheckURLName(this.value, 'category_url-tag');">
                </div>
                <div class="form-group">
                    <label>URL autom&aacute;tica</label>
                    <input name="category_url" id="category_url-tag" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label>Descripci&oacute;n</label>
                    <textarea id="category_Description" name="category_Description" class="form-control" style="height:100px;" ></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Icono</label>
                    <input name="category_icon" id="category_icon" type="text" value="skt-icon-CmsDev" class="form-control">
                </div>
                <div class="form-group">
                    <?php
                    $FieldName = 'category_' . \RAND_GLOBAL_INSTANCE;
                    $Foto = new \CmsDev\CustomControl\ImageUpload\ImageUpload_Control();
                    $FieldRand = $Foto->Set_Random(md5(rand(9, 999999) . microtime()));
                    $Foto->Set_fileType(array('image/jpeg', 'image/jpg', 'image/png'));
                    $Foto->Set_fileTypeNames('JPG o PNG sin transparencia, con fondo blanco preferentemente.');
                    $Foto->Set_TextButton('Cargar imagen');
                    $Foto->SizeW(400);
                    $Foto->SizeH(400);
                    $Foto->ResizeSize(true);
                    $Foto->CropSize();
                    $Foto->ShowDelete('Quitar imagen');
                    $Foto->Set_Max_Dimension_And_FileSize(600, 600, 2097152);
                    $Foto->Set_Picture(\SKT_URL_BASE . '_FileSystems/transparent.png');
                    $Foto->Set_Directory('_FileSystems' . \DS . 'category_image' . \DS);
                    $Foto->Set_Name($User->username . '_' . $FieldName . md5(microtime()));
                    $Foto->Set_FieldName($FieldName);
                    $Foto->RealName('category_image');
                    $Foto->Make();
                    ?>
<!--            <input name="category_image" id="category_image" type="text" value="skt-icon-CmsDev" class="form-control">-->
                </div>
            </div>
        </div>
        <div class="validateTips"></div>
    </form> 
</div> 

<?php echo \SKT_ADMIN_AdminWraperClose ?> 

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
        title: 'Agregar',
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

                            var UrlSubCategories = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Categories/loadsubcat_admin');
                            jQuery.ajax({
                                'type': 'POST',
                                'url': UrlSubCategories,
                                'cache': false,
                                'data': 'IDX=' + <?php echo $category_idx; ?>,
                                'success': function (data) {
                                    $('.addListContainer').html(data);
                                    $('.addListContainer').removeClass('addListContainer');
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