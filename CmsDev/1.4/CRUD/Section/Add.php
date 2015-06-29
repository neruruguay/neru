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
if (\CmsDev\Security\loginIntent::action('validate', 'Section', 'Add') === true) {
    echo str_replace('[title]', \SKT_ADMIN_TXT_Section_Modal_Title . ' ' . \SKT_SECTION_TITLE, \SKT_ADMIN_AdminWraperOpen);
    ?>
    <div id="server_response_NewSectionData"></div>
    <form action="" method="post" id="NewSectionData">
        <div class="skts_content">
            <div class="SKTrow">
                <div class="col first">
                    <fieldset>
                        <legend><b><?php echo \SKT_ADMIN_TXT_Section_legend ?></b></legend>
                        <?php $SearchURLName = str_replace(\SUBSITE, '', CorrectURL($_POST['RenderURL'])); ?>

                        <input name="SearchURLName" readonly="readonly" type="hidden" value="<?php echo $SearchURLName; ?>" />
                        <input name="RenderURL" readonly="readonly" type="hidden" value="<?php echo CorrectURL($_POST['RenderURL']); ?>" />
                        <input name="RenderSubDir" readonly="readonly" type="hidden" value="<?php echo CorrectURL($_POST['RenderSubDir']); ?>" />
                        <input name="Language" id="Language" type="hidden" value="" />
                        <input name="SystemRequired" type="hidden" value="1" />
                        <input name="SID" type="hidden" value="<?php echo $_POST['IDSections']; ?>" />

                        <label><span><?php echo \SKT_ADMIN_TXT_Title ?>:</span>
                            <input name="Title" type="text" value="" onblur="AppSKT.CheckURLName(this.value, 'URLNameNewSection');"/>
                        </label>
                        <label><span><?php echo \SKT_ADMIN_TXT_URL ?>:<span id="urlNew"></span></span>
                            <input name="URLName" id="URLNameNewSection" type="text" value="" />
                        </label>
                        <label><span><?php echo \SKT_ADMIN_TXT_DisplayOnMenu ?></span>
                            <?php
                            $DisplayOnMenu = new \CmsDev\CRUD\Xtras\List_Menu();
                            echo $DisplayOnMenu->set(1, 1);
                            ?>
                        </label>
                        <label><span><?php echo \SKT_ADMIN_TXT_OrderMenuSection ?>:</span>
                            <?php
                            $List_Position_Section = new \CmsDev\CRUD\Xtras\List_Position_Section();
                            echo $List_Position_Section->set('max', $_POST['IDSections']);
                            ?>
                        </label>  
                    </fieldset>
                </div>
                <div class="col">
                    <fieldset>
                        <legend><b><?php echo \SKT_ADMIN_TXT_Section_Layout ?></b></legend>
                        <label><span><?php echo \SKT_ADMIN_TXT_Select_Theme ?>:</span>
                            <?php
                            $List_Template = new \CmsDev\CRUD\Xtras\List_Template();
                            echo $List_Template->set('Home');
                            ?>
                        </label>
                    </fieldset>
                    <fieldset>
                        <legend><?php echo \SKT_ADMIN_TXT_Section_RecycleBin ?></legend>
                        <label class="sktContentInline"><span><?php echo \SKT_ADMIN_TXT_Section_Show ?></span>
                            <input type="radio" name="RecycleBin"  value="0" id="RecycleBin_0" />
                        </label>
                        <label class="sktContentInline"><span><?php echo \SKT_ADMIN_TXT_Section_Hiden ?></span>
                            <input type="radio" name="RecycleBin" checked="checked"  value="1" id="RecycleBin_1" />
                        </label>
                    </fieldset>
                </div>
                <div class="clear"></div>
                <fieldset>
                    <legend><?php echo \SKT_ADMIN_TXT_Section_Meta_Info ?></legend>
                    <div class="col first">
                        <label><span><?php echo \SKT_ADMIN_TXT_Section_Meta_Title ?>:</span>
                            <input name="Title" type="text" value="<?php echo \SKT_SECTION_METADATATITLE ?>" />
                        </label>

                        <label><span><?php echo \SKT_ADMIN_TXT_Section_Meta_Keywords ?>:</span>
                            <input name="MetaDataKeywords" class="MetaDataKeywords" type="text" value="<?php echo \SKT_SECTION_METADATAKEYWORDS ?>" />
                        </label>
                    </div>
                    <div class="col">
                        <label><span><?php echo \SKT_ADMIN_TXT_Section_Meta_Description ?>:</span>
                            <textarea id="MetaDataDescription" name="MetaDataDescription"><?php echo \SKT_SECTION_METADATADESCRIPTION ?></textarea>
                        </label>
                    </div>
                </fieldset>
            </div>
        </div>
    </form>
    <div class="clear"></div>
    <script type="text/javascript">

        $("#dialog-form-Administrator #Language").val(Language);
        $("#dialog").dialog("destroy");
        var tips = $(".validateTips");
        var allFields = '';
        var Section_Title = $("#Title"),
                Section_URLName = $("#URLNameNewSection"),
                allFields = $([]).add(Section_Title).add(Section_URLName);

        $("#dialog-form-Administrator").dialog({
            autoOpen: true,
            width: 800,
            maxWidth: 800,
            modal: true,
            buttons: {
                'Agregar la nueva seccion': function () {
                    var bValid = true;
                    allFields.removeClass('ui-state-error');

                    /* ----------------------------- VALIDATE FIELDS --------------------------------------------------*/
                    bValid = bValid && AppSKT.checkLength(Section_URLName, "'Direcci&oacute;n de la P&aacute;gina' NO es v&aacute;lida, no puede contener espacios ni caracteres especiales y", 3, 255);

                    bValid = bValid && AppSKT.checkLength(Section_Title, "Nombre la Secci&oacute;n", 3, 255);

                    /* ----------------------------- END VALIDATE FIELDS --------------------------------------------------*/

                    if (bValid) {
                        /*  -----------------------------  IF OK  --------------------------*/

                        var validating = '<label><div class="ui-state-highlight ui-corner-all"><p>' + SKT_ADMIN_Message_Validating + '<span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-refresh"></span></p></div></label>';
                        $("#server_response_NewSectionData").html(validating);
                        jQuery.ajax({
                            'type': 'POST',
                            'url': 'SKTGoTo/' + admd2('/Query/CreateSection'),
                            'cache': false,
                            'data': $("#NewSectionData").serialize(),
                            'success': function (data) {
                                if (data.indexOf('okay') !== -1) {
                                    var ROK = '<label><div class="ui-state-highlight ui-corner-all"><p>' + SKT_ADMIN_Message_Update_OK + '<span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span></p></div></label>';
                                    $("#server_response_NewSectionData").html(ROK);

                                    var TheUrl = document.URL;
                                    //var Section_URLName = "Remates";
                                    if (TheUrl.toLowerCase().indexOf(Language) === -1) {
                                      TheUrl = Language + "/" + Section_URLName+ "/";
                                    }
                                    AppSKT.ReloadPage(TheUrl + $("#URLNameNewSection").val());
                                } else {
                                    var RKO = '<label><div class="ui-state-error ui-corner-all"><p>' + SKT_ADMIN_Message_Update_Error + '<span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span></p></div></label>';
                                    $("#server_response_NewSectionData").html(RKO);
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
    </script> 
    <?php
    echo \SKT_ADMIN_AdminWraperClose;
}
?> 