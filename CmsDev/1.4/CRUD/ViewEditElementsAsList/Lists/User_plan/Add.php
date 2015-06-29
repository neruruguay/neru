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
/*
  'bpid' => 'int',
  'UID' => 'int',
  'Limit_Plan' => 'int',
  'planID' => 'int',
  'Date_Finish' => 'text'

 */
$SKTDB = \CmsDev\Sql\db_Skt::connect();
$plans = $SKTDB->get_results("SELECT * FROM plan");
$plansOptions = '';
foreach ($plans as $items) {
    $plansOptions .= '<option value="' . $items->Plan_id . '">' . utf8_encode($items->Plan_Name) . ' Time:' . $items->Plan_Time . ' - Limit:' . $items->Plan_LimitP. '</option>';
}
?>
<div class="CreateContentHtml">
    <form action="" method="post" id="Form_User_plan">
        <input value="Add" name="Add" type="hidden"/>
        <div class="form-group">
            <label>Usuario</label>
            <input name="UID" id="UID" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label>Cantidad de Productos en el Plan</label>
            <input name="Limit_Plan" id="Limit_Plan" type="text" class="form-control">
        </div>
        <div class="form-group">
            <label>Plan</label>
            <select name="planID" id="planID" class="form-control">
                <?php echo $plansOptions; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Expira el:</label>
            <input name="Date_Finish" id="Date_Finish" type="text" class="form-control datepicker" value="<?php echo date('Y-m-d') ?>">
        </div>
        <div class="validateTips"></div>
    </form> 
</div> 

<?php echo \SKT_ADMIN_AdminWraperClose ?> 

<script type="text/javascript">

    $(function () {
        $('.datepicker').datepicker({dateFormat: "yy-mm-dd"});
        $('#ui-datepicker-div').wrap('<div class="skt" />');
    });

    var tips = $(".validateTips");
    $("#CmsDevDialogContent").dialog({
        autoOpen: true,
        width: 400,
        modal: false,
        title: 'Agregar',
        buttons: [{text: translations['Create'],
                click: function () {
                    var URLUPDATE = '/CRUD/ViewEditElementsAsList/Lists/User_plan/_Create';
                    jQuery.ajax({
                        'type': 'POST',
                        'url': '/SKTGoTo/' + admd2(URLUPDATE),
                        'cache': false,
                        'data': $("#Form_User_plan").serialize(),
                        'success': function (htmlReturn) {
                            if ($.trim(htmlReturn) === "okay") {
                                var ROK = SKT_ADMIN_Message_Update_OK;
                                tips.html(ROK);
                                var wrapperid = '#ListViewElementsSKT';
                                $(wrapperid + ' .InputSelectedListid').val('User_plan');
                                var URLLIST = '/CRUD/ViewEditElementsAsList/Lists/User_plan/_Control';
                                jQuery.ajax({
                                    'type': 'POST',
                                    'url': '/SKTGoTo/' + admd2(URLLIST),
                                    'cache': false,
                                    'data': $("form#FormLists", wrapperid).serialize(),
                                    'success': function (success) {
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
                }}, {
                text: translations['Cancel'],
                click: function () {
                    AppSKT.skt_RemoveDialog("#CmsDevDialogContent");
                }
            }],
        close: function () {
            AppSKT.skt_RemoveDialog("#CmsDevDialogContent");
        }
    });
    AppSKT.skt_WrapDialog("#CmsDevDialogContent");
</script>