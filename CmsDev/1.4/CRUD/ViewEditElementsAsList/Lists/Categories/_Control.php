<link href="<?php echo SKTURL_TemplateSite; ?>assets/css/font_awesome.css" rel="stylesheet" type="text/css"/>
<?php
$Categories = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Categories\_classes;
$SKTDB = \CmsDev\Sql\db_Skt::connect();
?>
<div id="DataContent">
    <?php
    $Categories->RenderList();
    ?>
</div>
<div style="display:none;">
    <div id="dialogConfirmDeleteItem">
        <span id="text-dialog-confirm">
            <?php echo \SKT_ADMIN_Message_Confirm_Delete_Text ?>
        </span><br />
        <span id="ItemInfo"></span>
    </div>
</div>
<script type="text/javascript">
    var translations = [];
    translations['Ok'] = SKT_ADMIN_Btn_Acept;
    translations['Create'] = SKT_ADMIN_Btn_Create;
    translations['Cancel'] = SKT_ADMIN_Btn_RestartCancel;
    translations['Delete'] = SKT_ADMIN_Btn_Delete;
    translations['Save'] = SKT_ADMIN_Btn_Save;
    translations['Edit'] = SKT_ADMIN_Btn_Edit;
    $(document).ready(function () {
        var UrlSubCategories = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Categories/Render');
        $("#parent_cat").change(function () {

            $("#DataContent").html('<div class="skt-icon-config"> Cargando categorias...</div>');
            jQuery.ajax({
                'type': 'POST',
                'url': UrlSubCategories,
                'cache': false,
                'data': 'parent_cat=' + $(this).val(),
                'success': function (data) {
                    $("#DataContent").html(data);
                }
            });


        });
    });
</script>
