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
if (\CmsDev\Security\loginIntent::action('validate', 'News','Add') === true) {

    $Section_AutoID = $SKTDB->get_var("SELECT MAX(ID) FROM " . DB_PREFIX . "sections") + 1;
    $Section_AutoID_IMG = $Section_AutoID . date('Y-m-d-h-s');

    echo str_replace('[title]', 'Agregar Noticia', \SKT_ADMIN_AdminWraperOpen);
    ?>

    <div class="container_16">
        <div class="CreateContentHtml">
            <div id="server_response_NewSectionData"></div>
            <form action="" method="post" id="NewSectionData">
                <div id="CmsDevTabs">
                    <ul>
                        <li><a href="#tabs-1">Datos para la Lista y Buscadores</a></li>
                        <li><a href="#tabs-2">Contenido Inicial</a></li>
                        <!--<li><a href="#tabs-3">Meta-Descripci&oacute;n</a></li>-->
                    </ul>
                    <div id="tabs-1">
                        <div class="grid_8">
                            <fieldset>
                                <?php
                                $SearchURLName = str_replace($subSite, '', CorrectURL($_POST['RenderURL']));
                                echo '<input name="SearchURLName" readonly="readonly" type="hidden" value="' . $SearchURLName . '" />';
                                echo '<input name="RenderURL" readonly="readonly" type="hidden" value="' . CorrectURL($_POST['RenderURL']) . '" />';
                                echo '<input name="RenderSubDir" readonly="readonly" type="hidden" value="' . CorrectURL($_POST['RenderSubDir']) . '" />';
                                echo '<input name="Language" id="Language" type="hidden" value="" />';
                                echo '<input name="SystemRequired" type="hidden" value="1" />';
                                echo '<input name="SID" type="hidden" value="' . $_POST['IDPage'] . '" />';
                                echo '<input name="Template" type="hidden" value="Noticias_Detalle" />';
                                echo '<input name="Position" type="hidden" value="0" />';
                                echo '<input name="DisplayOnMenu" type="hidden" value="0" />';
                                echo '<input name="LinkActive" type="hidden" value="1" checked>';
                                echo '<label>
				  			<span>' . $CMSText_NewsTitle . '</span>
				  			<input name="Title" id="Title" type="text" value="" onblur="AppSKT.CheckURLName(this.value,\'URLNameNewSection\')" class="text ui-corner-all" />
						</label>';
                                echo '<label>
				  			<span>' . $CMSText_NewsURL . ':<span id="urlNew"></span></span>
							<input name="URLName" id="URLNameNewSection" type="text" value=""  class="text ui-corner-all" />
						</label>';
                                echo '<label><span>' . $CMSText_MetaDataDescription . '</span><textarea name="MetaDataDescription" cols="" rows=""  class="text ui-corner-all">' . $SectionMetaData->MetaDataDescription . '</textarea></label>';
                                ?>
                                <table align="left">
                                    <tr>
                                        <td align="left" valign="middle" nowrap="nowrap">
                                            <input type="radio" name="RecycleBin" value="0" id="RecycleBin_0"  checked="checked"/>
                                        </td>
                                        <td align="left" valign="middle" nowrap="nowrap">
                                            <label class="checkbox" for="RecycleBin_0"><span><?php echo $CMSText_ShowContentVisible ?></span></label>
                                        </td>
                                        <td align="left" valign="middle" nowrap="nowrap">&nbsp;</td>
                                        <td align="left" valign="middle" nowrap="nowrap">
                                            <input type="radio" name="RecycleBin" value="1" id="RecycleBin_1" />
                                        </td>
                                        <td align="left" valign="middle" nowrap="nowrap">
                                            <label class="checkbox" for="RecycleBin_1"> <span><?php echo $CMSText_ShowContentHidden ?></span> </label>
                                        </td>
                                    </tr>
                                </table>
                            </fieldset>
                            <div class="clear"></div>
                        </div>
                        <div class="grid_3">
                            <input name="SectionImage2" id="SectionImage2" type="hidden" value="" />
                            <div id="SectionImageIMG2"></div>
                            <span><?php echo $CMSText_SectionImage ?><span id="RQdataImg2"></span></span>
                            <div id="file-uploader2">
                                <noscript>
                                <p>Lo sentimos, para cargar el archivo es necesario tener java activado en su navegador.<br />
                                    Recomendamos como navegador: IExplorer > 8, Firefox o Chrome.</p>
                                </noscript>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="grid_5">
                            <fieldset>
                                <?php echo '<label><span>META-' . $CMSText_MetaDataKeywords . '</span><textarea name="MetaDataKeywords" cols="" rows=""  class="text ui-corner-all">' . $SectionMetaData->MetaDataKeywords . '</textarea></label>';
                                ?>
                            </fieldset>
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div id="tabs-2">
                        <label><span><?php echo $CMSText_ProductDescription ?></span>
                            <textarea id="NewsDescriptionHTML" name="NewsDescriptionHTML"  class="text ui-corner-all" style="height: 350px;"></textarea>
                            <br>
                            <br>
                        </label>
                    </div>
                    <div class="clear"></div>
                </div>
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <script type="text/javascript">

        /* ----------------------------- UPLOAD --------------------------------------------------*/
        var uploader2 = new qq.FileUploader({
            element: document.getElementById('file-uploader2'),
            action: './_CmsDevfileuploader/SectionUpload.php?SessionURLSection=<?php echo $Section_AutoID_IMG ?>',
            multiple: true,
            sizeLimit: 1024000,
            allowedExtensions: ['jpg', 'png', 'gif'],
            onComplete: function (id, fileName, responseJSON) {
                $("#SectionImageIMG2").html('');
                $('.qq-upload-list').html('');
                $("#SectionImageIMG2").html('<img src="./_FileSystems/images/' + responseJSON["filename"] + '?r=' + Math.floor(Math.random() * 4) + '" alt=""/>');
                $("#SectionImage2").val(responseJSON["filename"]);
            }
        });

        function HTML_Content_Add_News() {
            CreateContentEditor({
                'Element': '#NewsDescriptionHTML',
                'width': '700px',
                'height': '350px',
                'colors': "<?php echo $ExtraColorsEditor; ?>",
                'fonts': "<?php echo $ExtraFontEditor ?>",
                'bodyStyle': "<?php echo $bodyStyle ?>",
                'docCSSFile': "_TemplateSite/<?php echo $TemplateSite ?>/css/style.css",
                'docType': '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'
            });
            $('#AddProductBox').css('display', 'block');
        }

        $(document).ready(function () {
            $(function () {
                $("#CmsDevTabs").tabs();
            });
            var t = setTimeout('HTML_Content_Add_News()', 1000);

        });

        /* ----------------------------- CREATE DIALOG --------------------------------------------------*/
        $("#dialog-form-Administrator #Language").val(Language);
        //	$(function() {
        $("#dialog").dialog("destroy");

        var tips = $(".validateTips");
        var allFields = '';
        var Section_Title = $("#Title"),
                Section_URLName = $("#URLNameNewSection"),
                allFields = $([]).add(Section_Title).add(Section_URLName);


        $("#dialog-form-Administrator").dialog({
            autoOpen: true,
            height: ($(window).height() - 90),
            //height: 450,
            width: 990,
            position: ['3%', 55],
            modal: true,
            buttons: {
                'Agregar Noticia': function () {
                    var bValid = true;
                    allFields.removeClass('ui-state-error');

                    /* ----------------------------- VALIDATE FIELDS --------------------------------------------------*/
                    bValid = bValid && AppSKT.checkLength(Section_URLName, "'Direcci&oacute;n de la P&aacute;gina' NO es v&aacute;lida, no puede contener espacios ni caracteres especiales y", 3, 255);

                    bValid = bValid && AppSKT.checkLength(Section_Title, "Nombre la Secci&oacute;n", 3, 255);

                    /* ----------------------------- END VALIDATE FIELDS --------------------------------------------------*/

                    if (bValid) {
                        /*  -----------------------------  IF OK  --------------------------*/

                        var validating = '<label><div class="ui-state-highlight ui-corner-all"><p><?php echo $CMSText_RefreshIn ?><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-refresh"></span></p></div></label>';
                        $("#server_response_NewSectionData").html(validating);
                        jQuery.ajax({
                            'type': 'POST',
                            'url': '_CmsDevquery/CreateSectionNews.php',
                            'cache': false,
                            'data': $("#NewSectionData").serialize(),
                            'success': function (data) {
                                if (data.indexOf('okay') != -1) {
                                    var ROK = '<label><div class="ui-state-highlight ui-corner-all"><p><?php echo $CMSText_UpdateOK ?><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span></p></div></label>';
                                    $("#server_response_NewSectionData").html(ROK);

                                    jQuery.ajax({
                                        'type': 'POST',
                                        'url': '_CmsDevquery/UpdateSectionImage.php',
                                        'cache': false,
                                        'data': 'ID=<?php echo $Section_AutoID ?>&SectionImage=' + $("#SectionImage2").val(),
                                        'success': function (RQdata) {
                                            $("#RQdataImg2").html(RQdata);
                                        }
                                    });

                                    var TheUrl = document.URL;
                                    if (TheUrl.toLowerCase().indexOf(Language) == -1) {
                                        TheUrl += Language;
                                    }
                                    AppSKT.ReloadPage(TheUrl + '/' + $("#URLNameNewSection").val());
                                } else {
                                    var RKO = '<label><div class="ui-state-error ui-corner-all"><p><?php echo $CMSText_UpdateError ?><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span></p></div></label>';
                                    $("#server_response_NewSectionData").html(RKO);
                                }
                            }

                        });


                        /*  -----------------------------  OK  --------------------------*/

                    }
                },
                Cancelar: function () {
                    $('.ui-widget-overlay').remove();
                    $('body #dialog-form-Administrator').remove();
                }
            },
            close: function () {
                $('.ui-widget-overlay').remove();
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