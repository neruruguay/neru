<?php
if (!isset($GLOBALS['SKT'])) {
    if (session_id() == '') {
        session_start();
    }
    $SKTAJAX = 'AJAX';
    require ('../../../Config.php');
    require ('../../../db.php');
    require ('../../Core.php');
}
echo \SKT_ADMIN_AdminWraperOpen;
$SKTDB = \CmsDev\sql\db_Skt::connect();
?>
<div class="container_16">
    <div class="CreateContentHtml">
        <form action="" method="post" id="Form_Templates">
            <input value="Add" name="Add" type="hidden"/>
            <input value="Image" name="Image" id="Image" type="hidden"/>
            <div class="grid_11">
                <textarea id="TemplatesEditor" name="TemplatesEditor"><?php echo $SKT['EDITOR']['DEFAULT_CONTENT'][\THIS_LANG]; ?></textarea></div>
            <div class="grid_5">
                <?php
                echo '<label><span>' . \SKT_ADMIN_TXT_Title . '</span><input name="Title"  id="Title" type="text" value=""  class="text ui-corner-all"  onBlur="javascript:imageload();"/></label>';
                echo '<label><span>' . \SKT_ADMIN_TXT_Section_Description . '</span><textarea id="Description" name="Description" class="text ui-corner-all" style="height:80px;" ></textarea></label>';
                ?>
                <blockquote><i class="skt-iconpicture" style="font-size: 46px;float: left; margin: 0 10px 0 -5px;"></i><b style="line-height: 15px;">Cargar imagen 'JPG' menor a 1 MB de peso.</b></blockquote><hr>
                <div id="imageload"><blockquote>Escriba un "<b>Titulo</b>" para poder ingresar luego una imagen relacionada al contenido.</blockquote></div>
            </div>
            <div class="clear"></div>
        </form> 
    </div>
    <div class="clear"></div>
</div>  


<script type="text/javascript">
    var imageloader = 0;

    function imageload() {
        var name = $('#Form_Templates #Title').val();
        var rand = Math.floor((Math.random() * 10000000) + 1);
        if (name !== '' && imageloader === 0) {
            imageloader = 1;
            //var URLUPLOAD = '/CRUD/ViewEditElementsAsList/Lists/Templates/Upload/UpForm';
            jQuery.ajax({
                'url': URL_VERSION + '/CRUD/ViewEditElementsAsList/Lists/Templates/Upload/UpForm.php',
                'success': function(UpI) {
                    $('#Form_Templates #imageload').html(UpI);
                }
            });
        }
    }

    $(document).ready(function() {
        setTimeout('TemplatesHTML()', 1000);
    });

    function TemplatesHTML() {
        AppSKT.CreateContentEditor({
            'Element': '#TemplatesEditor',
            'width': '100%',
            'height': '450px',
            'colors': '' + SKT_EDITOR_COLORS + '',
            'fonts': '' + SKT_EDITOR_FONTS + '',
            'bodyStyle': '' + SKT_EDITOR_BODY + '',
            'docCSSFile': '' + URL_docCSSFile + '',
            'docType': '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
            'controls': 'bold italic underline strikethrough subscript superscript | font size style | color highlight removeformat | bullets numbering | outdent indent | alignleft center alignright justify | undo redo | Layout2 | FileSystem | rule table | image link | unlink cut copy paste pastetext | print source'
        });
        var translations = [];
        translations['Save'] = SKT_ADMIN_Btn_Save;
        translations['Cancel'] = SKT_ADMIN_Btn_RestartCancel;
        $('.ui-dialog-buttonset button').html(function(i, v) {
            v = v.replace("[Save]", translations['Save']).replace("[Cancel]", translations['Cancel']);
            return v;
        });
    }

    var tips = $(".validateTips");
    var allFields = '';
    var Title = $("#Form_Templates #Title"),
            Description = $("#Form_Templates #Description"),
            allFields = $([]).add(Title).add(Description),
            tTitle = $("#Form_Templates #Title").prev('span').text(),
            tDescription = $("#Form_Templates #Description").prev('span').text();

    $("#CmsDevDialogContent").dialog({
        autoOpen: true,
        width: 990,
        maxWidth: 990,
        position: ['3%', 55],
        modal: false,
        title: '<i class="skt-iconhtml5"></i><span><?php echo \SKT_ADMIN_Lists_AddListItem; ?></span>',
        buttons: {
            '[Save]': function() {
                var bValid = true;
                allFields.removeClass('ui-state-error');
                /* ----------------------------- VALIDATE FIELDS --------------------------------------------------*/
                //bValid = bValid && AppSKT.checkLength(Title, tTitle, 1, 100);
                //bValid = bValid && AppSKT.checkLength(Description, tDescription, 1, 300);
                /* ----------------------------- END VALIDATE FIELDS --------------------------------------------------*/
                if (bValid) {
                    var elHTML = $('iframe', '#Form_Templates')[0].contentWindow.document.body.innerHTML;
                    $('#TemplatesEditor').html(elHTML);
                    var validating = SKT_ADMIN_Message_Validating;
                    tips.html(validating);
                    var URLUPDATE = '/CRUD/ViewEditElementsAsList/Lists/Templates/_Create';
                    jQuery.ajax({
                        'type': 'POST',
                        'url': 'SKTGoTo/' + admd2(URLUPDATE),
                        'cache': false,
                        'data': $("#Form_Templates").serialize(),
                        'success': function(htmlReturn) {
                            if ($.trim(htmlReturn) === "okay") {
                                var ROK = SKT_ADMIN_Message_Update_OK;
                                tips.html(ROK);
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
                                AppSKT.skt_RemoveDialog("#CmsDevDialogContent");
                            } else {
                                var RKO = SKT_ADMIN_Message_Update_Error;
                                tips.html(RKO);
                            }
                        }
                    });
                }
            },
            '[Cancel]': function() {
                AppSKT.skt_RemoveDialog("#CmsDevDialogContent");
            }
        },
        close: function() {
            AppSKT.skt_RemoveDialog("#CmsDevDialogContent");
        }
    });
    AppSKT.skt_WrapDialog("#CmsDevDialogContent");
</script>

<?php echo \SKT_ADMIN_AdminWraperClose ?> 