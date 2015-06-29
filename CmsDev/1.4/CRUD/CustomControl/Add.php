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
if (\CmsDev\Security\loginIntent::action('validate','CustomControl','Add') === true) {
    ?>
    <?php echo str_replace('[title]', \SKT_ADMIN_TypeContentSKT_Controls . ' ' . \SKT_SECTION_TITLE, \SKT_ADMIN_AdminWraperOpen); ?>
    <div class="container_16">
        <div class="CreateContentHtml">
            <form action="" method="post" id="FormCreateContent">
                <div class="grid_16">
                    <div class="grid_5">
                        <input name="CCFromTemplate" id="CCFromTemplate" type="hidden" value="" />
                        <input name="Date" type="hidden" value="<?php echo date('Y-m-d') ?>" />
                        <input name="IDPage" readonly type="hidden" value="<?php echo $_POST['IDPage'] ?>" />
                        <input name="Type" type="hidden" value="SKT_Controls" />
                        <label><span><?php echo \SKT_ADMIN_TypeContentSKT_Controls ?>:</span>
                            <?php
                            $List_SKT_Controls = \CmsDev\CRUD\Xtras\List_SKT_Controls::get();
                            echo $List_SKT_Controls->Render();
                            ?>
                        </label>
                        <br />
                        <label><span><?php echo \SKT_ADMIN_TXT_ConfigContentTitle ?></span>
                            <input name="Title" type="text" value=""  class="text ui-corner-all" />
                        </label>
                        <label>
                            <span><?php echo \SKT_ADMIN_TXT_View_AllPagesTitle ?>:</span>
                            <p>
                                <?php
                                $AllPage = 0;
                                ?>
                                <select name="AllPage">
                                    <option value="0"<?php
                                    if ($AllPage == "0") {
                                        echo 'selected="selected"';
                                    }
                                    ?>><?php echo \SKT_ADMIN_TXT_View_AllPages0; ?></option>
                                    <option value="1"<?php
                                    if ($AllPage == "1") {
                                        echo 'selected="selected"';
                                    }
                                    ?>><?php echo \SKT_ADMIN_TXT_View_AllPages1; ?></option>
                                </select>
                            </p>
                        </label>
                    </div>
                    <div class="grid_2">&nbsp;</div>
                    <div class="grid_5">
                        <label>
                            <span><?php echo \SKT_ADMIN_TXT_Zone ?>:</span>
                            <p>
                            <dd id="ZoneNewContent"></dd>
                            </p>
                            <br />
                        </label>
                        <br />
                        <label><span><?php echo \SKT_ADMIN_TXT_ZoneOrder ?>:</span><br />
                            <select name="Position" id="Position" class="text ui-corner-all" >
                                <?php
                                for ($i = 1; $i < 20; $i++) {
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                }
                                ?>
                            </select>
                        </label>
                        <br />
                        <label><span><?php echo \SKT_ADMIN_TXT_ShowContentVisible ?></span></label>
                        <p>
                        <table align="left">
                            <tr>
                                <td colspan="2"><label><span><?php echo \SKT_ADMIN_RecycleTitle ?></span></label></td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="RecycleBin" checked="checked" value="0" id="RecycleBin_0" /></td>
                                <td><label class="checkbox"><span><?php echo \SKT_ADMIN_TXT_ShowContentVisible ?></span></label></td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="RecycleBin" value="1" id="RecycleBin_1" /></td>
                                <td><label class="checkbox"><span><?php echo \SKT_ADMIN_TXT_ShowContentHidden ?></span></label></td>
                            </tr>
                        </table>
                        </p>
                    </div>
                    <div class="grid_4">
                        <label>
                            <input name="CustomProperty" id="CustomProperty" type="text" value=""  class="text ui-corner-all" />
                        </label>
                        <div class="CustomPropertyFolder" style="display:none;">
                            <?php
                            $allowed = array('');
//echo $FileSystemsDirName;
                            echo \CmsDev\AdminFilesystem\FileSystems_Custom::FolderSystemUL(\LOCAL_FILESYSTEM, "javascript:CustomPropertyFolder('[link]');", $allowed);
                            ?>
                        </div>
                        <div class="CustomPropertyFiles" style="display:none;">
                            <?php
                            $allowed2 = array('jpg', 'gif', 'png');
                            //echo $FileSystemsDirName;
                            echo \CmsDev\AdminFilesystem\FileSystems_Custom::FolderSystemUL(\LOCAL_FILESYSTEM, "javascript:SKTFSys.CustomPropertyFile('[link]');", $allowed2);
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
                $("#ZoneNewContent select:eq(1)").remove();
                $('#dialog-form-Administrator .FolderSystemUL,#dialog-form-Administrator .CustomPropertyFolder').css({'overflow-y': 'auto', 'height': ($('#dialog-form-Administrator').height() - 50)});
                initMenu();
            });
            $('select#Custom').change(function () {
                var str = "";
                var CCFromTemplate = "";
                $('select#Custom option:selected').each(function () {
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
            function CustomPropertyFolder(folder) {
                folder = folder.replace('../../', '');
                $('#FormCreateContent input#CustomProperty').val('/' + folder + '/');
            }
            function CustomPropertyFile(File) {
                File = File.replace('../../', '');
                $('#FormCreateContent input#CustomProperty').val('/' + File);
            }
            $("#dialog").dialog("destroy");
            var tips = $(".validateTips");
            /*var ProductAutoID = $("#ProductAutoID"),
             SectionAutoID = $("#SectionAutoID"),
             allFields = $([]).add(ProductAutoID).add(SectionAutoID);
             */
            $("#dialog-form-Administrator").dialog({
                autoOpen: true,
                width: 990,
                maxWidth: 990,
                position: [100, 55],
                modal: true,
                buttons: {
                    'Agregar Contenido (Control)': function () {
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
                            jQuery.ajax({
                                'type': 'POST',
                                'url': URL_QueryCreateContent,
                                'cache': false,
                                'data': $("#FormCreateContent").serialize(),
                                'success': function (htmlReturn) {
                                    if ($.trim(htmlReturn) == "okay") {
                                        var ROK = '<label><div class="ui-state-highlight ui-corner-all"><p>' + SKT_ADMIN_Message_Update_OK + '<span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span></p></div></label>';
                                        tips.html(ROK);
                                        AppSKT.ReloadPage(document.URL);
                                    } else {
                                        var RKO = '<label><div class="ui-state-error ui-corner-all"><p>' + SKT_ADMIN_Message_Update_Error + '<span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span></p></div></label>';
                                        tips.html(RKO);
                                    }
                                }
                            });
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
        </script> 

    <?php } ?>