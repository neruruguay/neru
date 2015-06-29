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
if (\CmsDev\Security\loginIntent::action('validate', 'Section', 'Meta') === true) {
    if (isset($_POST['ID']) && isset($_POST['MetaDataTitle'])) {
        if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
            $update = mysql_query(sprintf("UPDATE " . DB_PREFIX . "sections Set MetaDataTitle = %s, MetaDataDescription = %s, MetaDataKeywords = %s WHERE ID = %s", GetSQLValueString($_POST['MetaDataTitle'], "text"), GetSQLValueString($_POST['MetaDataDescription'], "text"), GetSQLValueString($_POST['MetaDataKeywords'], "text"), GetSQLValueString($_POST['ID'], "int")
            ));
            if ($update) {
                echo '<i class="skt-icon-success text-success"></i><span>Actualizaci&oacute;n realizada con &eacute;xito!</span>';
            } else {
                echo '<i class="skt-icon-frown text-warning"></i><span>Ha ocurrido un error, por favor actualice la pagina [F5]</span>';
            }
        }
    } else {
        $SectionMetaData = $SKTDB->get_row("SELECT ID,MetaDataTitle,MetaDataDescription,MetaDataKeywords FROM " . DB_PREFIX . "sections WHERE ID = '" . \SKT_SECTION_ID . "'");
        ?>
        <div class="EditFormSection">
            <div id="server_response_SectionMetaData"></div>
            <form action="" method="post" id="SectionMetaData">
                <input name="ID" type="hidden" value="<?php echo $SectionMetaData->ID ?>" />
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr class="nohover">
                        <td colspan="2"><span><?php echo \SKT_ADMIN_TXT_Section_Meta_Title ?></span></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input name="MetaDataTitle" type="text" value="<?php echo utf8_decode($SectionMetaData->MetaDataTitle) ?>" />
                        </td>
                    </tr>
                    <tr class="nohover">
                        <td colspan="2"><span><?php echo \SKT_ADMIN_TXT_Section_Meta_Description ?></span></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <textarea name="MetaDataDescription" cols="" rows="" ><?php echo utf8_decode($SectionMetaData->MetaDataDescription) ?></textarea>
                        </td>
                    </tr>
                    <tr class="nohover">
                        <td colspan="2"><span><?php echo \SKT_ADMIN_TXT_Section_Meta_Keywords ?></span></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <textarea name="MetaDataKeywords" cols="" rows="" ><?php echo utf8_decode($SectionMetaData->MetaDataKeywords) ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"  style="padding-top: 20px;">
                            <button id="SubmitFormSectionMetaData" class="CmsDevEditButton CmsDevUpdateElement ui-button ui-widget ui-corner-all ui-state-hover" type="button" ><i class="skt-icon-ok-circled2"></i><?php echo \SKT_ADMIN_Btn_Acept ?></button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <script type="text/javascript">
            $('#SubmitFormSectionMetaData').click(function () {
                $('#TogglePageConfig #server_response_SectionData').html('<i class="skt-iconspin1 animate-spin"></i>');
                $.ajax({
                    'type': 'POST',
                    'url': URL_QuerySectionMeta,
                    'cache': false,
                    'data': $("form#SectionMetaData").serialize(),
                    'success': function (html) {
                        $('#TogglePageConfig #server_response_SectionData').html('<i class="skt-icon-tags text-success"></i><span>' + html + '</span>');
                    }
                });
                return false;
            });
        </script>
    <?php
    }
}
?>
