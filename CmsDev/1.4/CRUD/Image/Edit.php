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
if (\CmsDev\Security\loginIntent::action('validate', 'Image','Edit') === true) {

    $ID = $_POST['ID'];
    $content = $SKTDB->get_row("SELECT * FROM " . DB_PREFIX . "content WHERE ID = '$ID'");

    echo str_replace('[title]', 'Editar (Imagen)', \SKT_ADMIN_AdminWraperOpen);

    if (!class_exists('FileDataRecovery')) {
        require('../FileDataRecovery.php');
    }
    $file = CorrectURL($_SERVER["DOCUMENT_ROOT"] . $subSite) . $content->CustomProperty;
    $F = new FileDataRecovery();
    $F->File($file);
    $W = $F->size('w', false);
    $H = $F->size('h', false);
    $title = utf8_encode($F->DataTag('title'));
    $Description = utf8_encode($F->DataTag('Description'));
    $hiperlink = $F->DataTag('hiperlink', false);
    $FileOrder = $F->DataTag('FileOrder');
    ?>
    <style media="all" type="text/css">
        body{overflow:hidden !important;}
    </style>
    <div class="container_16">
        <div class="CreateContentHtml"><?php //echo $file      ?>
            <h3>Actual: <?php echo $content->CustomProperty ?></h3>
            <form action="" method="post" id="FormCreateContent">
                <input name="CreateContentEditor" type="hidden" value=" " />
                <input name="Date" type="hidden" value="<?php echo date('Y-m-d') ?>" />
                <input name="IDPage" readonly type="hidden" value="<?php echo $content->IDPage ?>" />
                <input name="Type" type="hidden" value="Photo" />
                <input name="AllPage" type="hidden" value="0" />
                <input name="ID" type="hidden" value="<?php echo $ID ?>" />

                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="150" rowspan="14"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td><div class="divpnglist" id="ImagePreview"><img src="<?php echo $content->CustomProperty ?>" style="width:90%;" /></div></td>
                                </tr>
                                <tr>
                                    <td><label><span><?php echo $CMSText_IDZoneContent ?>:</span></label></td>
                                </tr>
                                <tr>
                                    <td><div id="ZoneNewContent"></div></td>
                                </tr>
                                <tr>
                                    <td><label><span><?php echo $CMSText_OrderContent ?>:</span></label></td>
                                </tr>
                                <tr>
                                    <td><select name="Position" id="Position" class="text ui-corner-all" >
                                            <?php
                                            for ($i = 1; $i < 10; $i++) {
                                                echo '<option value="' . $i . '" ';
                                                if ($content->Position == $i) {
                                                    echo 'selected=selected';
                                                } echo'>' . $i . '</option>';
                                            }
                                            ?>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="adicionalTags">
                                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <label><span><?php echo $CMSText_TitleContent ?> (Opcional)</span></label><div class="SaveTags"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input name="Title" id="Title" type="text" value="<?php echo $Title ?>"  class="text ui-corner-all" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label><span><?php echo $CMSText_Description ?></span></label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <textarea name="Description" id="Description" cols="45" rows="2" style="height:50px"><?php echo $Description ?></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>
                                                            <div style="float:right; cursor:pointer; text-decoration:underline; display:none;" id="CheckClick">Registrar Click</div>
                                                            <span>Link (Opcional)</span>
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input name="hiperlink" id="hiperlink" type="text" value="<?php echo $hiperlink ?>" class="text ui-corner-all"/>
                                                        <input name="FileOrder" id="FileOrder" type="hidden" value="<?php echo $FileOrder ?>" />
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
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
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><input name="reset" id="reset" type="reset" value="Restaurar a valores iniciales" /></td>
                                            </tr>
                                        </table></td>
                                </tr>
                            </table></td>
                        <td width="53%"><label><span><?php echo $CMSText_Photo; ?></span>
                                <input name="CustomProperty" id="CustomProperty" type="text" value="<?php echo $content->CustomProperty ?>"  class="text ui-corner-all" /></label></td>
                        <td width="12%" nowrap="nowrap"><label><span><?php echo $CMSText_FileNewFileX ?></span>
                                <input name="FileNewFileX" id="FileNewFileX" type="text" value="<?php echo $W ?>" class="text ui-corner-all"/>
                            </label></td>
                        <td width="12%" nowrap="nowrap"><label> </label>
                            <label><span><?php echo $CMSText_FileNewFileY ?></span>
                                <input name="FileNewFileY" id="FileNewFileY" type="text" value="<?php echo $H ?>" class="text ui-corner-all"/>
                            </label></td>
                    </tr>
                    <tr>
                        <td colspan="3" rowspan="13">
                            <div id="ImageSystemScroll" style="height:200px; overflow:visible; display:block; position:relative">
                                <?php
//$allowed2 = array('jpg','png');				
//echo ImageSystem('../../_FileSystems/', "javascript:CustomPropertyFile('[this]','[name]','[w]','[h]');",$allowed2);
                                require("../FileSystemsPopUp/PopUp_SystemIframeFolder.php");
                                ?>
                            </div>          </td>
                    </tr>
                </table>
                <input id="resetear" type="reset" style="display:none" />
            </form>

        </div>
        <div class="clear"></div>
    </div>
    <?php echo \SKT_ADMIN_AdminWraperClose ?><script type="text/javascript">
        $(document).ready(function () {
            $(".FolderSystemUL").find("UL").hide();
            $("#ZoneNewContent").append($('#ListZoneColector').html());
            $("#ZoneNewContent select:eq(1)").remove();
            $("#ZoneNewContent select option[value='<?php echo $content->IDZone ?>']").attr('selected', 'selected');
            $('#dialog-form-Administrator #ImageSystemScroll').css({'height': ($(window).height() - 280)});
            $('#dialog-form-Administrator #ImageSystemScroll .tableSystem , #dialog-form-Administrator #ImageSystemScroll .tableSystem #IframeFiles , #dialog-form-Administrator #ImageSystemScroll .tableSystem .FolderSystemUL ')
                    .css({'height': ($('#dialog-form-Administrator #FormCreateContent').height())});

            initMenu();


            $('input#reset').click(function () {
                setTimeout("$('#dialog-form-Administrator div#ImagePreview img').attr('src',$('input#CustomProperty').val());", 500);
            });

            $('#CheckClick').click(function () {
                var TheLink = $('#dialog-form-Administrator input#hiperlink');
                var CheckLink = '[CheckLink]' + TheLink.val();
                TheLink.val(CheckLink);
            });

            $('.SaveTags').click(function () {
                var File = $('#dialog-form-Administrator input#CustomProperty').val();
                if (File != '') {
                    var Title = $('#dialog-form-Administrator input#Title').val();
                    var tags = $('#dialog-form-Administrator textarea#Description').val();
                    var hiperlink = $('#dialog-form-Administrator input#hiperlink').val();
                    var FileOrder = $('#dialog-form-Administrator input#FileOrder').val();
                    jQuery.ajax({
                        'type': 'POST',
                        'url': URL_VERSION + 'AdminFilesystem/PopUp_Systems_SaveTags.php',
                        'cache': false,
                        'data': 'File=' + File + '&Title=' + Title + '&tags=' + tags + '&hiperlink=' + hiperlink + '&FileOrder=' + FileOrder,
                        'success': function (data) {

                        }
                    });
                }
            });
        });

        function resetear() {
            $('input#reset').trigger('click');
        }


        function initMenu() {

            $('.pft-directory .iconfolder').each(function () {
                var checkElement = $(this).next().next();
                if (checkElement.is('ul')) {
                    $(this).addClass('iconmore');
                }
            });


            $('.pft-directory .iconmore').toggle(function (event) {
                var checkElement = $(this).next().next();

                if ((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
                    checkElement.slideDown();
                    event.preventDefault();
                }

            }, function () {
                var checkElement = $(this).next().next();

                if ((checkElement.is('ul')) && (checkElement.is(':visible'))) {
                    checkElement.slideUp();
                    event.preventDefault();
                }
            });

        }
        function CustomPropertyFile(dir, name, w, h) {
            $('#dialog-form-Administrator input#CustomProperty').val(dir);
            $('#dialog-form-Administrator input#FileNewFileX').val(w);
            $('#dialog-form-Administrator input#FileNewFileY').val(h);

            var File = '<?php echo $LOC ?>' + dir;
            File.replace('////g', '');
            var SRC = name;
            var TitleSplit = File.split('/');
            var count = TitleSplit.length - 1;
            var TitleFile = TitleSplit[count];
            jQuery.ajax({
                'type': 'POST',
                'url': URL_VERSION + 'AdminFilesystem/PopUp_SystemLoadTags.php',
                'cache': false,
                'data': 'File=' + File,
                'success': function (data) {
                    var dataSplit = data.split('|');
                    var Title = dataSplit[0];
                    var tags = dataSplit[1];
                    var hiperlink = dataSplit[2];
                    var FileOrder = dataSplit[3];
                    if (tags == 'undefined' || tags == '' || tags == null) {
                        tags = '';
                    }
                    if (hiperlink == 'undefined' || hiperlink == '' || hiperlink == null) {
                        hiperlink = '';
                    }
                    if (FileOrder == '' || FileOrder == null || FileOrder == 'undefined') {
                        Fileorder = 999;
                    }
                    if (Title != '' || Title != null || Title != 'undefined') {
                        $('#dialog-form-Administrator input#Title').val(Title);
                    }
                    if (tags != '' || tags != null || tags != 'undefined') {
                        $('#dialog-form-Administrator textarea#Description').html(tags);
                    }
                    if (hiperlink != '' || hiperlink != null || hiperlink != 'undefined') {
                        $('#dialog-form-Administrator input#hiperlink').val($.trim(hiperlink));
                    }
                    if (FileOrder != '' || FileOrder != null || FileOrder != 'undefined') {
                        $('#dialog-form-Administrator input#FileOrder').val($.trim(FileOrder));
                    }
                    if (dir != '') {
                        $('#dialog-form-Administrator div#ImagePreview').html('').html('<img src="' + dir + '" style="width:90%;" />');
                    }
                }
            });


        }
        /* ----------------------------- CREATE DIALOG --------------------------------------------------*/

    //	$(function() {
        $("#dialog").dialog("destroy");

        var tips = $(".validateTips");
        var CustomProperty = $("#dialog-form-Administrator input#CustomProperty"),
                allFields = $([]).add(CustomProperty);


        $("#dialog-form-Administrator").dialog({
            autoOpen: true,
            height: ($(window).height()),
            width: ($(window).width()),
            //position: ['1%',55],
            modal: true,
            buttons: {
                'Actualizar Imagen)': function () {
                    var bValid = true;
                    allFields.removeClass('ui-state-error');

                    /* ----------------------------- VALIDATE FIELDS --------------------------------------------------*/

                    bValid = bValid && checkRegexp(CustomProperty, /^([0-9a-zA-Z])+$/, "Indique una imagen a colocar en la zona seleccionada.");

                    /* ----------------------------- END VALIDATE FIELDS --------------------------------------------------*/

                    if (bValid) {
                        /*  -----------------------------  IF OK  --------------------------*/
                        var File = $('#dialog-form-Administrator input#CustomProperty').val();
                        var Title = $('#dialog-form-Administrator input#Title').val();
                        var tags = $('#dialog-form-Administrator textarea#Description').val();
                        var hiperlink = $('#dialog-form-Administrator input#hiperlink').val();
                        var FileOrder = $('#dialog-form-Administrator input#FileOrder').val();

                        /* SAVE TAGS ( Title - Description - Hiperlink - FileOrder )*/
                        jQuery.ajax({
                            'type': 'POST',
                            'url': URL_VERSION + 'AdminFilesystem/PopUp_Systems_SaveTags.php',
                            'cache': false,
                            'data': 'File=<?php echo $LOC ?>' + File + '&Title=' + Title + '&tags=' + tags + '&hiperlink=' + hiperlink + '&FileOrder=' + FileOrder,
                            'success': function (data) {



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



                            }
                        });




                        /*  -----------------------------  OK  --------------------------*/

                    }
                },
                'Restaurar a valores iniciales': function () {
                    resetear();
                },
                Cancelar: function () {
                    $('.ui-widget-overlay').remove();
                    $('body #dialog-form-Administrator').remove();
                    $('.cleditorPopup').remove();
                }
            },
            close: function () {
                $('.ui-widget-overlay').remove();
                $('body #dialog-form-Administrator').remove();
                $('.cleditorPopup').remove();
            }
        });
    //	});

        /* ----------------------------- END CREATE DIALOG --------------------------------------------------*/
    </script> 
<?php
}?>