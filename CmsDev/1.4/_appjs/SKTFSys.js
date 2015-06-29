
var SKTFSys = function () {
    var translations = [];
    translations['Ok'] = SKT_ADMIN_Btn_Acept;
    translations['Create'] = SKT_ADMIN_Btn_Create;
    translations['Cancel'] = SKT_ADMIN_Btn_RestartCancel;
    translations['Delete'] = SKT_ADMIN_Btn_Delete;
    translations['Save'] = SKT_ADMIN_Btn_Save;
    translations['Edit'] = SKT_ADMIN_Btn_Edit;
    return {
        init: function () {
            $(".FolderSystemUL").find("ul").addClass('subfolder').hide();
            $('.pft-directory .iconfolder').each(function () {
                var checkElement = $(this).next().next();
                if (checkElement.is('ul')) {
                    $(this).addClass('iconmore').append('<i class="skt-icon-plus"></i>');
                }
            });
            $('.iconfolder').click(function () {
                $(this).next().next('ul').toggle();
            });
            $('#CheckClick').click(function () {
                var TheLink = $('#dialog-form-Administrator input#hiperlink');
                var CheckLink = '[CheckLink]' + TheLink.val();
                TheLink.val(CheckLink);
            });
            $('.SaveTags').click(function () {
                var File = $('#dialog-form-Administrator input#CustomProperty').val();
                if (File !== '') {
                    var Title = $('#dialog-form-Administrator input#Title').val();
                    var tags = $('#dialog-form-Administrator textarea#Description').val();
                    var hiperlink = $('#dialog-form-Administrator input#hiperlink').val();
                    var FileOrder = $('#dialog-form-Administrator input#FileOrder').val();
                    jQuery.ajax({
                        'type': 'POST',
                        'url': SKTURL + 'SKTGoTo/' + admd2('AdminFilesystem/PopUp_Systems_SaveTags'),
                        'cache': false,
                        'data': 'File=' + File + '&Title=' + Title + '&tags=' + tags + '&hiperlink=' + hiperlink + '&FileOrder=' + FileOrder,
                        'success': function (data) {

                        }
                    });
                }
            });
        },
        RezTable: function () {
            $("#resizableColumns").resizableColumns({
                store: store
            });
        },
        CustomPropertyFile: function (File, name, w, h) {
            File.replace('////g', '');
            var SRC = name;
            var TitleSplit = File.split('/');
            var count = TitleSplit.length - 1;
            var TitleFile = TitleSplit[count];
            File.replace('////g', '');
            var SRC = name;
            jQuery.ajax({
                'type': 'POST',
                'url': SKTGoTo + admd2('/AdminFilesystem/TagForm'),
                'cache': false,
                'data': 'File=' + File,
                'success': function (data) {
                    if ($('#TagForm').length) {
                        $('#TagForm').html(data);
                        $('#dialog-form-Administrator input#FileNewFileX').val(w);
                        $('#dialog-form-Administrator input#FileNewFileY').val(h);
                    }
                    else {
                        $('#TagForm', window.parent.document).html(data);
                        $('#dialog-form-Administrator input#FileNewFileX', window.parent.document).val(w);
                        $('#dialog-form-Administrator input#FileNewFileY', window.parent.document).val(h);
                    }
                }
            });
        },
        setEqualHeight: function (els) {
            var tallestEl = 0;
            els = jQuery(els);
            els.each(function () {
                var currentHeight = $(this).height();
                if (currentHeight > tallestEl) {
                    tallestColumn = currentHeight;
                }
            });
            els.height(tallestEl);
        },
        scrollTo: function (el, offeset) {
            pos = el ? el.offset().top : 0;
            jQuery('html,body').animate({
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
            return $("#" + id).find("dt a span.value").html();
        },
        SKTaccordionLeft: function () {
            $("#SKTaccordionLeft").accordion({
                heightStyle: "content",
                collapsible: true
            });
        },
        skt_Maximize: function () {
            $('.skt .ui-dialog .ui-dialog-titlebar').append('<a href="javascript:void(0);" id="dialog-maximize"><span class="skt-icon-expand">min</span></a>');
            $('.skt .ui-dialog #dialog-maximize').click(function () {
                $(this).parent().next('.ui-dialog-content').toggleClass('hidden');
                $(this).parent().parent('.ui-dialog').toggleClass('skt-dialog-hidden');
                $('.ui-widget-overlay').toggleClass('skt-dialog-hidden');
            });
        },
        skt_WrapDialog: function () {
            $('body').addClass('overflowHidden');
            $('.ui-dialog, .ui-widget-overlay').wrap('<div class="skt" />');
            setTimeout('SKTFSys.skt_Maximize();', 1000);
        },
        skt_WrapDialogRed: function () {
            $('body').addClass('overflowHidden');
            $('.ui-dialog, .ui-widget-overlay').wrap('<div class="skt sktAlert" />');
            setTimeout('SKTFSys.skt_Maximize();', 1000);
        },
        skt_RemoveDialog: function () {
            $('body').removeClass('overflowHidden');
            $('.ui-widget-overlay').remove();
            $('body #dialog-form-Administrator').remove();
            $('body .ui-dialog').remove();
            $('body > .skt:not(".SKTNotRemove")').remove();
        },
        RefreshFileSystems: function () {
            var URL_ACT = SKTURL + 'SKTFSys/QWRtaW5GaWxlcy9fX0ZpbGVTeXN0ZW1zUG9wVVA';
            jQuery.ajax({
                'type': 'POST',
                'url': URL_ACT,
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
                height: 200,
                width: 200,
                modal: false});
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
        checkRegexp: function (o, regexp, n) {
            if (regexp === 'email') {
                regexp = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;
            }
            if (!(regexp.test(o.val()))) {
                o.addClass('ui-state-error').focus();
                SKTFSys.updateTips(n);
                return false;
            } else {
                return true;
            }
            return true;
        },
        checkLength: function (o, n, min, max) {
            if (o.val().length > max || o.val().length < min) {
                o.addClass('ui-state-error').focus();
                SKTFSys.updateTips("El largo del campo \"<b>" + n + "</b>\" tiene que ser entre " + min + " y " + max + " caracteres.");
                return false;
            } else {
                return true;
            }
        },
        PopUp_SystemIframeFolder: function () {
            setTimeout("$('#LOADING').hide();", 1500);
            $(".php-file-tree").find("UL").hide();
            $(".pft-directory .iconmore").click(function () {
                $(this).parent().find("UL:first").slideToggle("medium");
                if ($(this).parent().attr('className') === "pft-directory")
                    return false;
            });
        },
        ViewFolderList: function (folder) {

            $('#LOADING').show();
            setTimeout("$('#LOADING').hide();", 1500);
            var rand = Math.floor((Math.random() * 10000) + 1);
            $('#IframeFiles').attr('src', SKTURL + 'SKTFiles/' + folder + '/');
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
        OpenPanel: function () {
            $('#TogglePageConfig').toggle();
            $('body').toggleClass('overflowHidden');
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