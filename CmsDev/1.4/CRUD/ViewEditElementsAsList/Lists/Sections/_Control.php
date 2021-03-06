<?php
$sections = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Sections\_classes;
$sections->RenderList();
?>
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
    $('.TableListElementsSKT div.skt-btn-list-add').click(function () {
        var  sections_Add = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/sections/Add');
        jQuery.ajax({
            'type': 'POST',
            'url':  sections_Add,
            'cache': false,
            'data': $('form#colectorskt').serialize(),
            'success': function (html) {
                $('#CmsDevDialogContent').append(html);
            }
        });
    });
    $('.TableListElementsSKT .skt-icon-edit').click(function () {
        var  sections_Edit = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/sections/Edit');
        jQuery.ajax({
            'type': 'POST',
            'url':  sections_Edit,
            'cache': false,
            'data': $('form#colectorskt').serialize() + '&id=' + $(this).attr('id'),
            'success': function (html) {
                $('#CmsDevDialogContent').append(html);
            }
        });
    });

    $('.TableListElementsSKT .skt-icon-docs').click(function () {
        var  sections_Duplicate = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/sections/Duplicate');
        jQuery.ajax({
            'type': 'POST',
            'url':  sections_Duplicate,
            'cache': false,
            'data': $('form#colectorskt').serialize() + '&id=' + $(this).attr('id'),
            'success': function (html) {
                $('#CmsDevDialogContent').append(html);
            }
        });
    });
    $('.TableListElementsSKT .skt-icon-cancel').click(function () {
        var id = $(this).attr('id'.replace('id', ''));
        var ThisElementInfo = $(this).next('.InfoRemove').html();
        setTimeout(function () {
            AppSKT.skt_WrapDialogRed();
            $('#dialogConfirmDeleteItem #ItemInfo').html(ThisElementInfo);
        }, 500);

        $("#dialog:ui-dialog").dialog("destroy");
        $("#dialogConfirmDeleteItem").dialog({
            resizable: false,
            width: 550,
            height: 'auto',
            modal: true,
            title: '<?php echo \SKT_ADMIN_Message_Confirm_Delete_Title ?>',
            buttons: [{
                    text: translations['Cancel'],
                    click: function () {
                        AppSKT.skt_RemoveDialog();
                    }

                }, {
                    text: translations['Delete'],
                    click: function () {
                        var  sections_Delete = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/sections/Delete');
                        $.ajax({
                            'type': 'POST',
                            'url':  sections_Delete,
                            'cache': false,
                            'data': 'id=' + id + '&action=Delete',
                            'success': function (html) {
                                $('#dialogConfirmDeleteItem #text-dialog-confirm').html(html);
                                if ($.trim(html) === "ok") {
                                    var wrapperid = '#ListViewElementsSKT';
                                    $(wrapperid + ' .InputSelectedListid').val('sections');
                                    var URLLIST = 'CRUD/ViewEditElementsAsList/Lists/sections/_Control';
                                    jQuery.ajax({
                                        'type': 'POST',
                                        'url': '/SKTGoTo/' + admd2(URLLIST),
                                        'cache': false,
                                        'data': $("form#FormLists", wrapperid).serialize(),
                                        'success': function (success) {
                                            $('#CmsDevTabsContent').html(success);
                                        }
                                    });
                                    AppSKT.skt_RemoveDialog();
                                }
                            }
                        });
                    }
                }],
            close: function () {
                AppSKT.skt_RemoveDialog();
            }
        });
    });

</script>