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
if (\CmsDev\Security\loginIntent::action('validate', 'Link','Add') === true) {

    echo str_replace('[title]', \SKT_ADMIN_Tasks13, \SKT_ADMIN_AdminWraperOpen);
    ?>

    <div class="container_16">
        <div class="CreateContentHtml">
            <div id="server_response_NewlinksData"></div>
            <form action="" method="post" id="NewlinksData">
                <input name="SID" type="hidden" value="<?php echo $_POST['IDPage']; ?>" />

    <?php $SearchURLName = $_POST['RenderURL']; ?>

                <input name="SearchURLName" readonly="readonly" type="hidden" value="<?php echo $SearchURLName; ?>" />
                <input name="RenderURL" readonly="readonly" type="hidden" value="<?php echo $_POST['RenderURL']; ?>" />
                <input name="RenderSubDir" readonly="readonly" type="hidden" value="<?php echo $_POST['RenderSubDir']; ?>" />
                <input name="URLName" id="URLNameNewSection" type="hidden" value="link"  class="text ui-corner-all" />
                <input name="SystemRequired" type="hidden" value="1" />
                <input name="LinkActive" type="hidden" value="1" />
                <input name="Language" id="Language" type="hidden" value="<?php echo \THIS_LANG ?>" />
                <input name="SID" type="hidden" value="<?php echo $_POST['IDPage'] ?>" />
                <label class="hidden">
                    <span><?php echo \SKT_ADMIN_Text_MetaDataKeywords ?></span>
                    <input name="tags" type="hidden" value="" />
                </label>
                <div class="skts_content">
                    <div class="SKTrow">
                        <div class="col first">
                            <fieldset>
                                <legend><b><?php echo \SKT_ADMIN_TXT_Section_legend ?></b></legend>
                                <label> <span><?php echo \SKT_ADMIN_Text_LinkTitle ?>:</span>
                                    <input name="LinkTitle" id="LinkTitle" type="text" value=""  onBlur="AppSKT.CheckURLName(this.value, 'URLNameNewSection')" />
                                </label>
                                <label> <span><?php echo \SKT_ADMIN_Text_LinkURL ?>:</span>
                                    <input name="Link" id="Link" type="text" value="" />
                                </label>
                                <label><span><?php echo \SKT_ADMIN_TXT_DisplayOnMenu ?></span>
                                    <?php
                                    $OnMenu = 1;
                                    $DisplayOnMenu = new \CmsDev\CRUD\Xtras\List_Menu();
                                    echo $DisplayOnMenu->set($OnMenu, 1);
                                    ?>
                                </label>
                                <label><span><?php echo \SKT_ADMIN_TXT_OrderMenuSection ?>:</span>
                                    <?php
                                    $List_Position_Section = new \CmsDev\CRUD\Xtras\List_Position_Section();
                                    echo $List_Position_Section->set('max', $_POST['IDPage']);
                                    ?>
                                </label> 
                            </fieldset>
                        </div>
                        <div class="col">
                            <fieldset>
                                <legend><b><?php echo \SKT_ADMIN_Text_LinkTypeLabel ?></b></legend>
                                <label> <span><?php echo \SKT_ADMIN_Text_LinkType ?></span>
                                    <select name="LinkType" id="LinkType">
                                        <option value="normal" selected="selected">Normal</option>
                                        <option value="mailto">E-mail</option>
                                        <option value="popup">PopUp</option>
                                    </select>
                                </label>
                                <label id="TagetLabel" style="display: block;"> <span><?php echo \SKT_ADMIN_Text_Target ?>:</span>
                                    <select name="Target">
                                        <option value="_blank" selected="selected"><?php echo \SKT_ADMIN_Text_Target_blank ?></option>
                                        <option value="_self"><?php echo \SKT_ADMIN_Text_Target_self ?></option>
                                    </select>
                                </label>
                                <label id="TagetSize" style="display: none;">
                                    <span><?php echo \SKT_ADMIN_Text_PopupSize ?></span>
                                    <div class="SKTrow6">
                                        <div class="col first" style="line-height: 22px; text-align: right;"><i class="skt-iconresize-horizontal"></i><b>W</b></div>
                                        <div class="col2"><input name="W" type="text" id="W" value="640"></div>
                                        <div class="col" style="line-height: 22px; text-align: right;"><i class="skt-iconresize-vertical"></i><b>H</b></div>
                                        <div class="col2 last"><input name="H" type="text" id="H" value="480"></div>
                                    </div>
                                </label>
                                <label style="display: none;"> <span><?php echo \SKT_ADMIN_Text_TitleCSS ?>:</span>
                                    <input name="css_class" id="css_class" type="text" value="" />
                                </label>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <div class="clear"></div>
    <script type="text/javascript">
        $("#W").spinner({step: 10, numberFormat: "n", min: 200, max: 1000});
        $("#H").spinner({step: 10, numberFormat: "n", min: 100, max: 600});
        $("#NewlinksData select#LinkType").change(function () {
            $("#NewlinksData select#LinkType option:selected").each(function () {
                var Sel = $.trim($(this).val());
                if (Sel === 'popup') {
                    $("#NewlinksData #TagetLabel").hide();
                    $("#NewlinksData #TagetSize").show();
                } else if (Sel === 'mailto') {
                    $("#NewlinksData #TagetLabel").hide();
                    $("#NewlinksData #TagetSize").hide();
                } else {
                    $("#NewlinksData #TagetLabel").show();
                    $("#NewlinksData #TagetSize").hide();
                }
            });
        }).change();
        /* ----------------------------- CREATE DIALOG --------------------------------------------------*/
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
            minWidth: 400,
            modal: true,
            buttons: {
                'Agregar la nueva seccion': function () {
                    var bValid = true;
                    allFields.removeClass('ui-state-error');
                    /* ----------------------------- VALIDATE FIELDS --------------------------------------------------*/
                    bValid = bValid && AppSKT.checkLength(Section_Title, "Nombre para mostrar", 1, 255);
                    bValid = bValid && AppSKT.checkLength(Link, "Escriba el link", 1, 255);
                    /* ----------------------------- END VALIDATE FIELDS --------------------------------------------------*/
                    if (bValid) {
                        /*  -----------------------------  IF OK  --------------------------*/
                        var validating = '<label><div class="ui-state-highlight ui-corner-all"><p><?php echo \SKT_ADMIN_Message_Refresh ?><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-refresh"></span></p></div></label>';
                        $("#server_response_NewlinksData").html(validating);
                        jQuery.ajax({
                            'type': 'POST',
                            'url': URL_Query_Link_Create,
                            'cache': false,
                            'data': $("#NewlinksData").serialize(),
                            'success': function (data) {
                                if (data.indexOf('okay') != -1) {
                                    var ROK = '<label><div class="ui-state-highlight ui-corner-all"><p><?php echo \SKT_ADMIN_Message_Update_OK ?><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span></p></div></label>';
                                    $("#server_response_NewlinksData").html(ROK);
                                    var TheUrl = document.URL;
                                    if (TheUrl.toLowerCase().indexOf(Language) == -1) {
                                        TheUrl += Language + '/';
                                    }
                                    AppSKT.ReloadPage(TheUrl);
                                } else {
                                    var RKO = '<label><div class="ui-state-error ui-corner-all"><p><?php echo \SKT_ADMIN_Message_Update_Error ?><span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span></p></div></label>';
                                    $("#server_response_NewlinksData").html(RKO);
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
    <?php
    echo \SKT_ADMIN_AdminWraperClose;
}
?> 