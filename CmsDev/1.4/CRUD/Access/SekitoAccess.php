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
if (\CmsDev\Security\loginIntent::action('validate', 'Access', 'Edit') === true) {
    echo str_replace('[title]', $CMSText_ChangeAdminPass, \SKT_ADMIN_AdminWraperOpen);
    ?>
    <div class="container_16">
        <div class="CreateContentHtml">
            <div id="server_response_CmsDevAccessForm"></div>
            <form action="" method="post" id="CmsDevAccessForm">
                <div class="grid_5">&nbsp;</div>
                <div class="grid_6">
                    <?php
                    echo '<h5>' . $CMSText_UserName . ': ' . $userItem->UserName . '</h5><br />';
                    echo '<label><span>' . $CMSText_UserName . '*</span><input name="UserName" type="text" value="' . $userItem->UserName . '" /></label>';
                    echo '<label><span>' . $CMSText_Password . '*</span><input name="Password" type="password" value="" /></label>';
                    echo '<label><span>' . $CMSText_Password2 . '*</span><input name="Password2" type="password" value="" /></label>';
                    ?>
                </div>
                <div class="grid_5">&nbsp;</div>
            </form> 
        </div>
        <div class="clear"></div>
    </div>
    <script type="text/javascript">
        /* ----------------------------- CREATE DIALOG --------------------------------------------------*/
    //	$(function() {
        $("#dialog").dialog("destroy");
        $("#dialog-form-Administrator").dialog({
            autoOpen: true,
            //height: ($(window).height()-90),
            width: 350,
            maxWidth: 990,
            position: ['3%', 55],
            modal: true,
            buttons: {
                'Actualizar': function () {
                    var validating = '<label><div class="ui-state-highlight ui-corner-all"><p><?php echo $CMSText_RefreshIn ?><span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-refresh"></span></p></div></label>';
                    $("#server_response_CmsDevAccessForm").html(validating);
                    jQuery.ajax({
                        'type': 'POST',
                        'url': '_CmsDevquery/CmsDevAccess.php',
                        'cache': false,
                        'data': $("form#CmsDevAccessForm").serialize(),
                        'success': function (html) {
                            if (html == 'ok') {
                                var ROK = '<label><div class="ui-state-highlight ui-corner-all"><p>' + html + '<span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-info"></span></p></div></label>';
                                $("#server_response_CmsDevAccessForm").html(ROK);
                                AppSKT.ReloadPage('<?php echo $subSite ?>/_CmsDevAdmin/?session');
                            } else {
                                var RKO = '<label><div class="ui-state-error ui-corner-all"><p>' + html + '<span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span></p></div></label>';
                                $("#server_response_CmsDevAccessForm").html(RKO);
                            }
                        }
                    });
                    /*  -----------------------------  OK  --------------------------*/
                },
                Cancelar: function () {
                    $('.ui-widget-overlay').remove();
                    $('.cleditorPopup').remove();
                    $('body #dialog-form-Administrator').remove();
                }
            },
            close: function () {
                $('.ui-widget-overlay').remove();
                $('.cleditorPopup').remove();
                $('body #dialog-form-Administrator').remove();
            }
        });
        /* ----------------------------- END CREATE DIALOG --------------------------------------------------*/
    </script>
    <?php
    echo \SKT_ADMIN_AdminWraperClose;
}
?> 
