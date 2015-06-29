<?php
$ReusableComponent = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\ReusableComponent\_classes;
$ReusableComponent->RenderList();
?>
<div style="display:none;">
    <div id="dialogConfirmDeleteItem">
        <span id="text-dialog-confirm">
            <?php echo \SKT_ADMIN_Message_Confirm_Delete_Text ?>
        </span><br />
        <span id="ItemInfo"></span>
    </div>
</div>
<script type="text/javascript" src="<?php echo \ASSETS; ?>js/more/highlight.pack.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo \ASSETS; ?>ccs/vs.css"/>
<script type="text/javascript">
    var translations = [];
    translations['Ok'] = SKT_ADMIN_Btn_Acept;
    translations['Create'] = SKT_ADMIN_Btn_Create;
    translations['Cancel'] = SKT_ADMIN_Btn_RestartCancel;
    translations['Delete'] = SKT_ADMIN_Btn_Delete;
    translations['Save'] = SKT_ADMIN_Btn_Save;
    translations['Edit'] = SKT_ADMIN_Btn_Edit;
    $('.TableListElementsSKT div.skt-btn-list-add').click(function() {
        var ReusableComponent_Add = 'SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/ReusableComponent/Add');
        jQuery.ajax({
            'type': 'POST',
            'url': ReusableComponent_Add,
            'cache': false,
            'data': $('form#colectorskt').serialize() + '&IDPage=' + SKT_SECTION_ID,
            'success': function(html) {
                $('#CmsDevDialogContent').append(html);
            }
        });
    });
    $('.TableListElementsSKT div.skt-btn-list-addScript').click(function() {
        var ReusableComponent_Add = 'SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/ReusableComponent/AddScript');
        jQuery.ajax({
            'type': 'POST',
            'url': ReusableComponent_Add,
            'cache': false,
            'data': $('form#colectorskt').serialize() + '&IDPage=' + SKT_SECTION_ID,
            'success': function(html) {
                $('#CmsDevDialogContent').append(html);
            }
        });
    });
    $('.TableListElementsSKT i.skt-icon-code').click(function() {
        $(this).parent().parent().next('.CodePreview').toggle();
    });
    $('.TableListElementsSKT i.xml').click(function() {
        var ReusableComponent_Edit = 'SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/ReusableComponent/Edit');
        jQuery.ajax({
            'type': 'POST',
            'url': ReusableComponent_Edit,
            'cache': false,
            'data': $('form#colectorskt').serialize() + '&ID=' + $(this).attr('ID'),
            'success': function(html) {
                $('#CmsDevDialogContent').append(html);
            }
        });
    });
    $('.TableListElementsSKT i.script').click(function() {
        var ReusableComponent_EditScript = 'SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/ReusableComponent/EditScript');
        jQuery.ajax({
            'type': 'POST',
            'url': ReusableComponent_EditScript,
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
            width: 550,
            height: 'auto',
            modal: true,
            title: '<?php echo \SKT_ADMIN_Message_Confirm_Delete_Title ?>',
            buttons: [{
                    text: translations['Cancel'],
                    click: function() {
                        AppSKT.skt_RemoveDialog();
                    }

                }, {
                    text: translations['Delete'],
                    click: function() {
                        var ReusableComponent_Delete = 'SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/ReusableComponent/_Delete');
                        $.ajax({
                            'type': 'POST',
                            'url': ReusableComponent_Delete,
                            'cache': false,
                            'data': 'ID=' + ID + '&action=Delete',
                            'success': function(html) {
                                $('#dialogConfirmDeleteItem #text-dialog-confirm').html(html);
                                if ($.trim(html) === "ok") {
                                    var wrapperID = '#ListViewElementsSKT';
                                    $(wrapperID + ' .InputSelectedListID').val('ReusableComponent');
                                    var URLLIST = '/CRUD/ViewEditElementsAsList/Lists/ReusableComponent/_Control';
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

    $('pre code').each(function(i, e) {
        hljs.highlightBlock(e);
    });

</script>