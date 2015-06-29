<script type="text/javascript">

    $('.skt-btn-list-add', '#idx_' + IDXCat).click(function () {
        var Categories_Add = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Categories/Add');
        var data_group_idx = $(this).closest('.idxgroup').attr('data-group-idx');
        var ThisList = $(this).closest('.Level');
        jQuery.ajax({
            'type': 'POST',
            'url': Categories_Add,
            'cache': false,
            'data': 'IDX=' + data_group_idx,
            'success': function (html) {
                ThisList.addClass('addListContainer');
                $('#CmsDevDialogContent').html(html);
            }
        });
    });

    $('.skt-icon-edit', '#idx_' + IDXCat).click(function () {
        var Categories_Edit = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Categories/Edit');
        var ID = $(this).parent().attr('data-id');
        var IDX = $(this).parent().attr('data-idx');
        var ThisList = $(this).closest('.Level');
        jQuery.ajax({
            'type': 'POST',
            'url': Categories_Edit,
            'cache': false,
            'data': 'ID=' + ID + '&IDX=' + IDX,
            'success': function (html) {
                $('#CmsDevDialogContent').html(html);
            }
        });
    });

    $('.skt-icon-cancel', '#idx_' + IDXCat).click(function () {
        var ID = $(this).parent().attr('data-id');
        var IDX = $(this).parent().attr('data-idx');
        var ThisElementInfo = $(this).next().next('.InfoRemove').html();
        var ThisList = $(this).closest('.Level');
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
            title: 'Borrar',
            buttons: [{
                    text: translations['Cancel'],
                    click: function () {
                        AppSKT.skt_RemoveDialog();
                    }
                }, {
                    text: translations['Delete'],
                    click: function () {
                        var Categories_Delete = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Categories/Delete');
                        $.ajax({
                            'type': 'POST',
                            'url': Categories_Delete,
                            'cache': false,
                            'data': 'ID=' + ID + '&action=Delete',
                            'success': function (html) {
                                $('#dialogConfirmDeleteItem #text-dialog-confirm').html(html);
                                if ($.trim(html) === "ok") {
                                    var UrlSubCategories = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Categories/loadsubcat_admin');
                                    jQuery.ajax({
                                        'type': 'POST',
                                        'url': UrlSubCategories,
                                        'cache': false,
                                        'data': 'IDX=' + IDX,
                                        'success': function (data) {
                                            ThisList.html(data);
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
    var UrlSubCategories = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Categories/loadsubcat_admin');
    $("ul li.listItem a.more", '#idx_' + IDXCat).click(function () {
        $(this).closest('.Level').next('.Level').html('').next('.Level').html('').next('.Level').html('');
        var Next = $(this).closest('.Level').next('.Level');
        $(this).closest('.Level').find('.listItem').removeClass('active');
        $(this).closest('.listItem').addClass('active');
        Next.html('<div class="CustomList TableListElementsSKT row"> Cargando categorias...</div>');
        jQuery.ajax({
            'type': 'POST',
            'url': UrlSubCategories,
            'cache': false,
            'data': 'IDX=' + $(this).attr('data-id'),
            'success': function (data) {
                Next.html(data);
            }
        });
    });
</script>