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
if (\CmsDev\Security\loginIntent::action('validate', 'Section', 'Data') === true) {
    if (isset($_POST['Home']) && isset($_POST['Title'])) {

        if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
            $update = mysql_query(sprintf("UPDATE " . DB_PREFIX . "sections Set 
					Title = %s
					WHERE ID = %s", GetSQLValueString(utf8_decode($_POST['Title']), "text"), GetSQLValueString($_POST['Home'], "int")
            ));
            if ($update) {
                echo '<i class="skt-icon-page-properties  text-success"></i> <i class="skt-icon-success text-success"></i><span>' . \SKT_ADMIN_Message_Update_OK . '</span>';
            } else {
                echo '<i class="skt-icon-frown text-warnong"></i><span>' . \SKT_ADMIN_Message_Update_Error . '</span>';
            }
        }
    } elseif (isset($_POST['ID']) && isset($_POST['URLName'])) {

        if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {

            $RenderURL = isset($_POST['RenderURL']) ? $_POST['RenderURL'] : \SUBSITE;
            $RenderSubDir = isset($_POST['RenderSubDir']) ? $_POST['RenderSubDir'] : \LOCAL_FILESYSTEM_SECTION;
            $TOTAL_REQUEST = isset($_POST['TOTAL_REQUEST']) ? $_POST['TOTAL_REQUEST'] : \TOTAL_REQUEST;
            $DisplayOnMenu = isset($_POST['DisplayOnMenu']) ? $_POST['DisplayOnMenu'] : 1;
            $LinkActive = isset($_POST['LinkActive']) ? $_POST['LinkActive'] : 0;
            $urlNew = '';
            $URLName = strtolower($_POST['URLName']);
            $Description = isset($_POST['Description']) ? $_POST['Description'] : '';

            $SectionOld = $SKTDB->get_var("SELECT URLName FROM " . DB_PREFIX . "sections WHERE ID = '$_POST[ID]'");
            $IDPageOld = $SKTDB->get_var("SELECT SID FROM " . DB_PREFIX . "sections WHERE ID = '$_POST[ID]'");
            $IDPage = isset($_POST['IDPage']) ? $_POST['IDPage'] : $IDPageOld;

            $update = mysql_query(sprintf("UPDATE " . DB_PREFIX . "sections Set 
					Title = %s, 
					Description = %s, 
					URLName = %s, 
					Language = %s,
					Template = %s,
					Position = %s,
					RecycleBin = %s,
					DisplayOnMenu = %s,
					LinkActive = %s,
					SID = %s
					WHERE ID = %s", GetSQLValueString(utf8_decode($_POST['Title']), "text"), GetSQLValueString(utf8_decode($Description), "text"), GetSQLValueString($URLName, "text"), GetSQLValueString($_POST['Language'], "text"), GetSQLValueString($_POST['Template'], "text"), GetSQLValueString($_POST['Position'], "int"), GetSQLValueString($_POST['RecycleBin'], "text"), GetSQLValueString($DisplayOnMenu, "int"), GetSQLValueString($LinkActive, "text"), GetSQLValueString($IDPage, "int"), GetSQLValueString($_POST['ID'], "int")
            ));

            if ($update) {
                echo '<i class="skt-icon-success text-success"></i><span>' . \SKT_ADMIN_Message_Update_OK . '</span>';

                $Language = $SKTDB->get_var("SELECT Language FROM " . DB_PREFIX . "sections WHERE ID = '$_POST[ID]'");

                $RenderURL = isset($_POST['RenderURL']) ? $_POST['RenderURL'] : \SUBSITE;
                $RenderSubDir = isset($_POST['RenderSubDir']) ? $_POST['RenderSubDir'] : \LOCAL_FILESYSTEM_SECTION;

                /* ----------------------------------------------------------- */

                $SectionOldName = $RenderSubDir;
                $SectionDir = str_replace($SectionOld, $URLName, $RenderSubDir);
                $TOTAL_REQUEST = str_replace($SectionOld, $URLName, $TOTAL_REQUEST);

                //echo $SectionDir;
                if (is_dir($SectionOldName)) {
                    chmod($SectionOldName, 0755);
                    rename($SectionOldName, $SectionDir);
                } else {
                    mkdir($SectionDir, 0755, true);
                    chmod($SectionDir, 0755);
                }

                $urlNew = '<a href=\"' . $TOTAL_REQUEST . '\">' . $URLName . '</a>';
                //alert("'.$SectionOldName.'");alert("'.$SectionDir.'");
                //echo '<script type="text/javascript">AppSKT.ReloadPage("' . $TOTAL_REQUEST . '");</script>';
                echo '<script type="text/javascript">$("#urlNew").html("' . $urlNew . '");</script>';
            } else {
                echo '<i class="skt-icon-frown text-warning></i><span>' . \SKT_ADMIN_Message_Update_Error . '</span>';
            }
        }
    } else {

        // if Product section
        if (\SKT_SECTION_PID != '') {
            $HiddenOnProduct = 'style="display:none!important;"';
        } else {
            $HiddenOnProduct = '';
        }
        ?>    

        <div class="EditFormSection">
            <form action="" method="post" id="SectionData">
                <input name="RenderURL"  id="RenderURL" type="hidden" value="<?php echo \SUBSITE ?>" />
                <input name="RenderSubDir"  id="RenderSubDir" type="hidden" value="<?php echo \LOCAL_FILESYSTEM_SECTION ?>" />
                <input name="ID" type="hidden" value="<?php echo \SKT_SECTION_ID ?>" />
                <input name="TOTAL_REQUEST" type="hidden" value="<?php echo \TOTAL_REQUEST ?>" />
                <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
                    <tr class="nohover">
                        <td colspan="3"><span><?php echo \SKT_ADMIN_TXT_Section_Title ?>: <?php echo \SKT_SECTION_URLNAME ?></span></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <?php if (\SKT_SECTION_SID === '0') { ?><input name="Home" id="Home" type="hidden" value="<?php echo \SKT_SECTION_ID ?>" /><?php } ?>
                            <input name="Title" id="Title" type="text" value="<?php echo \SKT_SECTION_TITLE ?>" onBlur="javascript:AppSKT.CheckURLName(this.value, 'URLName')" />
                        </td>
                    </tr>
                    <?php if (\SKT_SECTION_SID != '0' or \SKT_SECTION_SYSTEMREQUIRED != '2') { ?>


                        <tr class="nohover">
                            <td colspan="3"><span><?php echo \SKT_ADMIN_TXT_Section_URL ?>:<span id="urlNew"></span></span></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <input name="URLName" id="URLName" type="text" value="<?php echo \SKT_SECTION_URLNAME ?>" />
                            </td>
                        </tr>
                        <tr class="nohover">
                            <td colspan="3"><span><?php echo \SKT_ADMIN_TXT_Section_Description ?>:</span></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <textarea name="Description" id="Description" cols="50" rows="3"><?php echo \SKT_SECTION_DESCRIPTION ?></textarea>
                            </td>
                        </tr>
                        <tr class="nohover" <?php echo $HiddenOnProduct ?> >
                            <td colspan="3"><span><?php echo \SKT_ADMIN_TXT_Language ?>:</span></td>
                        </tr>
                        <tr <?php echo $HiddenOnProduct ?> >
                            <td colspan="3">
                                <input name="Language" type="text" value="<?php echo \SKT_SECTION_LANGUAGE ?>" />
                            </td>
                        </tr>
                        <tr class="nohover" <?php //echo $HiddenOnProduct        ?> >
                            <td colspan="3"><span><?php echo \SKT_ADMIN_TXT_Section_Parent ?>:</span></td>
                        </tr>
                        <tr <?php //echo $HiddenOnProduct       ?> >
                            <td colspan="3">
                                <?php
                                $ListParentPage = new \CmsDev\CRUD\Xtras\ListParentPage();
                                echo $ListParentPage->set(\SKT_SECTION_SID);
                                ?>
                            </td>
                        </tr>


                        <tr class="nohover" <?php echo $HiddenOnProduct ?> >
                            <td colspan="3"><span><?php echo \SKT_ADMIN_TXT_Select_Theme ?>:</span></td>
                        </tr>

                        <tr <?php echo $HiddenOnProduct ?> >
                            <td colspan="3">
                                <?php
                                $templateSelect = \SKT_SECTION_TEMPLATE;
                                $List_Template = new \CmsDev\CRUD\Xtras\List_Template();
                                echo $List_Template->set($templateSelect);
                                ?>
                            </td>
                        </tr>


                    </table>
                    <table width="48%" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-left: 3%;">
                        <tr>
                            <td colspan="3">
                                <input name="SectionImage" id="SectionImage" type="hidden" value="<?php echo \SKT_SECTION_SECTIONIMAGE ?>" />
                                <div id="DeleteImageSection" title="Quitar Imagen"></div><div id="SectionImageIMG">
                                    <?php
                                    if (\SKT_SECTION_SECTIONIMAGE != '') {
                                        echo '<img src="' . \SKTURL_FileSystems . 'images/' . \SKT_SECTION_SECTIONIMAGE . '" alt=""/>';
                                    }
                                    ?>
                                </div>
                                <span><?php echo \SKT_ADMIN_TXT_Section_Image ?><span id="RQdataImg"></span></span>
                                <div id="file-uploader">
                                    <noscript>
                                    <p>Lo sentimos, para cargar el archivo es necesario tener java activado en su navegador.<br />
                                        Recomendamos como navegador: IExplorer > 8, Firefox o Chrome.</p>
                                    </noscript>
                                </div>
                                <script>
                                    /* ----------------------------- UPLOAD --------------------------------------------------*/
                                    var uploader = new qq.FileUploader({
                                        element: document.getElementById('file-uploader'),
                                        action: 'SKTGoTo/' + admd2('fileuploader/SectionUpload.php?SessionURLSection=<?php echo \SKT_SECTION_URLNAME ?>'),
                                        multiple: true,
                                        sizeLimit: 1024000,
                                        allowedExtensions: ['jpg', 'png', 'gif'],
                                        onComplete: function (id, fileName, responseJSON) {
                                            $("#SectionImageIMG").html('');
                                            $('.qq-upload-list').html('');
                                            $("#SectionImageIMG").html('<img src="./_FileSystems/images/' + responseJSON["filename"] + '?r=' + Math.floor(Math.random() * 4) + '" alt=""/>');
                                            $("#SectionImage").val(responseJSON["filename"]);
                                            $('#TogglePageConfig #server_response_SectionData').html('<i class="skt-iconpicture-2"></i><span>' + SKT_ADMIN_Message_Upload_Image + '</span>');
                                            $.ajax({
                                                'type': 'POST',
                                                'url': 'SKTGoTo/' + admd2('Query/UpdateSectionImage'),
                                                'cache': false,
                                                'data': 'ID=<?php echo \SKT_SECTION_ID ?>&SectionImage=' + responseJSON["filename"],
                                                'success': function (RQdata) {
                                                    $("#RQdataImg").html(RQdata);
                                                }
                                            });

                                        }
                                    });

                                    $("#DeleteImageSection").click(function () {
                                        $('#TogglePageConfig #server_response_SectionData').html('<i class="skt-iconspin1 animate-spin"></i>');

                                        $.ajax({
                                            'type': 'POST',
                                            'url': 'SKTGoTo/' + admd2('Query/UpdateSectionImage'),
                                            'cache': false,
                                            'data': 'ID=<?php echo \SKT_SECTION_ID ?>&SectionImage=Null',
                                            'success': function (RQdata) {
                                                $('#TogglePageConfig #server_response_SectionData').html('<i class="skt-iconpicture-2"></i><span>' + SKT_ADMIN_Message_Delete_Image + '</span>');
                                                $('.qq-upload-list').html('');
                                                $('#RQdataImg').html('');
                                                $('#SectionImageIMG').html('');
                                                $("#SectionImage").val('');
                                            }
                                        });
                                    });

                                </script> 
                            </td>
                        </tr>

                        <tr class="nohover" <?php echo $HiddenOnProduct ?> >
                            <td colspan="3"><span><?php echo \SKT_ADMIN_TXT_OrderMenuSection ?>:</span></td>
                        </tr>
                        <tr <?php echo $HiddenOnProduct ?> >
                            <td colspan="3">
                                <?php
                                $List_Position_Section = new \CmsDev\CRUD\Xtras\List_Position_Section();
                                echo $List_Position_Section->set(\SKT_SECTION_POSITION, \SKT_SECTION_SID);
                                ?>
                            </td>
                        </tr>
                        <tr class="nohover" <?php echo $HiddenOnProduct ?> >
                            <td colspan="3"><span><?php echo \SKT_ADMIN_TXT_DisplayOnMenu ?></span></td>
                        </tr>
                        <tr <?php echo $HiddenOnProduct ?> >
                            <td colspan="3">
                                <?php
                                $List_Menu = new \CmsDev\CRUD\Xtras\List_Menu();
                                echo $List_Menu->set(\SKT_SECTION_DISPLAYONMENU);
                                ?>
                            </td>
                        </tr>
                        <tr <?php echo $HiddenOnProduct ?> >
                            <td colspan="2">
                                <?php
                                if (\SKT_SECTION_LINKACTIVE == 1) {
                                    $LinkActiveC = 'checked';
                                } else {
                                    $LinkActiveC = '';
                                }
                                ?>
                                <span><?php echo \SKT_ADMIN_TXT_LinkActive ?></span></td>
                            <td width="42%" align="left">
                                <input name="LinkActive" type="checkbox" value="1" <?php echo $LinkActiveC ?>>
                            </td>
                        </tr>

                        <?php
                        $recycleBinSel = \SKT_SECTION_RECYCLEBIN;
                        if ($recycleBinSel == 0) {
                            $recycle1 = 'checked="checked"';
                            $recycle2 = '';
                        } else {
                            $recycle1 = '';
                            $recycle2 = 'checked="checked"';
                        }
                        ?>

                        <tr>
                            <td colspan="2"><span><?php echo \SKT_ADMIN_TXT_Section_Show ?></span></td>
                            <td align="left">
                                <input type="radio" name="RecycleBin" <?php echo $recycle1 ?> value="0" id="RecycleBin_0" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><span><?php echo \SKT_ADMIN_TXT_Section_Hiden ?></span></td>
                            <td align="left">
                                <input type="radio" name="RecycleBin" <?php echo $recycle2 ?> value="1" id="RecycleBin_1" />
                            </td>
                        </tr>
                    <?php } ?>
                    <tr class="nohover">
                        <?php if (\SKT_SECTION_SID != '0' or \SKT_SECTION_SYSTEMREQUIRED != '2') { ?>
                            <td style="padding-top: 20px;">
                                <button type="button"  rel="<?php echo \SKT_SECTION_ID ?>" name="DeleteSection" id="DeleteSection" class="CmsDevEditButton ui-button ui-widget ui-state-error ui-corner-all CmsDevDeleteElement" ><i class="skt-icon-close"></i><?php echo \SKT_ADMIN_Btn_DeleteSection ?></button>
                            </td>
                        <?php } ?>
                        <td colspan="2" style="padding-top: 20px;">
                            <button name="SubmitFormSection" id="SubmitFormSection" class="CmsDevEditButton CmsDevUpdateElement ui-button ui-widget ui-corner-all ui-state-hover " type="button" ><i class="skt-icon-ok-circled2"></i><?php echo \SKT_ADMIN_Btn_Acept ?></button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

    <?php } ?>
    <script type="text/javascript">
        $(document).ready(function () {

            $('#SubmitFormSection').click(function () {
                $('#TogglePageConfig #server_response_SectionData').html('<i class="skt-iconspin1 animate-spin"></i>');

                $.ajax({
                    'type': 'POST',
                    'url': URL_QuerySectionData,
                    'cache': false,
                    'data': $("form#SectionData").serialize(),
                    'success': function (html) {
                        $("#TogglePageConfig #server_response_SectionData").html(html);
                    }
                });
                return false;
            });

            $("#DeleteSection")
                    .click(function () {
                        var ID = $(this).attr('rel');
                        $("#dialog-confirm").dialog({
                            resizable: false,
                            height: 'auto',
                            modal: true,
                            buttons: {
                                "<?php echo \SKT_ADMIN_Btn_DeleteSection ?>": function () {
                                    jQuery.ajax({
                                        'type': 'POST',
                                        'url': '<?php echo \URL_VERSION ?>Query/DeleteSection.php',
                                        'cache': false,
                                        'data': 'ID=' + ID + '&folder=<?php echo addslashes(\LOCAL_FILESYSTEM_SECTION) ?>',
                                        'success': function (html) {
                                            $("#dialog-confirm span#text-dialog-confirm").html(html);
                                            $('.ui-dialog-buttonset').remove();
                                            var countdown = 1;
                                            $("#dialog-confirm #countdown").html('<?php echo \SKT_ADMIN_Reloading ?>' + countdown);
                                            setInterval(function () {
                                                countdown = countdown - 1;
                                                $("#dialog-confirm #countdown").html('<?php echo \SKT_ADMIN_Reloading ?>' + countdown);
                                            }, 1000);
                                            var reloader = setTimeout("AppSKT.ReloadPage('<?php echo str_replace('/' . \THIS_URL_REAL, '', \TOTAL_REQUEST) ?>')", 1);
                                        }
                                    });
                                },
    <?php echo \SKT_ADMIN_Btn_RestartCancel ?>: function () {
                                    AppSKT.skt_RemoveDialog();
                                }
                            }
                        });
                        AppSKT.skt_WrapDialog();
                    });

        });
    </script> 
<?php } ?>