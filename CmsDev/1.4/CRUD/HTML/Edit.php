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
if (\CmsDev\Security\loginIntent::action('validate','HTML','Edit') === true) {
    $ID = $_POST['ID'];
    $content = $SKTDB->get_row("SELECT * FROM " . DB_PREFIX . "content WHERE ID = '$ID'");
    ?>
    <?php echo str_replace('[title]', \SKT_ADMIN_EditHTMLText, \SKT_ADMIN_AdminWraperOpen); ?>
    <form action="" method="post" id="FormEditHTML">
        <div class="skts_content">
            <div id="server_response_CreateContentHtml"></div>
            <div class="SKTrow row">
                <div class="col-md-8 first">
                    <textarea id="CreateContentEditor" name="editor" class="Richfield<?php echo $ID; ?>"><?php echo $content->Content ?></textarea>
                </div>
                <div class="col-md-4 last">
                    <fieldset>
                        <label>
                            <span><?php echo \SKT_ADMIN_TXT_TitleContent ?></span>
                            <input name="ID" type="hidden" value="<?php echo $content->ID ?>" />
                            <input name="Title" type="text" value="<?php echo $content->Title ?>" />
                            <input name="Date" type="hidden" value="<?php echo date('Y-m-d') ?>" />
                            <input name="IDPage" readonly="readonly" type="hidden" value="<?php echo $content->IDPage ?>" />
                            <input name="Custom" readonly="readonly" type="hidden" value="<?php echo $content->CustomProperty ?>" />
                            <input name="Type" type="hidden" value="html" />
                        </label>
                        <div class="clear"></div>
                        <label>
                            <span><?php echo \SKT_ADMIN_TXT_View_AllPagesTitle ?>: </span>
                            <?php
                            echo \CmsDev\CRUD\Xtras\List_ThisOrAll_Page::ThisOrAll($content->IDPage);
                            ?>
                        </label>
                        <label>
                            <span><?php echo \SKT_ADMIN_TXT_IDZoneContent ?>:</span>
                            <div id="ZoneNewContent"></div>  
                        </label>
                        <label>
                            <span><?php echo \SKT_ADMIN_TXT_ZoneOrder ?>:</span>
                            <?php
                            echo \CmsDev\CRUD\Xtras\List_Position_Zone::set($content->Position, $content->IDPage, $content->IDZone);
                            ?>
                        </label>
                    </fieldset>
                    <?php echo \CmsDev\CRUD\Xtras\Radio_RecycleBin::OptionGroup($content->RecycleBin, 0); ?>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </form>

    <script type="text/javascript">
        var translations = [];
        translations['Ok'] = SKT_ADMIN_Btn_Acept;
        translations['Create'] = SKT_ADMIN_Btn_Create;
        translations['Cancel'] = SKT_ADMIN_Btn_RestartCancel;
        translations['Delete'] = SKT_ADMIN_Btn_Delete;
        translations['Save'] = SKT_ADMIN_Btn_Save;
        translations['Edit'] = SKT_ADMIN_Btn_Edit;
        var IDContentProp = '<?php echo $content->ID; ?> ';

        setTimeout(function () {
            AppSKT.CreateContentEditor({
                'Element': '.Richfield<?php echo $content->ID; ?>',
                'width': '99%',
                'height': '330px',
                'colors': '<?php echo \SKT_EDITOR_COLORS; ?>',
                'fonts': '<?php echo \SKT_EDITOR_FONTS ?>',
                'bodyStyle': '<?php echo \SKT_EDITOR_BODY ?>',
                'docCSSFile': '<?php echo \SKTURL_TemplateSite ?>/css/style.css'
            });
        }, 1000);

        $("#ZoneNewContent").append($('#ListZoneColector').html());
        $("#ZoneNewContent select option[value='<?php echo $content->IDZone ?>']").attr('selected', 'selected');
        $("#ZoneNewContent select:eq(1)").remove();

        $("#dialog").dialog("destroy");
        $("#dialog-form-Administrator").dialog({
            autoOpen: true,
            width: 990,
            maxWidth: 990,
            position: ['3%', 55],
            modal: true,
            buttons: [{
                    text: translations['Cancel'],
                    click: function () {
                        AppSKT.skt_RemoveDialog();
                    }
                }, {
                    text: translations['Edit'],
                    click: function () {
                        $.ajax({
                            'type': 'POST',
                            'url': URL_QueryUpdateContent,
                            'cache': false,
                            'data': $('form#FormEditHTML').serialize(),
                            'success': function () {
                                //document.location.reload();
                                AppSKT.ReloadPage();
                            }
                        });
                    }
                }],
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