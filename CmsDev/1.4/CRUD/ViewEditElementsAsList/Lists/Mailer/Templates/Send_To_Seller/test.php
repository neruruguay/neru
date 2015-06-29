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
echo \SKT_ADMIN_AdminWraperOpen;
$SKTDB = \CmsDev\sql\db_Skt::connect();
$data = json_decode(\CmsDev\skt_Code::Decode($_POST['data']));
?>
<div class="CreateContentHtml">
    <form action="" method="post" id="Form_Mailer" style="float: none;">
        <input name="Email_cc" id="Email_to" type="text" class="form-control" value="<?php echo $data->Template_Seller_Email; ?>">
        <input name="Email_Subject" id="Email_Subject" type="text" class="form-control" value="Nuevo pedido de Negocios en Red">
        <input name="POST" id="POST" type="text" class="form-control hidden" value="<?php echo $_POST['data']; ?>">
    </form>
    <div class="PreviewMail">
        <?php
        echo \CmsDev\skt_Code::Parse_Template($data, \CmsDev\skt_Code::Decode($_POST['Template']));
        ?>
    </div>
</div> 
<script type="text/javascript">
    var tips = $(".validateTips");
    $(document).ready(function () {
        setTimeout('MailerHTML()', 1000);
    });

    function  MailerHTML() {
        var translations = [];
        translations['Save'] = SKT_ADMIN_Btn_Save;
        translations['Cancel'] = SKT_ADMIN_Btn_RestartCancel;
        $('.ui-dialog-buttonset button').html(function (i, v) {
            v = v.replace("[Save]", translations['Save']).replace("[Cancel]", translations['Cancel']);
            return v;
        });
    }

    $("#CmsDevDialogContent").dialog({
        autoOpen: true,
        height: ($(window).height() - 50),
        width: 700,
        //position: [0, 0],
        modal: true,
        title: 'Enviar mail al Vendedor',
        buttons: {
            'Enviar': function () {
                var URLUPDATE = '/CRUD/ViewEditElementsAsList/Lists/Mailer/Send_To_Seller';
                jQuery.ajax({
                    'type': 'POST',
                    'url': '/SKTGoTo/' + admd2(URLUPDATE),
                    'cache': false,
                    'data': $("#Form_Mailer").serialize(),
                    'success': function (htmlReturn) {
                        if ($.trim(htmlReturn) === "okay") {
                            AppSKT.skt_RemoveDialog("#CmsDevDialogContent");
                        } else {
                            var RKO = SKT_ADMIN_Message_Update_Error;
                            tips.html(RKO);
                        }
                    }
                });
            },
            '[Cancel]': function () {
                AppSKT.skt_RemoveDialog("#CmsDevDialogContent");
            }
        },
        close: function () {
            AppSKT.skt_RemoveDialog("#CmsDevDialogContent");
        }
    });
    AppSKT.skt_WrapDialog("#CmsDevDialogContent");
</script>

<?php echo \SKT_ADMIN_AdminWraperClose ?> 
