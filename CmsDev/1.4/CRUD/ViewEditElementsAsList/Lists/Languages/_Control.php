<?php
$Templates = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Templates\_classes;
$Templates->RenderList();
?>
<div style="display:none;">
    <div id="dialogConfirmDeleteItem">
        <span id="text-dialog-confirm">
            <?php echo \SKT_ADMIN_Message_Confirm_Delete_Text ?>
        </span><br />
        <span id="ItemInfo"></span>
    </div>
    <div id="dialogConfirmActivateItem">
        <span id="text-dialog-confirm">
            <?php echo \SKT_ADMIN_Message_Confirm_Activate_Text2 ?>
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
    translations['Activate'] = SKT_ADMIN_Btn_Activate;

    $('.TableListElementsSKT div.skt-btn-list-add').click(function() {
        var Templates_Add = 'SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Templates/Add');
        jQuery.ajax({
            'type': 'POST',
            'url': Templates_Add,
            'cache': false,
            'data': $('form#colectorskt').serialize() + '&IDPage=' + SKT_SECTION_ID,
            'success': function(html) {
                $('#CmsDevDialogContent').append(html);
            }
        });
    });
    $('.TableListElementsSKT i.skt-icon-edit').click(function() {
        var Templates_Edit = 'SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Templates/Edit');
        jQuery.ajax({
            'type': 'POST',
            'url': Templates_Edit,
            'cache': false,
            'data': $('form#colectorskt').serialize() + '&ID=' + $(this).attr('ID'),
            'success': function(html) {
                $('#CmsDevDialogContent').append(html);
            }
        });
    });

    $('.TableListElementsSKT i.skt-icon-cancel').click(function() {
        var ID = $(this).attr('id'.replace('ID', ''));
        var ThisElementInfo = $(this).next('.InfoRemove').html();
        setTimeout(function() {
            AppSKT.skt_WrapDialogRed();
            $('#dialogConfirmDeleteItem #ItemInfo').html(ThisElementInfo);
        }, 500);

        $("#dialog:ui-dialog").dialog("destroy");
        $("#dialogConfirmDeleteItem").dialog({
            resizable: false,
            height: 'auto',
            modal: true,
            title: '<i class="skt-iconblock"></i> <?php echo \SKT_ADMIN_Message_Confirm_Delete_Title ?>',
            buttons: [{
                    text: translations['Cancel'],
                    click: function() {
                        AppSKT.skt_RemoveDialog();
                    }

                }, {
                    text: translations['Delete'],
                    click: function() {
                        var Templates_Delete = 'SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Templates/_Delete');
                        $.ajax({
                            'type': 'POST',
                            'url': Templates_Delete,
                            'cache': false,
                            'data': 'ID=' + ID + '&action=Delete',
                            'success': function(html) {
                                $('#dialogConfirmDeleteItem #text-dialog-confirm').html(html);
                                if ($.trim(html) === "ok") {
                                    var wrapperID = '#ListViewElementsSKT';
                                    $(wrapperID + ' .InputSelectedListID').val('Templates');
                                    var URLLIST = '/CRUD/ViewEditElementsAsList/Lists/Templates/_Control';
                                    jQuery.ajax({
                                        'type': 'POST',
                                        'url': 'SKTGoTo/' + admd2(URLLIST),
                                        'cache': false,
                                        'data': $("form#FormLists", wrapperID).serialize(),
                                        'success': function(success) {
                                            $('#CmsDevTabsContent').html(success);
                                        }
                                    });
                                    AppSKT.skt_RemoveDialog();
                                }
                            }
                        });
                    }
                }],
            close: function() {
                AppSKT.skt_RemoveDialog();
            }
        });
    });

    $('.TableListElementsSKT i.skt-iconcircle-empty').click(function() {
        var ID = $(this).attr('id'.replace('ID', ''));
        var ThisElementInfo = $(this).next('.InfoRemove').html();
        setTimeout(function() {
            AppSKT.skt_WrapDialogRed();
            $('#dialogConfirmActivateItem #ItemInfo').html(ThisElementInfo);
        }, 500);

        $("#dialog:ui-dialog").dialog("destroy");
        $("#dialogConfirmActivateItem").dialog({
            resizable: false,
            height: 'auto',
            width: 550,
            modal: true,
            title: '<i class="skt-iconstar" style="color: yellow ! important; cursor: default;"></i> <?php echo \SKT_ADMIN_Message_Confirm_Activate_Text ?>',
            buttons: [{
                    text: translations['Cancel'],
                    click: function() {
                        AppSKT.skt_RemoveDialog();
                    }

                }, {
                    text: translations['Activate'],
                    click: function() {
                        var Templates_Activate = 'SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Templates/Activate');
                        $.ajax({
                            'type': 'POST',
                            'url': Templates_Activate,
                            'cache': false,
                            'data': 'ID=' + ID + '&action=Activate',
                            'success': function(html) {
                                $('#dialogConfirmActivateItem #text-dialog-confirm').html(html);
                                if ($.trim(html) === "okay") {
                                    var wrapperID = '#ListViewElementsSKT';
                                    $(wrapperID + ' .InputSelectedListID').val('Templates');
                                    var URLLIST = '/CRUD/ViewEditElementsAsList/Lists/Templates/_Control';
                                    jQuery.ajax({
                                        'type': 'POST',
                                        'url': 'SKTGoTo/' + admd2(URLLIST),
                                        'cache': false,
                                        'data': $("form#FormLists", wrapperID).serialize(),
                                        'success': function(success) {
                                            $('#CmsDevTabsContent').html(success);
                                        }
                                    });
                                    AppSKT.skt_RemoveDialog();
                                }
                            }
                        });
                    }
                }],
            close: function() {
                AppSKT.skt_RemoveDialog();
            }
        });
    });


</script>