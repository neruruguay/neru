<?php
$PurchaseRequestss = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Purchase_Requests\_classes;
echo $PurchaseRequestss->RenderList();
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
        var  PurchaseRequestss_Add = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/PurchaseRequestss/Add');
        jQuery.ajax({
            'type': 'POST',
            'url':  PurchaseRequestss_Add,
            'cache': false,
            'data': $('form#colectorskt').serialize(),
            'success': function (html) {
                $('#CmsDevDialogContent').append(html);
            }
        });
    });
    $('.TableListElementsSKT .skt-icon-edit').click(function () {
        var  PurchaseRequestss_Edit = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/PurchaseRequestss/Edit');
        jQuery.ajax({
            'type': 'POST',
            'url':  PurchaseRequestss_Edit,
            'cache': false,
            'data': $('form#colectorskt').serialize() + '&id=' + $(this).attr('id'),
            'success': function (html) {
                $('#CmsDevDialogContent').append(html);
            }
        });
    });

    $('.TableListElementsSKT .skt-icon-docs').click(function () {
        var  PurchaseRequestss_Duplicate = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/PurchaseRequestss/Duplicate');
        jQuery.ajax({
            'type': 'POST',
            'url':  PurchaseRequestss_Duplicate,
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
                        var  PurchaseRequestss_Delete = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/PurchaseRequestss/Delete');
                        $.ajax({
                            'type': 'POST',
                            'url':  PurchaseRequestss_Delete,
                            'cache': false,
                            'data': 'id=' + id + '&action=Delete',
                            'success': function (html) {
                                $('#dialogConfirmDeleteItem #text-dialog-confirm').html(html);
                                if ($.trim(html) === "ok") {
                                    var wrapperid = '#ListViewElementsSKT';
                                    $(wrapperid + ' .InputSelectedListid').val('PurchaseRequestss');
                                    var URLLIST = 'CRUD/ViewEditElementsAsList/Lists/PurchaseRequestss/_Control';
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