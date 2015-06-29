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
if (\CmsDev\Security\loginIntent::action('validate', 'ContentProp','Edit') === true) {
    if (isset($_POST['IDZone'])) {
        $css_class = isset($_POST['css_class']) ? $_POST['css_class'] : '';
        $CustomProperty = isset($_POST['CustomProperty']) ? $_POST['CustomProperty'] : '';
        $Description = isset($_POST['Description']) ? $_POST['Description'] : '';
        $update = $SKTDB->query(sprintf("UPDATE " . DB_PREFIX . "content Set 
					Date = %s, 
					IDZone = %s, 
					IDPage = %s,
					Type = %s,
					Custom = %s,
					AllPage = %s,
					RecycleBin = %s,
					Position = %s,
					Title = %s,
					Description = %s,
					css_class = %s,
					CustomProperty = %s
					WHERE ID = %s", GetSQLValueString(utf8_decode($_POST['Date']), "date"), GetSQLValueString(utf8_decode($_POST['IDZone']), "text"), GetSQLValueString(utf8_decode($_POST['IDPage']), "int"), GetSQLValueString(utf8_decode($_POST['Type']), "text"), GetSQLValueString($_POST['Custom'], "text"), GetSQLValueString(utf8_decode($_POST['AllPage']), "int"), GetSQLValueString($_POST['RecycleBin'], "int"), GetSQLValueString($_POST['Position'], "int"), GetSQLValueString(utf8_decode($_POST['Title']), "text"), GetSQLValueString(utf8_decode($Description), "text"), GetSQLValueString(utf8_decode($css_class), "text"), GetSQLValueString(utf8_decode($CustomProperty), "text"), GetSQLValueString($_POST['ID'], "int")
        ));

        if ($update) {
            echo '<label><div class="ui-state-highlight ui-corner-all"><p>' . \SKT_ADMIN_Message_Update_OK . '<span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-info"></span></p></div></label>';
            echo '<script type="text/javascript">AppSKT.ReloadPage(\'\');</script>';
        } else {
            echo '<label><div class="ui-state-error ui-corner-all"><p>' . \SKT_ADMIN_Message_Update_Error . '<span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span></p></div></label>';
        }
    } else {
        ?>
        <?php
        $ID = $_POST['ID'];
        $content = $SKTDB->get_row("SELECT ID,Title,Date,IDZone,IDPage,Type,AllPage,RecycleBin,Position,css_class,Description,CustomProperty FROM " . DB_PREFIX . "content WHERE ID = '$ID'");
        ?>
        <?php echo str_replace('[title]', \SKT_ADMIN_ConfigContentTitle, \SKT_ADMIN_AdminWraperOpen); ?>
        <div class="EditFormSection">
            <div id="server_response_ContentProp"></div>
            <form action="" method="post" id="ContentProp">
                <input name="ID" type="hidden" value="<?php echo $content->ID ?>" />
                <input name="IDPage" type="hidden" value="<?php echo $content->IDPage ?>" />
                <div class="skts_content">
                    <div class="SKTrow">
                        <?php
                        $Type = $content->Type;
                        $List_Type = new \CmsDev\CRUD\Xtras\List_Type();
                        //echo $List_Type->Render($Type);
                        //echo $List_Type->NameType($Type);
                        ?>
                        <div class="col first">
                            <fieldset>
                                <legend><?php echo \SKT_ADMIN_TXT_ContentTypeAndProperties ?></legend>
                                <label><span><?php /* \SKT_ADMIN_TXT_TypeContent */ echo ':<b class="color-1" id="ShowTypeContentList">"' . $List_Type->NameType($Type) . '" <i class="skt-iconshuffle-1"></i></b>'; ?></span>
                                    <input name="Type" type="hidden" value="<?php echo $content->Type ?>" />
                                    <div id="TypeContentList" style="display: none;"><?php echo $List_Type->Render($Type); ?></div>
                                </label>
                                <label>
                                    <?php
                                    $ViewCClist = '';
                                    if ($Type == 'SKT_Controls') {
                                        $ViewCClist = 'display:block;';
                                    } else {
                                        $ViewCClist = 'display:none;';
                                    }
                                    ?>
                                    <div style="<?php echo $ViewCClist ?>" id="List_SKT_Controls"><span><?php echo \SKT_ADMIN_TXT_CC_Title ?>:</span>
                                        <?php
                                        $CC = $content->ID;
                                        $List_SKT_Controls = new CmsDev\CRUD\Xtras\List_SKT_Controls();
                                        echo $List_SKT_Controls->Render($CC);
                                        ?>
                                    </div>
                                </label>
                                <label colspan="2"><span><?php echo \SKT_ADMIN_TXT_CSS ?></span>
                                    <input name="css_class" type="text" value="<?php echo $content->css_class ?>" />
                                </label>
                                <label colspan="2"><span><?php echo \SKT_ADMIN_TXT_TitleCustomProperty ?></span>
                                    <input name="CustomProperty" type="text" value="<?php echo $content->CustomProperty ?>" />
                                </label>
                            </fieldset>
                            <fieldset>
                                <legend><?php echo \SKT_ADMIN_RecycleTitle ?></legend>
                                <?php
                                $recycleBinSel = $content->RecycleBin;
                                if ($recycleBinSel == 0) {
                                    $recycle1 = 'checked="checked"';
                                    $recycle2 = '';
                                } else {
                                    $recycle1 = '';
                                    $recycle2 = 'checked="checked"';
                                }
                                ?>

                                <label class="sktContentInline"><span><?php echo \SKT_ADMIN_TXT_ShowContentVisible ?></span>
                                    <input type="radio" name="RecycleBin" <?php echo $recycle1 ?> value="0" id="RecycleBin_0" />
                                </label>
                                <label class="sktContentInline"><span><?php echo \SKT_ADMIN_TXT_ShowContentHidden ?></span>
                                    <input type="radio" name="RecycleBin" <?php echo $recycle2 ?> value="1" id="RecycleBin_1" />
                                </label>
                            </fieldset>
                        </div>
                        <div class="col">
                            <fieldset>
                                <legend><?php echo \SKT_ADMIN_TXT_Section_Config ?></legend>
                                <label><span><?php echo \SKT_ADMIN_TXT_Content_SIDPage ?>:</span>
                                    <?php
                                    $ListParentPage = new \CmsDev\CRUD\Xtras\ListParentPage();
                                    echo $ListParentPage->set($_POST['IDPage']);
                                    ?>
                                </label>
                                <label>
                                    <span><?php echo \SKT_ADMIN_TXT_Zone ?>: <b id="NameZoneSelected">"<?php echo $content->IDZone ?>"</b></span>
                                    <div id="ContentPropListZone"></div>
                                </label>
                                <label><span><?php echo \SKT_ADMIN_TXT_View_AllPagesTitle ?>: </span>
                                    <?php
                                    echo \CmsDev\CRUD\Xtras\List_ThisOrAll_Page::ThisOrAll($content->AllPage);
                                    ?>
                                </label>

                                <label><span><?php echo \SKT_ADMIN_TXT_ZoneOrder ?>:</span>
                                    <?php
                                    $List_Position_Zone = new \CmsDev\CRUD\Xtras\List_Position_Zone();
                                    echo $List_Position_Zone->set($content->Position, $_POST['IDPage'], $content->IDZone);
                                    ?>
                                </label>
                            </fieldset>
                        </div>
                        <div class="clear"></div>
                        <fieldset>
                            <legend><?php echo \SKT_ADMIN_TXT_Section_MetaData ?></legend>
                            <div class="col first">
                                <label><span><?php echo \SKT_ADMIN_TXT_ConfigContentTitle ?>:</span>
                                    <input name="Title" type="text" value="<?php echo utf8_encode($content->Title) ?>" />
                                </label>

                                <label><span><?php echo \SKT_ADMIN_TXT_ConfigContentDate ?>:</span>
                                    <input name="Date" class="datepicker" type="text" value="<?php echo $content->Date ?>" />
                                </label>
                            </div>
                            <div class="col">
                                <label><span><?php echo \SKT_ADMIN_TXT_ConfigContentDescription ?>:</span>
                                    <textarea id="Description" name="Description"><?php echo utf8_encode($content->Description) ?></textarea>
                                </label>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </form>
        </div>
        <div class="clear"></div>
        <?php echo \SKT_ADMIN_AdminWraperClose ?> 
        <script>
            var translations = [];
            translations['Ok'] = SKT_ADMIN_Btn_Acept;
            translations['Create'] = SKT_ADMIN_Btn_Create;
            translations['Cancel'] = SKT_ADMIN_Btn_RestartCancel;
            translations['Delete'] = SKT_ADMIN_Btn_Delete;
            translations['Save'] = SKT_ADMIN_Btn_Save;
            translations['Edit'] = SKT_ADMIN_Btn_Edit;
            var IDContentProp = '<?php echo $content->ID; ?> ';
            $("#dialog-form-Administrator").dialog({
                resizable: true,
                autoOpen: true,
                height: 'auto',
                width: 650,
                title: '<?php echo $List_Type->NameType($Type) . ' - ID:(' . $content->ID. ') ' . $content->Title; ?>',
                maxWidth: 650,
                modal: true,
                buttons: [{
                        text: translations['Cancel'],
                        click: function() {
                            AppSKT.skt_RemoveDialog();
                        }

                    }, {
                        text: translations['Delete'],
                        click: function() {
                            $.ajax({
                                'type': 'POST',
                                'url': URL_QueryDeleteContent,
                                'cache': false,
                                'data': 'ID=' + IDContentProp + '&action=Delete',
                                'success': function(html) {
                                    $('#text-dialog-confirm').html(html);
                                    document.location.reload();
                                }
                            });
                        }
                    }, {
                        text: translations['Edit'],
                        click: function() {
                            $.ajax({
                                'type': 'POST',
                                'url': URL_QueryContentProp,
                                'cache': false,
                                'data': $('form#ContentProp').serialize(),
                                'success': function() {
                                    document.location.reload();
                                }
                            });
                        }
                    }],
                close: function() {
                    AppSKT.skt_RemoveDialog();
                }
            });
            AppSKT.skt_WrapDialog();

            $("#ShowTypeContentList").click(function() {
                $("#TypeContentList").toggle();
            })

            $("select#Type").change(function() {
                var str = $("select#Type option:selected").val();
                if (str == "SKT_Controls") {
                    $("#List_SKT_Controls").css('display', 'block');
                } else {
                    $("#List_SKT_Controls").css('display', 'none');
                }
            })

            $('#ContentPropListZone').append($('#ListZoneColector').html());
            $("#ZoneNewContent select:eq(1)").remove();
            $("#ContentPropListZone select option[value='<?php echo $content->IDZone ?>']").attr('selected', 'selected');
            var NameZoneSelected = $("#ContentPropListZone select option[value='<?php echo $content->IDZone ?>']").html();
            $('#NameZoneSelected').html('"' + NameZoneSelected + '"');
            $(document).ready(function() {
                $(".datepicker").datepicker();
                $("#ui-datepicker-div").wrap('<div class="skt">');
            });
        </script>
        <?php
    }
}
?>
