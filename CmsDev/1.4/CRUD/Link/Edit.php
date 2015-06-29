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
if (\CmsDev\Security\loginIntent::action('validate', 'Link', 'Edit') === true) {
    echo str_replace('[title]', \SKT_ADMIN_Link_Create, \SKT_ADMIN_AdminWraperOpen);
    $ID = $_POST['ID'];
    $Querylinks = $SKTDB->get_row("SELECT * FROM " . DB_PREFIX . "links WHERE ID = '$ID' ");
    $QuerylinksSEC = $SKTDB->get_row("SELECT * FROM " . DB_PREFIX . "sections WHERE Link_ID = '$ID' ");
    ?>
    <div class="container_16">
        <div class="CreateContentHtml">
            <div id="server_response_NewlinksData"></div>
            <form action="" method="post" id="NewlinksData">
                <div class="grid_8">
                    <fieldset>
                        <input name="ID" id="ID" type="hidden" value="<?php echo $Querylinks->ID ?>"  class="text ui-corner-all" />
                        <input name="URLName" id="URLNameNewSection" type="hidden" value="link"  class="text ui-corner-all" />        
                        <label> <span><?php echo \SKT_ADMIN_TXT_Title ?>:</span>
                            <input name="LinkTitle" id="LinkTitle" type="text" value="<?php echo $Querylinks->LinkTitle ?>"  onBlur="AppSKT.CheckURLName(this.value, 'URLNameNewSection')"  class="text ui-corner-all" />
                        </label>
                        <label> <span><?php echo \SKT_ADMIN_Link_Name ?>:</span>
                            <input name="Link" id="Link" type="text" value="<?php echo $Querylinks->Link ?>" class="text ui-corner-all" />
                        </label>
                        <label> <span>Target:</span>
                            <select name="Target">
                                <option value="_blank" <?php
                                if ($Querylinks->Target == '_blank') {
                                    echo 'selected="selected"';
                                }
                                ?>><?php echo \SKT_ADMIN_Link_Target_blank ?></option>
                                <option value="_self" <?php
                                if ($Querylinks->Target == '_self') {
                                    echo 'selected="selected"';
                                }
                                ?>><?php echo \SKT_ADMIN_Link_Target_self ?></option>
                            </select>
                        </label>
                        <label>

                            <label><span><?php echo \SKT_ADMIN_TXT_DisplayOnMenu ?></span>
                                <?php
                                $DisplayOnMenu = new \CmsDev\CRUD\Xtras\List_Menu();
                                echo $DisplayOnMenu->set($Querylinks->Link, 1);
                                ?>
                            </label>
                            <label><span><?php echo \SKT_ADMIN_TXT_OrderMenuSection ?>:</span>
                                <?php
                                $List_Position_Section = new \CmsDev\CRUD\Xtras\List_Position_Section();
                                echo $List_Position_Section->set($QuerylinksSEC->DisplayOnMenu, \SKT_SECTION_ID);
                                ?>
                            </label> 
                    </fieldset>
                </div>
                <div class="grid_8">
                    <fieldset>
                        <label> <span><?php echo \SKT_ADMIN_TXT_Section_CSS ?>:</span>
                            <input name="css_class" id="css_class" type="text" value="<?php echo $Querylinks->css_class ?>" class="text ui-corner-all" />
                        </label>
                        <label style="display:none;"> <span><?php echo \SKT_ADMIN_Link_Type ?></span>
                            <select name="LinkType">
                                <option value="normal" <?php
                                if ($Querylinks->LinkType == 'normal') {
                                    echo 'selected="selected"';
                                }
                                ?>>Normal</option>
                                <option value="mailto" <?php
                                if ($Querylinks->LinkType == 'mailto') {
                                    echo 'selected="selected"';
                                }
                                ?>>E-mail</option>
                                <option value="popup" <?php
                                if ($Querylinks->LinkType == 'popup') {
                                    echo 'selected="selected"';
                                }
                                ?>>PopUp</option>
                            </select>
                        </label>
                        <label style="display:none;">
                            <span><?php echo \SKT_ADMIN_Link_IsPopup ?></span>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>W</td>
                                    <td>
                                        <input name="W" type="text" id="W" value="<?php echo $Querylinks->W ?>">
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>H</td>
                                    <td>
                                        <input name="H" type="text" id="H" value="<?php echo $Querylinks->H ?>">
                                    </td>
                                </tr>
                            </table>

                        </label>
                    </fieldset>
                </div>
            </form>
        </div>
        <div class="clear"></div>
        <?php echo \SKT_ADMIN_AdminWraperClose ?> 
        <script type="text/javascript">
            $("#dialog-form-Administrator #Language").val(Language);
            $("#dialog").dialog("destroy");

            var tips = $(".validateTips");
            var allFields = '';
            var Section_Title = $("#LinkTitle"),
                    Link = $("#Link"),
                    allFields = $([]).add(Section_Title).add(Link);

            $("#dialog-form-Administrator").dialog({
                autoOpen: true,
                width: 600,
                maxWidth: 600,
                position: ['3%', 55],
                modal: true,
                buttons: {
                    'Editar link': function () {
                        var bValid = true;
                        allFields.removeClass('ui-state-error');
                        bValid = bValid && AppSKT.checkLength(Section_Title, "Nombre para mostrar", 3, 255);
                        bValid = bValid && AppSKT.checkLength(Link, "Escriba el link", 3, 255);
                        if (bValid) {
                            var validating = '<label><div class="ui-state-highlight ui-corner-all"><p>' + SKT_ADMIN_Message_Validating + '<span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-refresh"></span></p></div></label>';
                            $("#server_response_NewlinksData").html(validating);
                            jQuery.ajax({
                                'type': 'POST',
                                'url': 'SKTGoTo/' + admd2('/Query/EditLink'),
                                'cache': false,
                                'data': $("#NewlinksData").serialize(),
                                'success': function (data) {
                                    if (data.indexOf('okay') != -1) {
                                        var ROK = '<label><div class="ui-state-highlight ui-corner-all"><p>' + SKT_ADMIN_Message_Update_OK + '<span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span></p></div></label>';
                                        $("#server_response_NewlinksData").html(ROK);

                                        var TheUrl = document.URL;
                                        if (TheUrl.toLowerCase().indexOf(Language) == -1) {
                                            TheUrl += Language + '/';
                                        }
                                        AppSKT.ReloadPage(TheUrl);
                                    } else {
                                        var RKO = '<label><div class="ui-state-error ui-corner-all"><p>' + SKT_ADMIN_Message_Update_Error + '<span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span></p></div></label>';
                                        $("#server_response_NewlinksData").html(RKO);
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