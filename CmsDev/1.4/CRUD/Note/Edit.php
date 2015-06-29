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
if (\CmsDev\Security\loginIntent::action('validate', 'Note', 'Edit') === true) {
    $ID = $_POST['ID'];
    $content = $SKTDB->get_row("SELECT * FROM " . DB_PREFIX . "content WHERE ID = '$ID'");
    echo str_replace('[title]', $CMSText_ConfigContent . ' (Nota).', \SKT_ADMIN_AdminWraperOpen);
    ?>
    <div class="CreateContentHtml" style="height:400px;">
        <form action="" method="post" id="FormCreateContent">
            <input name="Date" type="hidden" value="<?php echo date('Y-m-d') ?>" />
            <input name="Type" type="hidden" value="Note" />
            <input name="ID" type="hidden" value="<?php echo $ID ?>" />
            <input name="Custom" readonly type="hidden" value="<?php echo $content->Custom ?>" />
            <input name="IDPage" readonly type="hidden" value="<?php echo $content->IDPage ?>"/>
            <input name="Description" type="hidden" value="<?php echo $content->Description ?>" />
            <label style="display:none"><span><?php echo $CMSText_IDPageAllPage ?>:</span>
                <?php
                $AllPage = 0;
                require('List_AllPage.php');
                ?>
            </label>
            <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td valign="top"><label><span><?php echo $CMSText_TitleContent ?></span>
                            <input name="Title" type="text" value="<?php echo $content->Title ?>"  class="text ui-corner-all title"/>
                        </label>
                        <br /></td>
                    <td valign="top"><label><span><?php echo $CMSText_IDZoneContent ?>:</span>
                            <div id="ZoneNewContent"></div>
                        </label></td>
                </tr>
                <tr>
                    <td valign="top"><textarea id="editor" name="editor"><?php echo $content->Content ?></textarea></td>
                    <td valign="top">
                        <label>
                            <span><?php echo $CMSText_Note_Theme ?>:</span>
                            <?php
                            $CC = $content->CustomProperty;

                            require('Themes_Note.php');
                            ?>
                        </label>
                        <label><span><br />
                                <?php echo $CMSText_OrderContent ?>:</span>
                            <select name="Position" id="Position" class="text ui-corner-all" >
                                <?php
                                for ($i = 1; $i < 15; $i++) {

                                    echo '<option value="' . $i . '" ';
                                    if ($content->Position == $i) {
                                        echo 'selected=selected';
                                    } echo'>' . $i . '</option>';
                                }
                                ?>
                            </select>
                        </label>
                        <label><span><?php echo $CMSText_TitleCSS ?></span>
                            <input name="css_class" type="text" value="<?php echo $content->css_class ?>" class="text ui-corner-all" />
                            <br />
                        </label>
                        <label>
                            <span>Autor:</span>
                            <input name="Autor" type="text" value="<?php echo $content->Autor ?>" class="text ui-corner-all" />
                            <br />
                        </label>
                        <table align="left">
                            <tr>
                                <td colspan="2"><label><span><?php echo $CMSText_RecycleBinSection ?></span></label></td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="RecycleBin" <?php
                                    if ($content->RecycleBin == '0') {
                                        echo 'checked="checked"';
                                    }
                                    ?> value="0" id="RecycleBin_0" /></td>
                                <td><label class="checkbox"><span><?php echo $CMSText_ShowContentVisible ?></span></label></td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="RecycleBin"<?php
                                    if ($content->RecycleBin == '1') {
                                        echo 'checked="checked"';
                                    }
                                    ?> value="1" id="RecycleBin_1" /></td>
                                <td><label class="checkbox"><span><?php echo $CMSText_ShowContentHidden ?></span></label></td>
                            </tr>
                        </table></td>
                </tr>
            </table>
        </form>
    </div>
    <script type="text/javascript">

        $(document).ready(function () {



            $("#ZoneNewContent").append($('#ListZoneColector').html());

            $("#ZoneNewContent select:eq(1)").remove();

            $("#ZoneNewContent select option[value='<?php echo $content->IDZone ?>']").attr('selected', 'selected');

            setTimeout('editorNote();', 1000);

        });



        function editorNote() {



            $("#editor").cleditor({
                width: "373px", // width not including margins, borders or padding

                height: "300px", // height not including margins, borders or padding

                controls: // controls to add to the toolbar

                        "bold italic underline | style | alignleft center alignright justify | " +
                        "bullets numbering | link unlink | pastetext | source",
                styles: // styles in the style popup

                        [["Paragraph", "<p>"], ["Header 4", "<h4>"]],
                useCSS: false, // use CSS to style HTML when possible (not supported in ie)

                docType: // Document type contained within the editor

                        '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
                docCSSFile: // CSS file used to style the document contained within the editor

                        "_TemplateSite/<?php echo $TemplateSite ?>/css/style.css",
                bodyStyle: // style to assign to document body contained within the editor

                        "<?php echo $bodyStyle ?>"



            })[0].focus();





        }





        /* ----------------------------- CREATE DIALOG --------------------------------------------------*/



    //	$(function() {

        $("#dialog").dialog("destroy");



        var tips = $(".validateTips");

        var allFields = '';

        /*var ProductAutoID = $("#ProductAutoID"),
         
         SectionAutoID = $("#SectionAutoID"),
         
         allFields = $([]).add(ProductAutoID).add(SectionAutoID);
         
         
         
         */

        $("#dialog-form-Administrator").dialog({
            autoOpen: true,
            //height: ($(window).height()-90),

            width: 700,
            maxWidth: 990,
            position: ['3%', 55],
            modal: true,
            buttons: {
                'Editar Nota': function () {

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

                        $('#editor').html(elHTML);

                        var validating = '<label><div class="ui-state-highlight ui-corner-all"><p><?php echo $CMSText_RefreshIn ?><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-refresh"></span></p></div></label>';

                        tips.html(validating);

                        jQuery.ajax({
                            'type': 'POST',
                            'url': '<?php echo $URL_QueryUpdateContent ?>',
                            'cache': false,
                            'data': $("#FormCreateContent").serialize(),
                            'success': function (data) {

                                if (data.indexOf('okay') != -1) {

                                    var ROK = '<label><div class="ui-state-highlight ui-corner-all"><p><?php echo $CMSText_UpdateOK ?><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span></p></div></label>';

                                    tips.html(ROK);

                                    AppSKT.ReloadPage(document.URL);

                                } else {

                                    var RKO = '<label><div class="ui-state-error ui-corner-all"><p><?php echo $CMSText_UpdateError ?><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span></p></div></label>';

                                    tips.html(RKO);

                                }

                            }



                        });





                        /*  -----------------------------  OK  --------------------------*/



                    }

                },
                Cancelar: function () {

                    $('.ui-widget-overlay').remove();
                    $('.cleditorPopup').remove();
                    $('body #dialog-form-Administrator').remove();

                }

            },
            close: function () {

                $('.ui-widget-overlay').remove();
                $('.cleditorPopup').remove();
                $('body #dialog-form-Administrator').remove();

            }

        });

    //	});



        /* ----------------------------- END CREATE DIALOG --------------------------------------------------*/

    </script> 
    <?php
    echo \SKT_ADMIN_AdminWraperClose;
}
?> 