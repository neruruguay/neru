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

echo str_replace('[title]', 'HTML reusable', \SKT_ADMIN_AdminWraperOpen);

$ID = \GetSQLValueString(\str_replace('ID', '', $_POST['ID']), "int");
$query = $SKTDB->get_row("SELECT ID, Custom, Title, Description, Content FROM " . \DB_PREFIX . "content WHERE ID = '$ID' ");
?>

<div class="container_16">
    <div class="CreateContentHtml">
        <form action="" method="post" id="Form_Templates">
            <input value="Templates_Edit" name="Templates_Edit" type="hidden"/>
            <input value="<?php echo $query->ID; ?>" name="ID" type="hidden"/>
            <input value="<?php echo $query->Custom; ?>" name="Image" type="hidden"/>
            <div class="grid_11">
                <textarea id="TemplatesEditor" name="TemplatesEditor" style="width: 96%; height: 350px;"><?php echo \utf8_encode($query->Content); ?></textarea></div>
            <div class="grid_4">
                <?php
                echo '<label><span>' . \SKT_ADMIN_TXT_Title . '</span><input name="Title" type="text" value="' . \utf8_encode($query->Title) . '"  class="text ui-corner-all" /></label>';
                echo '<label><span>' . \SKT_ADMIN_TXT_Section_Description . '</span><textarea id="Description" name="Description" class="text ui-corner-all" style="height:80px;" >' . \utf8_encode($query->Description) . '</textarea></label>';
                ?>
            </div>
            <div class="clear"></div>
        </form> 
    </div>
    <div class="clear"></div>
</div>  

<?php echo \SKT_ADMIN_AdminWraperClose ?> 

<script type="text/javascript">


    $(document).ready(function() {
        setTimeout('TemplatesScript()', 500);
    });

    function TemplatesScript() {
        var translations = [];
        translations['Save'] = SKT_ADMIN_Btn_Save;
        translations['Cancel'] = SKT_ADMIN_Btn_RestartCancel;
        $('.ui-dialog-buttonset button').html(function(i, v) {
            v = v.replace("[Save]", translations['Save']).replace("[Cancel]", translations['Cancel']);
            return v;
        });
    }

    var tips = $(".validateTips");
    var allFields = '';
    var Title = $("#Form_Templates #Title"),
            Description = $("#Form_Templates #Description"),
            allFields = $([]).add(Title).add(Description),
            tTitle = $("#Form_Templates #Title").prev('span').text(),
            tDescription = $("#Form_Templates #Description").prev('span').text();

    $("#CmsDevDialogContent").dialog({
        autoOpen: true,
        width: 990,
        maxWidth: 990,
        position: ['3%', 55],
        modal: false,
        title: '<i class="icon-skt-script"></i><span><?php echo \SKT_ADMIN_Lists_EditListItemScript ?></span>',
        buttons: {
            '[Save]': function() {
                var bValid = true;
                allFields.removeClass('ui-state-error');
                /* ----------------------------- VALIDATE FIELDS --------------------------------------------------*/
                //bValid = bValid && AppSKT.checkLength(Title, tTitle, 1, 100);
                //bValid = bValid && AppSKT.checkLength(Description, tDescription, 1, 300);
                /* ----------------------------- END VALIDATE FIELDS --------------------------------------------------*/
                if (bValid) {
                    var validating = SKT_ADMIN_Message_Validating;
                    tips.html(validating);
                    var URLUPDATE = '/CRUD/ViewEditElementsAsList/Lists/Templates/_Update';
                    jQuery.ajax({
                        'type': 'POST',
                        'url': 'SKTGoTo/' + admd2(URLUPDATE),
                        'cache': false,
                        'data': $("#Form_Templates").serialize(),
                        'success': function(htmlReturn) {
                            if ($.trim(htmlReturn) === "okay") {
                                var ROK = SKT_ADMIN_Message_Update_OK;
                                tips.html(ROK);
                                var wrapperID = '#ListViewElementsSKT';
                                $(wrapperID + ' .InputSelectedListID').val('Templates');
                                var URLLIST = '/CRUD/ViewEditElementsAsList/Lists/Templates/_Control';
                                jQuery.ajax({
                                    'type': 'POST',
                                    'url': 'SKTGoTo/' + admd2(URLLIST),
                                    'cache': false,
                                    'data': $("form#FormLists", wrapperID).serialize(),
                                    'success': function(success) {
                                        $('#CmsDevTabsContent').html(success);
                                    }
                                });
                                AppSKT.skt_RemoveDialog("#CmsDevDialogContent");
                            } else {
                                var RKO = SKT_ADMIN_Message_Update_Error;
                                tips.html(RKO);
                            }
                        }
                    });
                }
            },
            '[Cancel]': function() {
                AppSKT.skt_RemoveDialog("#CmsDevDialogContent");
            }
        },
        close: function() {
            AppSKT.skt_RemoveDialog("#CmsDevDialogContent");
        }
    });
    AppSKT.skt_WrapDialog("#CmsDevDialogContent");
</script>