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

$ID = \GetSQLValueString(\str_replace('ID', '', $_POST['ID']), "int");
$SKTDB = \CmsDev\sql\db_Skt::connect();
$query = $SKTDB->get_row("SELECT ID, Custom, Title, Description, Content FROM " . \DB_PREFIX . "content WHERE ID = '$ID' ");
?>
<div class="container_16">
    <div class="CreateContentHtml">
        <form action="" method="post" id="Form_ReusableComponent">
            <input value="ReusableComponent_Edit" name="ReusableComponent_Edit" type="hidden"/>
            <input value="<?php echo $query->ID; ?>" name="ID" type="hidden"/>
            <input value="<?php echo $query->Custom; ?>" name="Image" id="Image" type="hidden"/>
            <div class="grid_11">
                <textarea id="ReusableComponentEditor" name="ReusableComponentEditor"><?php echo \utf8_encode($query->Content); ?></textarea></div>
            <div class="grid_4">
                <?php
                echo '<label><span>' . \SKT_ADMIN_TXT_Title . '</span><input name="Title" id="Title" type="text" value="' . \utf8_encode($query->Title) . '"  class="text ui-corner-all" /></label>';
                echo '<label><span>' . \SKT_ADMIN_TXT_Section_Description . '</span><textarea id="Description" name="Description" class="text ui-corner-all" style="height:80px;" >' . \utf8_encode($query->Description) . '</textarea></label>';
                ?>
                <blockquote><i class="skt-icon-picture" style="font-size: 46px;float: left; margin: 0 10px 0 -5px;"></i><b style="line-height: 15px;">Cargar imagen 'JPG' menor a 1 MB de peso.</b></blockquote><hr>
                <div id="IMG"><img style="max-height:350px;" alt="" src="./_FileSystems/CodeSnippets_Preview/<?php echo $query->Custom; ?>"></div>
                <div id="imageload"><blockquote>Escriba un "<b>Titulo</b>" para poder ingresar luego una imagen relacionada al contenido.</blockquote></div>
            </div>
            <div class="clear"></div>
        </form> 
    </div>
    <div class="clear"></div>
</div>  



<script type="text/javascript">

    $(document).ready(function() {
        setTimeout('ReusableComponentHTML()', 1000);
        jQuery.ajax({
            'url': 'SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/ReusableComponent/Upload/EditForm'),
            'success': function(UpI) {
                $('#Form_ReusableComponent #imageload').html(UpI);
            }
        });
    });

    function ReusableComponentHTML() {
        AppSKT.CreateContentEditor({
            'Element': '#ReusableComponentEditor',
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
    var Title = $("#Form_ReusableComponent #Title"),
            Description = $("#Form_ReusableComponent #Description"),
            allFields = $([]).add(Title).add(Description),
            tTitle = $("#Form_ReusableComponent #Title").prev('span').text(),
            tDescription = $("#Form_ReusableComponent #Description").prev('span').text();

    $("#CmsDevDialogContent").dialog({
        autoOpen: true,
        width: 990,
        maxWidth: 990,
        position: ['3%', 55],
        modal: false,
        title: '<i class="skt-icon-html5"></i><span><?php echo \SKT_ADMIN_Lists_EditListItem; ?></span>',
        buttons: {
            '[Save]': function() {
                var bValid = true;
                allFields.removeClass('ui-state-error');
                /* ----------------------------- VALIDATE FIELDS --------------------------------------------------*/
                //bValid = bValid && AppSKT.checkLength(Title, tTitle, 1, 100);
                //bValid = bValid && AppSKT.checkLength(Description, tDescription, 1, 300);
                /* ----------------------------- END VALIDATE FIELDS --------------------------------------------------*/
                if (bValid) {
                    var elHTML = $('iframe', '#Form_ReusableComponent')[0].contentWindow.document.body.innerHTML;
                    $('#ReusableComponentEditor').html(elHTML);
                    var validating = SKT_ADMIN_Message_Validating;
                    tips.html(validating);
                    var URLUPDATE = '/CRUD/ViewEditElementsAsList/Lists/ReusableComponent/_Update';
                    jQuery.ajax({
                        'type': 'POST',
                        'url': 'SKTGoTo/' + admd2(URLUPDATE),
                        'cache': false,
                        'data': $("#Form_ReusableComponent").serialize(),
                        'success': function(htmlReturn) {
                            if ($.trim(htmlReturn) === "okay") {
                                var ROK = SKT_ADMIN_Message_Update_OK;
                                tips.html(ROK);
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