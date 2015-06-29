
var AppSKT = function () {
    var translations = [];
    translations['Ok'] = SKT_ADMIN_Btn_Acept;
    translations['Create'] = SKT_ADMIN_Btn_Create;
    translations['Cancel'] = SKT_ADMIN_Btn_RestartCancel;
    translations['Delete'] = SKT_ADMIN_Btn_Delete;
    translations['Save'] = SKT_ADMIN_Btn_Save;
    translations['Edit'] = SKT_ADMIN_Btn_Edit;
    var wWidth = $(window).width();
    var dWidth = Math.ceil(wWidth * 0.8);
    var wHeight = $(window).height();
    var dHeight = Math.ceil(wHeight * 0.8);

    $(window).resize(function () {
        var win = $('.ui-resizable');
        $('#dialog-form-Administrator .FolderSystemUL, #dialog-form-Administrator .FileSystemUL').css({'overflow-y': 'auto', 'height': ($('#dialog-form-Administrator').height() - 300)});
    });
    $(document).ready(function () {
        $("#SKTAdminNav input[type=submit], #SKTAdminNav li a.button, .skt button").button();
        if (!$('#ErrorReport').text() || $('#ErrorReport').text() === '') {
            $('#ErrorReport').html('No se encontraron errores !').prev('strong').remove();
        }
        $('#View_DesignCMS, #ActionAddElement').change(function () {
            AppSKT.skt_RemoveDialog();
            $(this).parent().parent('form').submit();
        });
        $("#LabelView_DesignCMS0").click(function () {
            AppSKT.View_DesignCMSShow();
            $.cookie("View_DesignCMS", "0", size, {expires: 7, path: '/'});
            $(this).addClass('active');
            $('#LabelView_DesignCMS1').removeClass('active');
        });
        $("#LabelView_DesignCMS1").click(function () {
            AppSKT.View_DesignCMSHide();
            $.cookie("View_DesignCMS", "1", size, {expires: 7, path: '/'});
            $(this).addClass('active');
            $('#LabelView_DesignCMS0').removeClass('active');
        });
        $('#PanelActionAdd').show();
        $(".dropdownTasks .dd ul li a").click(function () {
            $("#Action").val(AppSKT.getSelectedValue($(this)));
            if (AppSKT.getSelectedValue($(this)) > 0) {
                var URL_ACT = 'SKTGoTo/' + AdmAct[AppSKT.getSelectedValue($(this))];
                $.ajax({
                    'type': 'POST',
                    'url': URL_ACT,
                    'cache': false,
                    'data': $('form#colectorskt').serialize() + '&IDPage=' + SKT_SECTION_ID,
                    'success': function (html) {
                        $('body').append(html);
                    }
                });
            } else {
                $("#ActionAdd").submit();
            }
        });
        $(".CmsDevEditButton").button();
        $(".CmsDevEditCMS").click(function () {
            $('.EditorActive h3.ui-state-active').removeClass('ui-state-active');
            $(this).parent().parent().parent().addClass('ui-state-active');
            var data = $(this).parent().parent().parent().next('div').attr('id');
            var dataEd = data.split('_');
            var ID = dataEd[1];
            var IDPage = dataEd[2];
            var IDZone = dataEd[3];
            var EdDate = dataEd[4];
            var Title = $(this).parent().parent().parent().next('div').attr('rel');
            $.ajax({
                'type': 'POST',
                'url': URL_Content_Edit_HTML,
                'cache': false,
                'data': 'ID=' + ID,
                'success': function (html) {
                    $('body').append(html);
                }
            });
        });
        $("#SKTaccordionLeft").accordion({
            heightStyle: "content",
            collapsible: true
        });
        $(".SKTViewModeSet").buttonset();
        $("#SKTAdminNav input[type=submit], #SKTAdminNav li a.button, .skt button").button();


        $(".EditorHeaderTitle .CmsDevIcon .Property").click(function () {
            $('.EditorActive h3.ui-state-active').removeClass('ui-state-active');
            $(this).parent().parent().parent().addClass('ui-state-active');
            var data = $(this).parent().parent().parent().next('div').attr('id');
            var dataEd = data.split('_');
            var ID = dataEd[1];
            $.ajax({
                'type': 'POST',
                'url': SERVER_DIR + URL_QueryContentProp,
                'cache': false,
                'data': 'ID=' + ID + '&IDPage=' + SKT_SECTION_ID,
                'success': function (html) {
                    $('body').append(html);
                }
            });
        });

        $('#PrintScreen').click(function () {
            html2canvas($('body'), {
                onrendered: function (canvas) {
                    var print = '<div id="dialogPrintScreen" title="Click derecho > guardar imagen como..."></div>';
                    $('body').append(print);
                    $("#dialogPrintScreen").html(canvas);
                    $("#dialogPrintScreen").dialog({resizable: false,
                        height: 'auto',
                        width: '990',
                        modal: true,
                        close: function () {
                            AppSKT.skt_RemoveDialog();
                            $("#dialogPrintScreen").remove();
                        }}).parent();
                    AppSKT.skt_WrapDialog();
                }
            });
        });


        $('.EditorHeaderTitle .CmsDevIcon .Recycle').click(function () {
            $('.EditorActive h3.ui-state-active').removeClass('ui-state-active');
            $(this).parent().parent().parent().addClass('ui-state-active');
            var data = $(this).parent().parent().parent().next('div').attr('id');
            var dataEd = data.split('_');
            var ID = dataEd[1];
            $.ajax({
                'type': 'POST',
                'url': URL_QueryDeleteContent,
                'cache': false,
                'data': 'ID=' + ID + '&action=Recycle',
                'success': function (e) {
                    location.reload();
                }
            });
        });

        $('.EditorHeaderTitle .CmsDevIcon .Delete').click(function () {
            setTimeout('AppSKT.skt_WrapDialog();', 200);
            var data = $(this).parent().parent().parent().next('div').attr('id');
            var Control = $(this).parent().parent().parent().parent();
            var thisdialog = $(this);
            var dataEd = data.split('_');
            var ID = dataEd[1];
            $("#dialog:ui-dialog").dialog("destroy");
            $("#dialog-confirm").dialog({
                resizable: false,
                height: 'auto',
                width: 550,
                modal: true,
                buttons: [{
                        text: translations['Cancel'],
                        click: function () {
                            AppSKT.skt_RemoveDialog();
                        }

                    }, {
                        text: translations['Delete'],
                        click: function () {
                            $.ajax({
                                'type': 'POST',
                                'url': URL_QueryDeleteContent,
                                'cache': false,
                                'data': 'ID=' + ID + '&action=Delete',
                                'success': function (html) {
                                    $('#text-dialog-confirm').html(html);
                                    thisdialog.parent().parent().remove();
                                    Control.remove();
                                    AppSKT.skt_RemoveDialog();
                                }
                            });
                        }
                    }],
                close: function () {
                    AppSKT.skt_RemoveDialog();
                }
            });
        });

        $('input#SubmitFormContentProp').click(function () {
            $.ajax({
                'type': 'POST',
                'url': URL_QueryContentProp,
                'cache': false,
                'data': $("form#ContentProp").serialize(),
                'success': function (html) {
                    $("#server_response_ContentProp").html(html);
                }
            });
            return false;
        });
        $("#dialog:ui-dialog").dialog("destroy");
        $("#PopUpEditor").dialog({
            autoOpen: false,
            height: 500,
            classname: 'skt',
            width: 990,
            modal: true,
            buttons: [{
                    text: translations['Save'],
                    click: function () {
                        $.ajax({
                            'type': 'POST',
                            'url': URL_QueryUpdateContent,
                            'cache': false,
                            'data': $("form", ".containerPopUp").serialize(),
                            'success': function (Successhtml) {
                                var Success = Successhtml.replace('okay', '');
                                $("#server_response").html(Success);
                                Update = $("#UpdateDiv").val();
                                $("div[id^='" + Update + "']").html(Success);
                                $("#dialog:ui-dialog").dialog("destroy");
                                $("#dialog:ui-dialog").dialog("close");
                            }
                        });
                        AppSKT.skt_HideDialogPopUpEditor();
                    }

                }, {
                    text: translations['Cancel'],
                    click: function () {
                        AppSKT.skt_HideDialogPopUpEditor();
                    }
                }],
            close: function () {
                AppSKT.skt_HideDialogPopUpEditor();
            }
        }).parent().wrap('<div class="skt"></div>');

        $(".CmsDevEditScript").click(function () {
            $("#dialog:ui-dialog").dialog("destroy");
            $('.EditorActive h3.ui-state-active').removeClass('ui-state-active');
            $(this).parent().parent().parent().addClass('ui-state-active');
            var data = $(this).parent().parent().parent().next('div').attr('id');
            var dataEd = data.split('_');
            var ID = dataEd[1];
            var IDPage = dataEd[2];
            var IDZone = dataEd[3];
            var EdDate = dataEd[4];
            var Title = $(this).parent().parent().parent().next('div').attr('rel');
            $.ajax({
                'type': 'POST',
                'url': SERVER_DIR + URL_Content_Edit_PlainText,
                'cache': false,
                'data': 'ID=' + ID
                        + '&IDPage=' + IDPage
                        + '&IDZone=' + IDZone
                        + '&Date=' + EdDate
                        + '&Title=' + Title
                        + '&UpdateDiv=E_' + ID + '_' + IDPage + '_' + IDZone + '_' + EdDate,
                'success': function (html) {
                    $('body').append(html);
                }
            });
            /*$.ajax({
             'type': 'POST',
             'url': SERVER_DIR + URL_QueryLoadPlainText,
             'cache': false,
             'data': 'ID=' + ID,
             'success': function (Content) {
             var HTML = Content;
             var form = '<div class="skts_content"><fieldset>' +
             '<input type="hidden" id="ID" value="' + ID + '" name="ID"/>' +
             '<input type="hidden" id="IDPage" value="' + IDPage + '" name="IDPage"/>' +
             '<input type="hidden" id="IDZone" value="' + IDZone + '" name="IDZone"/>' +
             '<input type="hidden" id="Date" value="' + EdDate + '" name="Date"/>' +
             '<label><b>Titulo:&nbsp;</b></label><input type="text" id="Title" value="' + Title + '" name="Title"/>' +
             '<input type="hidden" id="UpdateDiv" value="E_' + ID + '_' + IDPage + '_" name="UpdateDiv" readonly />' +
             '</fieldset></div>' +
             '<textarea id="editor" name="editor">' + HTML + '</textarea>';
             
             $('.containerPopUp form').html(form);
             $("#PopUpEditor").dialog("open");
             var win = $('.ui-resizable');
             $("#editor").css({'width': (win.width()), 'height': (win.height() - 200)});
             $('#PopUpEditor').parent().first().find('span').html('<span>Editando contenido: "' + Title + '"</span>');
             $('#PopUpEditor').parent().css({'display': 'block'});
             AppSKT.skt_WrapDialog();
             }
             });*/
        });
        $(".CmsDevEditCMSProduct").click(function () {
            $('.EditorActive h3.ui-state-active').removeClass('ui-state-active');
            $(this).parent().parent().parent().addClass('ui-state-active');
            var PID = $(this).attr('id');
            $.ajax({
                'type': 'POST',
                'url': SERVER_DIR + URL_Content_Edit_Product,
                'cache': false,
                'data': 'Language=' + Language + '&MetaDataTitle=&PID=' + PID,
                'success': function (html) {
                    $('body').append(html);
                }
            });
        });
        $(".CmsDevEditPhoto").click(function () {
            $('.EditorActive h3.ui-state-active').removeClass('ui-state-active');
            $(this).parent().parent().parent().addClass('ui-state-active');
            var ID = $(this).attr('id');
            $.ajax({
                'type': 'POST',
                'url': SERVER_DIR + URL_Content_Edit_Photo,
                'cache': false,
                'data': 'Language=' + Language + '&ID=' + ID,
                'success': function (html) {
                    $('body').append(html);
                }
            });
        });
        $(".CmsDevEditNote").click(function () {
            $('.EditorActive h3.ui-state-active').removeClass('ui-state-active');
            $(this).parent().parent().parent().addClass('ui-state-active');
            var ID = $(this).attr('id');
            $.ajax({
                'type': 'POST',
                'url': SERVER_DIR + URL_Content_Edit_Note,
                'cache': false,
                'data': 'Language=' + Language + '&ID=' + ID,
                'success': function (html) {
                    $('body').append(html);
                }
            });
        });
        $(".CmsDevEditCC").click(function () {
            var URL_ACT = 'SKTGoTo/' + URL_Content_Edit_Custom;
            $.ajax({
                'type': 'POST',
                'url': SERVER_DIR + URL_ACT,
                'cache': false,
                'data': $('form#colectorskt').serialize() + $(this).parent().next('form').serialize() + '&IDPage=' + SKT_SECTION_ID,
                'success': function (html) {
                    $('body').append(html);
                }
            });
        });
        $(".CmsDevEditCCCustomized").click(function () {
            var Action = $(this).parent().next('form').find('#Action').val();
            var CCFromTemplate = $(this).parent().next('form').find('#CCFromTemplate').val();
            var URL_ACT = 'SKT_Controls/' + Action + '/Admin.php';
            if (CCFromTemplate !== '' && CCFromTemplate !== null && CCFromTemplate !== 'undefined') {
                URL_ACT = CCFromTemplate + Action + '/Admin.php';
            }
            $.ajax({
                'type': 'POST',
                'url': SERVER_DIR + URL_ACT,
                'cache': false,
                'data': $('form#colectorskt').serialize() + $(this).parent().next('form').serialize() + '&IDPage=' + SKT_SECTION_ID,
                'success': function (html) {
                    $('body').append(html);
                }
            });
        });
        $(".CmsDevEditFiles").click(function () {
            var URL_ACT = 'SKTGoTo/' + AdmAct[5];
            $.ajax({
                'type': 'POST',
                'url': SERVER_DIR + URL_ACT,
                'cache': false,
                'data': $('form#colectorskt').serialize() + $(this).parent().next('form').serialize() + '&IDPage=' + SKT_SECTION_ID,
                'success': function (html) {
                    $('body').append(html);
                }
            });
        });
        $("#ViewEditElementsAsList").click(function () {
            var URL_ACT = URL_ViewEditElementsAsList;
            $.ajax({
                'type': 'POST',
                'url': SERVER_DIR + URL_ACT,
                'cache': false,
                'data': $('form#colectorskt').serialize() + $(this).parent().next('form').serialize() + '&IDPage=' + SKT_SECTION_ID,
                'success': function (html) {
                    $('body').append(html);
                }
            });
        });
        $(".CmsDevEditCCF").click(function () {
            $('.EditorActive h3.ui-state-active').removeClass('ui-state-active');
            $(this).parent().parent().parent().addClass('ui-state-active');
            $.ajax({
                'type': 'POST',
                'url': SERVER_DIR + URL_Content_Edit_Custom,
                'cache': false,
                'data': $(this).parent().next('form').serialize(),
                'success': function (html) {
                    $('body').append(html);
                }
            });
        });
        $('.ui-icon-grip-diagonal-se').mouseup(function () {
            var win = $('.ui-resizable');
            $("#editor").css({'width': (win.width()), 'height': (win.height() - 160)});
        });
        $('.sktToolTip').sktToolTip();
        $('#sktsbToggleLeft').click(function () {
            $.sidr('toggle');
        });
        $('.sktChangeStyle #Normal').click(function () {
            AppSKT.ChangeStyle(0);
        });
        $('.sktChangeStyle #Minimal').click(function () {
            AppSKT.ChangeStyle(1);
        });
        $('.sktChangeStyle #Bottom').click(function () {
            AppSKT.ChangeStyle(2);
        });
        var MenuPosition = $.cookie('sktMenuPosition');
        switch (MenuPosition) {
            case '0':
                AppSKT.ChangeStyle(0);
                break;
            case '1':
                AppSKT.ChangeStyle(1);
                break;
            case '2':
                AppSKT.ChangeStyle(2);
                break;
        }

    });
    return {
        setEqualHeight: function (els) {
            var tallestEl = 0;
            els = $(els);
            els.each(function () {
                var currentHeight = $(this).height();
                if (currentHeight > tallestEl) {
                    tallestColumn = currentHeight;
                }
            });
            els.height(tallestEl);
        },
        ChangeStyle: function (style) {
            var Class0 = 'skt-menu-mainNormal', Class1 = 'skt-menu-mainMinimu', Class2 = 'skt-menu-mainBottom';
            switch (style) {
                case 0:
                    $('#skt-menu-admin').removeClass(Class1).removeClass(Class2).addClass(Class0);
                    $('body').addClass('skt-padding-body');
                    $.cookie('sktMenuPosition', '0', {expires: 7, path: '/'});
                    break;
                case 1:
                    $('#skt-menu-admin').removeClass(Class0).removeClass(Class2).addClass(Class1);
                    $('body').addClass('skt-padding-body');
                    $.cookie('sktMenuPosition', '1', {expires: 7, path: '/'});
                    break;
                case 2:
                    $('#skt-menu-admin').removeClass(Class0).removeClass(Class1).addClass(Class2);
                    $('body').removeClass('skt-padding-body');
                    $.cookie('sktMenuPosition', '2', {expires: 7, path: '/'});
                    break;
            }
            //alert($.cookie('sktMenuPosition'));
        },
        scrollTo: function (el, offeset) {
            pos = el ? el.offset().top : 0;
            $('html,body').animate({
                scrollTop: pos + (offeset ? offeset : 0)
            }, 'slow');
        },
        getURLParameter: function (paramName) {
            var searchString = window.location.search.substring(1),
                    i, val, params = searchString.split("&");

            for (i = 0; i < params.length; i++) {
                val = params[i].split("=");
                if (val[0] === paramName) {
                    return unescape(val[1]);
                }
            }
            return null;
        },
        skt_DatePicker: function () {
            $('#ui-datepicker-div').wrap('<div class="skt" />');
        },
        getSelectedValue: function (id) {
            return id.find("span.value").html();
        },
        Xdebug: function () {
            var Xdebugerrors = '';
            $('.xdebug-error').each(function (index) {
                Xdebugerrors += $(this).html();
            });
            document.write('<span id="ErrorReport">' + Xdebugerrors + '</span>');
        },
        View_DesignCMS: function () {
            if ($.cookie("View_DesignCMS") === 'null') {
                $.cookie("View_DesignCMS", "0");
            }else{
                setTimeout('View_DesignCMSHide();', 500);
            }
        },
        SKTaccordionLeft: function () {
            $("#SKTaccordionLeft").accordion({
                heightStyle: "content",
                collapsible: true
            });
        },
        skt_Maximize: function () {
            $('.skt .ui-dialog .ui-dialog-titlebar').append('<a href="javascript:void(0);" id="dialog-maximize"><span class="skt-icon-expand">min</span></a>');
            $('.skt .ui-dialog .ui-dialog-titlebar').find('.ui-dialog-titlebar-close').addClass('skt-icon-close');
            $('.skt .ui-dialog #dialog-maximize').click(function () {
                $(this).parent().next('.ui-dialog-content').toggleClass('hidden');
                $(this).parent().parent('.ui-dialog').toggleClass('skt-dialog-hidden');
                $('.ui-widget-overlay').toggleClass('skt-dialog-hidden');
            });
        },
        skt_WrapDialog: function () {
            $('body').addClass('overflowHidden');
            $('.ui-dialog, .ui-widget-overlay').wrap('<div class="skt" />');
            setTimeout('AppSKT.skt_Maximize();', 1000);
        },
        skt_WrapDialogRed: function () {
            $('body').addClass('overflowHidden');
            $('.ui-dialog, .ui-widget-overlay').wrap('<div class="skt sktAlert" />');
            setTimeout('AppSKT.skt_Maximize();', 1000);
        },
        skt_RemoveDialog: function () {
            $('body').removeClass('overflowHidden');
            $('.ui-widget-overlay').remove();
            $('body #dialog-form-Administrator').remove();
            $('body .ui-dialog').remove();
            $('body > .skt:not(".SKTNotRemove")').remove();
        },
        skt_HideDialogPopUpEditor: function () {
            $('body').removeClass('overflowHidden');
            $('.ui-widget-overlay').remove();
            $('body #PopUpEditor').parent().hide();
        },
        skt_ShowDialogPopUpEditor: function () {
            $('body').addClass('overflowHidden');
            $('body #PopUpEditor').parent().show();
        },
        View_DesignCMSHide: function () {
            $("h3.EditorHeaderTitle, .ZoneContainer, .sktRecycleBinHidden, .slide_productos .EditorContainer, .newProductIconBig, .skt-icon-move, .sktViewLinkItem").hide().attr('style', 'display:none !important');
            $(".EditorContainer .Recycled").next('div').hide();
            $(".ui-sortable .EditorContainer .Recycled").parent().parent().hide();
            $("li.Recycled").hide();
            $(".SKTRecycled").hide();
            $('.sktEditorContent > *').addClass('sktrewrp').unwrap();
        },
        View_DesignCMSShow: function () {
            $("h3.EditorHeaderTitle, .ZoneContainer, .sktRecycleBinHidden, .slide_productos .EditorContainer, .newProductIconBig, .skt-icon-move, .sktViewLinkItem").show().attr('style', '');
            $(".EditorContainer .Recycled").next('div').show();
            $(".ui-sortable .EditorContainer .Recycled").parent().parent().show();
            $("li.Recycled").show();
            $(".SKTRecycled").show();
            $('.sktrewrp').wrap('<div class="sktEditorContent"/>').removeClass('sktrewrp');
        },
        RefreshFileSystems: function () {
            var URL_ACT = 'SKTGoTo/' + AdmAct[5];
            $.ajax({
                'type': 'POST',
                'url': SERVER_DIR + URL_ACT,
                'cache': false,
                'data': $('form#colectorskt').serialize() + '&IDPage=' + SKT_SECTION_ID,
                'success': function (html) {
                    $('body').append(html);
                }
            });
        },
        ReloadPage: function (url) {
            $("#dialog:ui-dialog").dialog("destroy");
            $("#dialog-reload").dialog({
                resizable: false,
                modal: true});
            AppSKT.skt_WrapDialog();
            var countdown = 3;
            $("#dialog-reload #countdownBig").html('');
            setInterval(function () {
                countdown = countdown - 1;
                if (countdown >= 0) {
                    $("#dialog-reload #countdownBig").html(countdown);
                }
            }, 1000);
            if (url !== '' && url !== 'undefined' && url !== 'null' && url !== null) {
                setTimeout("location.href='" + url + "';", countdown * 1000);
            } else {
                setTimeout("location.reload()", countdown * 1000);
            }
        },
        ToggleDefined: function () {
            $("#dialog:ui-dialog").dialog("destroy");
            $("#dialog-ToggleDefined").dialog({
                height: dHeight,
                width: dWidth,
                minHeight: dHeight,
                minWidth: dWidth,
                modal: true,
                open: function (event, ui) {
                    $(this).dialog("option", "height", dHeight);
                    $(this).dialog("option", "width", dWidth);
                },
                close: function () {
                    AppSKT.skt_RemoveDialog();
                }
            });
            AppSKT.skt_WrapDialog();
        },
        TogglePageConfig: function () {
            $("#dialog:ui-dialog").dialog("destroy");
            $("#dialog-TogglePageConfig").dialog({
                height: dHeight,
                width: dWidth,
                minHeight: dHeight,
                minWidth: dWidth,
                modal: true,
                open: function (event, ui) {
                    $(this).dialog("option", "height", dHeight);
                    $(this).dialog("option", "width", dWidth);
                },
                close: function () {
                    AppSKT.skt_RemoveDialog();
                }
            });
            AppSKT.skt_WrapDialog();
        },
        checkRegexp: function (o, regexp, n) {
            if (regexp === 'email') {
                regexp = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;
            }
            if (!(regexp.test(o.val()))) {
                o.addClass('ui-state-error').focus();
                AppSKT.updateTips(n);
                return false;
            } else {
                return true;
            }
            return true;
        },
        checkLength: function (o, n, min, max) {
            if (o.val().length > max || o.val().length < min) {
                o.addClass('ui-state-error').focus();
                AppSKT.updateTips("El largo del campo \"<b>" + n + "</b>\" tiene que ser entre " + min + " y " + max + " caracteres.");
                return false;
            } else {
                return true;
            }
        },
        updateTips: function (t) {
            var tips = $(".validateTips");
            tips.html(t).addClass('ui-state-highlight').focus();
            setTimeout(function () {
                tips.removeClass('ui-state-highlight', 1500);
            }, 500);
        },
        sktViewLinkItem: function (URLName, ID) {
            $.ajax({
                'type': 'POST',
                'url': SERVER_DIR + URL_Link_Edit,
                'cache': false,
                'data': $('form#colectorskt').serialize() + '&URLName=' + URLName + '&ID=' + ID,
                'success': function (html) {
                    $('body').append(html);
                }
            });
        }, PopUp_SystemIframeFolder: function () {
            setTimeout("$('#LOADING').hide();", 1500);
            $(".php-file-tree").find("UL").hide();
            $(".pft-directory .iconmore").click(function () {
                $(this).parent().find("UL:first").slideToggle("medium");
                if ($(this).parent().attr('className') === "pft-directory")
                    return false;
            });
        }, ViewFolderList: function (folder) {
            $('#LOADING').show();
            setTimeout("$('#LOADING').hide();", 1500);
            var rand = Math.floor((Math.random() * 10000) + 1);
            $('#IframeFiles').attr('src', 'SKTGoTo/' + admd2('/AdminFilesystem/PopUp_SystemIframe') + '?Folder=' + folder + '/&rand=' + rand + '&filter');
        },
        CreateContentEditor: function (options) {
            var default_args = {
                'Element': '.skt_HTML_Editor',
                'width': '100%',
                'height': '350px',
                'colors': '' + SKT_EDITOR_COLORS + '',
                'fonts': '' + SKT_EDITOR_FONTS + '',
                'bodyStyle': '' + SKT_EDITOR_BODY + '',
                'docCSSFile': '' + URL_docCSSFile + '',
                'docType': '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
                'controls': 'bold italic underline strikethrough subscript superscript | font size style | color highlight removeformat | bullets numbering | outdent indent | alignleft center alignright justify | undo redo | Layout2 | FileSystem | rule table | image link | unlink cut copy paste pastetext | print source'
            };
            for (var index in default_args) {
                if (typeof options[index] === "undefined")
                    options[index] = default_args[index];
            }
            var Element = $(options['Element']);
            Element.cleditor({
                width: options['width'],
                height: options['height'],
                controls: options['controls'],
                colors:
                        "FFF FCC FC9 FF9 FFC 9F9 9FF CFF CCF FCF " +
                        "CCC F66 F96 FF6 FF3 6F9 3FF 6FF 99F F9F " +
                        "BBB F00 F90 FC6 FF0 3F3 6CC 3CF 66C C6C " +
                        "999 C00 F60 FC3 FC0 3C0 0CC 36F 63F C3C " +
                        "666 900 C60 C93 990 090 399 33F 60C 939 " +
                        "333 600 930 963 660 060 366 009 339 636 " +
                        "000 300 630 633 330 030 033 006 309 303 " +
                        options['colors'],
                fonts:
                        "Arial,Georgia,Tahoma,Trebuchet MS,Verdana" + options['fonts'],
                sizes:
                        "1,2,3,4,5,6,7",
                styles:
                        [["Paragraph", "<p>"], ["Header 1", "<h1>"], ["Header 2", "<h2>"], ["Header 3", "<h3>"], ["Header 4", "<h4>"], ["Header 5", "<h5>"],
                            ["Header 6", "<h6>"]],
                useCSS: false,
                docType:
                        options['docType'],
                docCSSFile:
                        options['docCSSFile'],
                bodyStyle:
                        options['bodyStyle'] + 'max-width:' + options['width'] + '!important;' + 'min-width:' + options['width'] + '!important;'
            })[0].focus();
        },
        CheckURLName: function (field1, field2) {
            $.post(URL_CheckURLName, {Title: field1, rand: Math.random()}, function (data) {
                $('#' + field2).val($.trim(data));
            });
        },
        CheckUserName: function (UserName,infoid) {
            $.post(URL_CheckUserName, {UserName: UserName, rand: Math.random()}, function (data) {
                if(data==0){
                    $('#' + infoid).html('El usuario ya existe, intente una variante.');
                }
                $('#' + UserName).val($.trim(data));
            });
        },
        OpenPanel: function () {
            $('#TogglePageConfig').toggle();
            $('body').toggleClass('overflowHidden');
        },
        translations: function (e) {
            return translations[e];
        },
        sktToolTip: function (options) {
            var defaults = {
                xOffset: 10,
                yOffset: 25,
                tooltipId: "sktToolTip",
                clickRemove: false,
                content: "",
                useElement: ""
            };
            var options = $.extend(defaults, options);
            var content;
            this.each(function () {
                var title = $(this).attr("title");
                $(this).hover(function (e) {
                    content = (options.content !== "") ? options.content : title;
                    content = (options.useElement !== "") ? $("#" + options.useElement).html() : content;
                    $(this).attr("title", "");
                    if (content !== "" && content !== undefined) {
                        $("body").append("<div id='" + options.tooltipId + "'>" + content + "</div>");
                        $("#" + options.tooltipId)
                                .css("position", "absolute")
                                .css("top", (e.pageY - options.yOffset) + "px")
                                .css("left", (e.pageX + options.xOffset) + "px")
                                .css("display", "none")
                                .fadeIn("fast");
                    }
                },
                        function () {
                            $("#" + options.tooltipId).remove();
                            $(this).attr("title", title);
                        });
                $(this).mousemove(function (e) {
                    $("#" + options.tooltipId)
                            .css("top", (e.pageY - options.yOffset) + "px")
                            .css("left", (e.pageX + options.xOffset) + "px");
                });
                if (options.clickRemove) {
                    $(this).mousedown(function (e) {
                        $("#" + options.tooltipId).remove();
                        $(this).attr("title", title);
                    });
                }
            });
        }
    };
}();
