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
$SKTDB = \CmsDev\sql\db_Skt::connect();
if (\CmsDev\Security\loginIntent::action('validate', 'HTML','Add') === true) {
    echo str_replace('[title]', \SKT_ADMIN_CreateContentTitleHTML . ' (HTML).', \SKT_ADMIN_AdminWraperOpen);
    ?>
    <div class="container_16">
        <div class="CreateContentHtml">
            <form action="" method="post" id="FormCreateContent">
                <input name="Date" type="hidden" value="<?php echo date('Y-m-d') ?>" />
                <input name="Type" type="hidden" value="html" />
                <input name="Custom" readonly="readonly" type="hidden" value="" />
                <input name="IDPage" readonly="readonly" type="hidden" value="<?php echo $_POST['IDPage'] ?>"/>
                <div class="grid_11"><textarea id="CreateContentEditor" name="CreateContentEditor"><?php echo \SKT_EDITOR_DEFAULT_CONTENT_ESP; ?></textarea></div>
                <div class="grid_4">
                    <?php
                    echo '<label><span>' . \SKT_ADMIN_TXT_Title . '</span><input name="Title" type="text" value=""  class="text ui-corner-all" /></label>';
                    echo '<label><span>' . \SKT_ADMIN_TXT_Section_Description . '</span><textarea id="Description" name="Description" class="text ui-corner-all" style="height:45px;" ></textarea></label>';
                    echo '<label><span>' . \SKT_ADMIN_TXT_View_AllPagesTitle . ':</span>';
                    echo \CmsDev\CRUD\Xtras\List_ThisOrAll_Page::ThisOrAll(0);
                    echo '</label>';
                    echo '<label>
		  			<span>' . \SKT_ADMIN_TXT_Zone . ':</span><div id="ZoneNewContent"></div>';
                    echo '</label>';
                    echo '<label><span>' . \SKT_ADMIN_TXT_ZoneOrder . ':</span>';
                    echo \CmsDev\CRUD\Xtras\List_Position_Zone::set(0, \SKT_SECTION_ID, 0);
                    echo '</label>';
                    echo '<label><span>' . \SKT_ADMIN_TXT_Section_CSS . '</span><input name="css_class" type="text" value="" class="text ui-corner-all" /></label>';
                    echo '<label><span>' . \SKT_ADMIN_RecycleTitle . '</span></label>';
                    ?>
                    <table align="left">
                        <tr>
                            <td><input type="radio" name="RecycleBin" checked="checked" value="0" id="RecycleBin_0" /></td>
                            <td><label class="checkbox"><span><?php echo \SKT_ADMIN_TXT_ShowContentVisible ?></span></label></td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="RecycleBin" value="1" id="RecycleBin_1" /></td>
                            <td><label class="checkbox"><span><?php echo \SKT_ADMIN_TXT_ShowContentHidden ?></span></label></td>
                        </tr>
                    </table>
                </div>
                <div class="clear"></div><p>&nbsp;</p>
            </form> 
        </div>
        <div class="clear"></div>
        <?php echo \SKT_ADMIN_AdminWraperClose ?> 

        <script type="text/javascript">

            $(document).ready(function () {
                $("#ZoneNewContent").append($('#ListZoneColector').html());
                $("#ZoneNewContent select:eq(1)").remove();
                setTimeout('ProductDescriptionHTML()', 1000);
            });
            function ProductDescriptionHTML() {
                $("#CreateContentEditor").cleditor({
                    width: "100%", // width not including margins, borders or padding
                    height: "350px", // height not including margins, borders or padding
                    controls: // controls to add to the toolbar
                            "bold italic underline strikethrough subscript superscript | font size " +
                            "style | color highlight removeformat | bullets numbering | outdent " +
                            "indent | alignleft center alignright justify | undo redo | " +
                            "Layout2 | FileSystem | rule table | image link | unlink cut copy paste pastetext | print source",
                    colors: // colors in the color popup
                            "FFF FCC FC9 FF9 FFC 9F9 9FF CFF CCF FCF " +
                            "CCC F66 F96 FF6 FF3 6F9 3FF 6FF 99F F9F " +
                            "BBB F00 F90 FC6 FF0 3F3 6CC 3CF 66C C6C " +
                            "999 C00 F60 FC3 FC0 3C0 0CC 36F 63F C3C " +
                            "666 900 C60 C93 990 090 399 33F 60C 939 " +
                            "333 600 930 963 660 060 366 009 339 636 " +
                            "000 300 630 633 330 030 033 006 309 303 " +
                            "da4909 e55f0d 262626 373737 c9c9c9 fa0561",
                    fonts: // font names in the font popup
                            "Arial,Georgia,Tahoma,Trebuchet MS,Verdana",
                    sizes: // sizes in the font size popup
                            "1,2,3,4,5,6,7",
                    styles: // styles in the style popup
                            [["Paragraph", "<p>"], ["Header 1", "<h1>"], ["Header 2", "<h2>"],
                                ["Header 3", "<h3>"], ["Header 4", "<h4>"], ["Header 5", "<h5>"],
                                ["Header 6", "<h6>"]],
                    useCSS: false, // use CSS to style HTML when possible (not supported in ie)
                    docType: // Document type contained within the editor
                            '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
                    docCSSFile: // CSS file used to style the document contained within the editor
                            '' + SKTURL_TemplateSite + "/css/style.css",
                    bodyStyle: // style to assign to document body contained within the editor
                            '' + SKT_EDITOR_BODY + ''
                })[0].focus();
            }
            /* ----------------------------- CREATE DIALOG --------------------------------------------------*/
            $("#dialog").dialog("destroy");
            var tips = $(".validateTips");
            var allFields = '';
            /*var ProductAutoID = $("#ProductAutoID"),
             SectionAutoID = $("#SectionAutoID"),
             allFields = $([]).add(ProductAutoID).add(SectionAutoID);
             */
            $("#dialog-form-Administrator").dialog({
                autoOpen: true,
                width: 990,
                maxWidth: 990,
                position: ['3%', 55],
                modal: true,
                buttons: {
                    'Agregar el Contenido HTML': function () {
                        var bValid = true;
                        //allFields.removeClass('ui-state-error');
                        /* ----------------------------- VALIDATE FIELDS --------------------------------------------------*/
                        /*
                         bValid = bValid && AppSKT.checkRegexp(ProductAutoID,/^([0-9a-zA-Z])+$/,"Por un error desconocido, no se puede agregar el Producto, refresque la p&aacute;gina e intente nuevamente");
                         bValid = bValid && AppSKT.checkRegexp(SectionAutoID,/^([0-9a-zA-Z])+$/,"Por un error desconocido, no se puede agregar el Producto, refresque la p&aacute;gina e intente nuevamente");
                         bValid = bValid && AppSKT.checkLength(ProductName,"Nombre del producto",6,100);
                         */
                        /* ----------------------------- END VALIDATE FIELDS --------------------------------------------------*/
                        if (bValid) {
                            /*  -----------------------------  IF OK  --------------------------*/
                            var elHTML = $('iframe', '#FormCreateContent')[0].contentWindow.document.body.innerHTML;
                            $('#CreateContentEditor').html(elHTML);
                            var validating = '<label><div class="ui-state-highlight ui-corner-all"><p>' + SKT_ADMIN_Message_Validating + '<span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-refresh"></span></p></div></label>';
                            tips.html(validating);
                            jQuery.ajax({
                                'type': 'POST',
                                'url': 'SKTGoTo/' + admd2('/Query/CreateContent'),
                                'cache': false,
                                'data': $("#FormCreateContent").serialize(),
                                'success': function (htmlReturn) {
                                    if ($.trim(htmlReturn) === "okay") {
                                        var ROK = '<label><div class="ui-state-highlight ui-corner-all"><p>' + SKT_ADMIN_Message_Update_OK + '<span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span></p></div></label>';
                                        tips.html(ROK);
                                        AppSKT.ReloadPage(document.URL);
                                    } else {
                                        var RKO = '<label><div class="ui-state-error ui-corner-all"><p>' + SKT_ADMIN_Message_Update_Error + '<span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span></p></div></label>';
                                        tips.html(RKO);
                                    }
                                }
                            });
                            /*  -----------------------------  OK  --------------------------*/
                        }
                    },
                    Cancelar: function () {
                        AppSKT.skt_RemoveDialog();
                    }
                },
                close: function () {
                    AppSKT.skt_RemoveDialog();
                }
            });
            AppSKT.skt_WrapDialog();
            /* ----------------------------- END CREATE DIALOG --------------------------------------------------*/
        </script>
    <?php } ?>