
<script type="text/javascript">
    var CustomListSKT = function () {
        return {
            SelectListsChange: function (ID, Name, linklist) {
                $('#CustomListwrapper .page-header').text(Name);
                $('#CustomListwrapper .InputSelectedListID').val(ID);
                $('.selectLists a').removeClass('active');
                $(linklist).addClass('active');

                jQuery.ajax({
                    'type': 'POST',
                    'url': SERVER_DIR + SKTURL + '_Service_/p/Lists/GetHowUse/' + ID,
                    'cache': false,
                    'data': $("form#FormLists", "#CustomListwrapper").serialize(),
                    'success': function (success) {
                        $('#CmsDevTabsContent').html(success);
                        CustomListSKT.ListActions('GetHowUse');
                        $('pre code').each(function (i, e) {
                            hljs.highlightBlock(e)
                        });
                    }
                });
            },
            GetHowUse: function () {

                var ListSelected = $("#CustomListwrapper select#Lists option:selected");
                if (ListSelected.val() !== '') {
                    $('#CustomListwrapper .InputSelectedListID').val(ListSelected.val());
                    jQuery.ajax({
                        'type': 'POST',
                        'url': SERVER_DIR + SKTURL + '_Service_/p/Lists/GetHowUse/' + ListSelected.val(),
                        'cache': false,
                        'data': $("form#FormLists", "#CustomListwrapper").serialize(),
                        'success': function (success) {
                            $('#CmsDevTabsContent').html(success);
                            CustomListSKT.ListActions('GetHowUse');
                            $('pre code').each(function (i, e) {
                                hljs.highlightBlock(e)
                            });
                        }
                    });
                } else {
                    jQuery.ajax({
                        'type': 'POST',
                        'url': SERVER_DIR + SKTURL + '_Service_/p/Lists/GetHowUse/Demo',
                        'cache': false,
                        'data': $("form#FormLists", "#CustomListwrapper").serialize(),
                        'success': function (success) {
                            $('#CmsDevTabsContent').html(success);
                            CustomListSKT.ListActions('GetHowUse');
                            $('pre code').each(function (i, e) {
                                hljs.highlightBlock(e)
                            });
                        }
                    });
                }

            },
            SubmitForm_Add_List: function () {
                $('#SubmitForm_List_Add_List').click(function () {

                    var ListName = $('#Add_List_Form #ListName').val();
                    var Field1 = $('#Add_List_Form #Field1').val();
                    if (ListName === '') {
                        $('.validateTips').show().html('Escriba el Nombre de la lista y al menos el Campo1');
                    } else if (Field1 === '') {
                        $('.validateTips').show().html('Escriba el Nombre del Campo1');
                    } else {
                        jQuery.ajax({
                            'type': 'POST',
                            'url': URL_Query_List_Add_List,
                            'cache': false,
                            'data': $("form#Add_List_Form", "#CustomListwrapper").serialize(),
                            'success': function (success_List_Edit_Properties) {
                                if (success_List_Edit_Properties.indexOf('okay') !== -1) {
                                    var ListID = success_List_Edit_Properties.replace('|okay', '');
                                    var ListName = $('#Add_List_Form #ListName').val();
                                    $("#CustomListwrapper .InputSelectedListID").val($.trim(ListID));
                                    $('.validateTips').show().html('Lista creada con &eacute;xito:' + ListName);
                                    CustomListSKT.Editlist();
                                } else {
                                    var RKO = '<label><div class="ui-state-error ui-corner-all"><p>' + SKT_ADMIN_Message_Update_Error + '<span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span></p></div></label>';
                                    $('.validateTips').show().html(RKO);
                                }
                            }
                        });
                    }
                });
            },
            SelectLists: function () {
                jQuery.ajax({
                    'type': 'POST',
                    'url': URL_View_List_SelectList,
                    'cache': false,
                    'data': $("form#FormLists", "#CustomListwrapper").serialize(),
                    'success': function (data) {
                        $('#SelectLists').html(data);
                        CustomListSKT.SelectListsChange();
                        CustomListSKT.ListActions('SelectLists');
                    }
                });
            },
            AddList: function () {
                jQuery.ajax({
                    'type': 'POST',
                    'url': URL_View_List_Add_List,
                    'cache': true,
                    'data': $("form#FormLists", "#CustomListwrapper").serialize(),
                    'success': function (data) {
                        $('#CmsDevTabsContent').html(data);
                        CustomListSKT.ListActions('AddList');
                        CustomListSKT.SubmitForm_Add_List();
                    }
                });
            },
            Editlist: function () {
                jQuery.ajax({
                    'type': 'POST',
                    'url': URL_View_List_Properties,
                    'cache': false,
                    'data': $("form#FormLists", "#CustomListwrapper").serialize(),
                    'success': function (success_List_Properties) {
                        $('#CmsDevTabsContent').html(success_List_Properties);
                        var ListName = $('#CustomListwrapper .InputSelectedListID').val();
                        CustomListSKT.ListActions('Editlist');
                    }
                });
            },
            Deletelist: function (ID) {
                jQuery.ajax({
                    'type': 'POST',
                    'url': URL_Query_Delete_List_query,
                    'cache': false,
                    'data': 'ID=' + ID,
                    'success': function (data) {
                        $('#CmsDevTabsContent').html(data);
                        location.reload();
                    }
                });
            },
            ViewItems: function () {
                jQuery.ajax({
                    'type': 'POST',
                    'url': URL_View_List_Items,
                    'cache': false,
                    'data': $("form#FormLists", "#CustomListwrapper").serialize(),
                    'success': function (success_List_Items) {
                        $('#CmsDevTabsContent').html(success_List_Items);
                        var ListName = $('#CustomListwrapper .InputSelectedListID').val();
                        CustomListSKT.ListActions('ViewItems');
                    }
                });
            },
            EditItem: function (ID, ListID) {
                jQuery.ajax({
                    'type': 'POST',
                    'url': URL_Edit_Item,
                    'cache': false,
                    'data': 'ID=' + ID + '&ListID=' + ListID,
                    'success': function (Load_Item) {
                        $('#Load_Item').html(Load_Item);
                    }
                });
            },
            AddItem: function () {
                jQuery.ajax({
                    'type': 'POST',
                    'url': URL_View_Add_Item,
                    'cache': false,
                    'data': $("form#FormLists", "#CustomListwrapper").serialize(),
                    'success': function (success_List_Properties) {
                        $('#CmsDevTabsContent').html(success_List_Properties);
                        CustomListSKT.ListActions('AddItem');
                    }
                });
            },
            skt_WrapDialog: function () {
                $('body').addClass('overflowHidden');
                $('.ui-dialog, .ui-widget-overlay').wrap('<div class="skt" />');
                setTimeout('CustomListSKT.skt_MinDialog();', 1000);
            },
            skt_MinDialog: function () {
                $('.skt .ui-dialog .ui-dialog-titlebar').append('<a href="javascript:void(0);" id="dialog-maximize"><span class="skt-icon-expand">min</span></a>');
                $('.skt .ui-dialog #dialog-maximize').click(function () {
                    $('.skt .ui-dialog .ui-dialog-content').toggleClass('hidden');
                    $('.skt .ui-dialog').toggleClass('skt-dialog-hidden');
                    $('.ui-widget-overlay').toggleClass('skt-dialog-hidden');
                });
            },
            skt_RemoveDialog: function () {
                $('body').removeClass('overflowHidden');
                $('.ui-widget-overlay').remove();
                $('body #CustomListwrapper').remove();
                $('body > .skt:not(".SKTNotRemove")').remove();
            },
            ListActions: function (e) {
                $('#ListActions li').removeClass('disabled').removeClass('active');
                $('#Load_Item').html('');
                switch (e)
                {
                    case 'SelectLists':
                        $('#ListActions li.SelectLists').addClass('active');
                        $('#ListActions li.Editlist').addClass('disabled');
                        $('#ListActions li.ViewItems').addClass('disabled');
                        $('#ListActions li.AddItem').addClass('disabled');
                        $('#CustomListwrapper .sub-header').html('<i class="skt-icon-left-open"></i> Seleccione una lista para comenzar');
                        break;
                    case 'AddList':
                        $('#ListActions li.AddList').addClass('active');
                        $('#ListActions li.Editlist').addClass('disabled');
                        $('#ListActions li.ViewItems').addClass('disabled');
                        $('#ListActions li.AddItem').addClass('disabled');
                        $('#CustomListwrapper .sub-header').html('<i class="skt-icon-new"></i> Genere una nueva lista');
                        break;
                    case 'Editlist':
                        $('#ListActions li.Editlist').addClass('active');
                        $('#CustomListwrapper .sub-header').html('<i class="skt-icon-config"></i> Editando configuraciones');
                        break;
                    case 'ViewItems':
                        $('#ListActions li.ViewItems').addClass('active');
                        $('#CustomListwrapper .sub-header').html('<i class="skt-icon-view-3"></i> Listado de contenidos de la lista');
                        break;
                    case 'AddItem':
                        $('#ListActions li.AddItem').addClass('active');
                        $('#CustomListwrapper .sub-header').html('<i class="skt-icon-new"></i> Agregar ítems a la lista');
                        break;
                    case 'GetHowUse':
                        $('#ListActions li.GetHowUse').addClass('active');
                        $('#CustomListwrapper .sub-header').html('<i class="skt-icon-help"></i> Como usar la lista en tu web');
                        break;
                    default:
                        $('#ListActions li.SelectLists').addClass('active');
                        $('#ListActions li.Editlist').addClass('disabled');
                        $('#ListActions li.ViewItems').addClass('disabled');
                        $('#ListActions li.AddItem').addClass('disabled');
                        $('#CustomListwrapper .sub-header').html('<i class="skt-icon-left-open"></i> Seleccione/Genere una lista para comenzar');
                }
                if ($('#InputSelectedListID').val() == '') {
                    $('#ListActions li.Editlist').addClass('disabled');
                    $('#ListActions li.ViewItems').addClass('disabled');
                    $('#ListActions li.AddItem').addClass('disabled');
                }

            }
        };
    }();
    $(document).ready(function () {

        $('#CustomListwrapper .validateTips').hide();

        /* ----------------------------- CREATE DIALOG --------------------------------------------------*/
        $(function () {
            $("#dialog").dialog("destroy");
            $("#dialog-form-Administrator").dialog({
                autoOpen: true,
                height: (($(window).height()) - 50),
                width: ($(window).width()),
                position: [50, 0],
                modal: true,
                resize: false,
                close: function () {
                    CustomListSKT.skt_RemoveDialog();
                }
            });
            $(".ui-dialog").addClass('Administrator-List');
            CustomListSKT.skt_WrapDialog();
            CustomListSKT.SubmitForm_Add_List();
            CustomListSKT.SelectLists();
            CustomListSKT.ListActions();
        });

        /* ----------------------------- END CREATE DIALOG --------------------------------------------------*/
    });

</script> 