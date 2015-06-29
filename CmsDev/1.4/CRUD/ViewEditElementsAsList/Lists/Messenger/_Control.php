<?php
$Messenger = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Messenger\_classes;
$Messenger->RenderList();
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
        var  Messenger_Add = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Messenger/Add');
        jQuery.ajax({
            'type': 'POST',
            'url':  Messenger_Add,
            'cache': false,
            'data': $('form#colectorskt').serialize(),
            'success': function (html) {
                $('#CmsDevDialogContent').append(html);
            }
        });
    });
    $('.TableListElementsSKT .skt-icon-edit').click(function () {
        var  Messenger_Edit = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Messenger/Edit');
        jQuery.ajax({
            'type': 'POST',
            'url':  Messenger_Edit,
            'cache': false,
            'data': $('form#colectorskt').serialize() + '&id=' + $(this).attr('id'),
            'success': function (html) {
                $('#CmsDevDialogContent').append(html);
            }
        });
    });

    $('.TableListElementsSKT .skt-icon-docs').click(function () {
        var  Messenger_Duplicate = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Messenger/Duplicate');
        jQuery.ajax({
            'type': 'POST',
            'url':  Messenger_Duplicate,
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
                        var  Messenger_Delete = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Messenger/Delete');
                        $.ajax({
                            'type': 'POST',
                            'url':  Messenger_Delete,
                            'cache': false,
                            'data': 'id=' + id + '&action=Delete',
                            'success': function (html) {
                                $('#dialogConfirmDeleteItem #text-dialog-confirm').html(html);
                                if ($.trim(html) === "ok") {
                                    var wrapperid = '#ListViewElementsSKT';
                                    $(wrapperid + ' .InputSelectedListid').val('Messenger');
                                    var URLLIST = 'CRUD/ViewEditElementsAsList/Lists/Messenger/_Control';
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