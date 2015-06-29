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
if (\CmsDev\Security\loginIntent::action('validate', 'CustomControl','Edit') === true) {
    echo str_replace('[title]', $CMSText_CustonControlTitle, \SKT_ADMIN_AdminWraperOpen);
    require("../FileSystemsPopUp/FileSystems_Custom.php");
    /*
      $arraypost=array();
      foreach($_POST as $k => $v) $arraypost[]='$AddProduct_'.$k.' = $_POST["'.$k.'"] = '.$v.';<br>';
      echo implode('',$arraypost);
      exit();
     */
    $EditContent_Action = $_POST["Action"]; // = 'Files_Galeria_Multimedia';
    $EditContent_ID = $_POST["ID"]; // = 30;
    $EditContent_CustomProperty = $_POST["CustomProperty"]; // = '/_FileSystems//esp/Clients/';
//ID,Title,Date,IDZone,IDPage,Type,AllPage,Content,RecycleBin,Position,css_class,Description,Custom,CustomProperty
    $content = $SKTDB->get_row("SELECT * FROM " . DB_PREFIX . "content WHERE ID = '$EditContent_ID'");
    $FileSystemsDirName = $directorio;
    ?>
    <div class="container_16">
        <div class="CreateContentHtml">
            <form action="" method="post" id="FormCreateContent">
                <input name="ID" type="hidden" value="<?php echo $content->ID ?>" />
                <input name="CCFromTemplate" id="CCFromTemplate" type="hidden" value="<?php echo $content->CCFromTemplate ?>" />
                <div class="grid_16">
                    <div class="grid_7">
                        <label><span><?php echo $CMSText_SKT_Controls ?>:</span>
                            <?php
                            $CC = $EditContent_ID;
                            require('List_SKT_Controls.php');
                            ?>
                        </label>
                        <br />
                        <label><span><?php echo $CMSText_TitleContent ?></span>
                            <input name="Title" type="text" value="<?php echo utf8_encode($content->Title) ?>" class="text ui-corner-all" />
                        </label><br />
                        <label>
                            <span><?php echo $CMSText_IDPageAllPage ?>:</span>
                            <p>
                                <?php
                                $AllPage = 0;
                                require('List_AllPage.php');
                                ?>
                            </p>
                        </label><br />
                        <label>
                            <span><?php echo $CMSText_IDZoneContent ?>:</span>
                            <p>
                            <dd id="ZoneNewContent"></dd>
                            </p>
                            <br />
                        </label>
                        <br />
                        <label><span><?php echo $CMSText_OrderContent ?>:</span><br />
                            <select name="Position" id="Position" class="text ui-corner-all" >
                                <?php
                                for ($i = 1; $i < 20; $i++) {
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                }
                                ?>
                            </select>
                        </label>
                        <br />
                        <label><span><?php echo $CMSText_ShowContent ?></span></label>
                        <p>
                        <table align="left">
                            <tr>
                                <td colspan="2"><label><span><?php echo $CMSText_RecycleBinSection ?></span></label></td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="RecycleBin" checked="checked" value="0" id="RecycleBin_0" /></td>
                                <td><label class="checkbox"><span><?php echo $CMSText_ShowContentVisible ?></span></label></td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="RecycleBin" value="1" id="RecycleBin_1" /></td>
                                <td><label class="checkbox"><span><?php echo $CMSText_ShowContentHidden ?></span></label></td>
                            </tr>
                        </table>
                        </p>
                    </div>
                    <div class="grid_8"><br />
                        <label><span><?php echo $CMSText_CustomProperty ?></span>
                            <input name="CustomProperty" id="CustomProperty" type="text" value="<?php echo $content->CustomProperty ?>"  class="text ui-corner-all" />
                        </label>
                        <div class="CustomPropertyFolder" style="display:none;">
                            <?php
                            $allowed = array('');
//echo $FileSystemsDirName;
                            echo FolderSystemUL("../../_FileSystems/", "javascript:CustomPropertyFolder('[link]');", $allowed);
                            ?>
                        </div>
                        <div class="CustomPropertyFiles" style="display:none;">
                            <?php
                            $allowed2 = array('jpg', 'gif', 'png');
//echo $FileSystemsDirName;
                            echo FolderSystemUL("../../_FileSystems/", "javascript:CustomPropertyFile('[link]');", $allowed2);
                            ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="clear"></div>
        <?php echo \SKT_ADMIN_AdminWraperClose ?> 
        <script type="text/javascript">
            $(document).ready(function () {
                $(".FolderSystemUL").find("UL").hide();
                $("#ZoneNewContent").append($('#ListZoneColector').html());
                $("#ZoneNewContent select option[value='<?php echo $content->IDZone ?>']").attr('selected', 'selected');
                $("#ZoneNewContent select:eq(1)").remove();
                $('#dialog-form-Administrator .FolderSystemUL,#dialog-form-Administrator .CustomPropertyFolder').css({'overflow-y': 'auto', 'height': ($('#dialog-form-Administrator').height() - 50)});
                initMenu();
            });
            $('select#Custom').change(function () {
                var str = "";
                var CCFromTemplate = "";
                $('sel ect#Custom option:selected').each(function () {
                    str += $(this).attr('class');
                    CCFromTemplate = $(this).attr('title');
                });
                $('#FormCreateContent input#CCFromTemplate').val(CCFromTemplate);
                if (str.indexOf("Folder") > 0) {
                    $('.CustomPropertyFolder').show('slow');
                    $('.CustomPropertyFiles').hide();
                } else if (str.indexOf("File") > 0) {
                    $('.CustomPropertyFolder').hide();
                    $('.CustomPropertyFiles').show('slow');
                } else {
                    $('.CustomPropertyFolder').hide();
                    $('.CustomPropertyFiles').hide();
                }
            }).change();
            function initMenu() {
                $(' .pft-directory .iconfolder').each(function () {
                    var checkElement = $(this).next().next();
                    if (checkElement.is('ul')) {
                        $(this).addClass('iconmore');
                    }
                });
                $(' .pft-directory .iconmore').toggle(function (event) {
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
            function CustomPropertyFolder(folder) {
                folder = folder.replace('../../', '');
                $('#FormCreateContent input#CustomProperty').val('/' + folder + '/');
            }
            function CustomPropertyFile(File) {
                File = File.replace('../../', '');
                $('#FormCreateContent input#CustomProperty').val('/' + File);
            }
            /* ----------------------------- CREATE DIALOG --------------------------------------------------*/
            //	$(function() {
            $("#dialog").dialog("destroy");
            var tips = $(".validateTips");
            /*var ProductAutoID = $("#ProductAutoID"),
             SectionAutoID = $("#SectionAutoID"),
             allFields = $([]).add(ProductAutoID).add(SectionAutoID);
             */
            $("#dialog-form-Administrator").dialog({
                autoOpen: true, height: ($(window).height() - 90),
                width: 990,
                maxWidth: 990,
                position: ['3%', 55],
                modal: true,
                buttons: {
                    'Editar Contenido (Control)': function () {
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
    <?php } ?>