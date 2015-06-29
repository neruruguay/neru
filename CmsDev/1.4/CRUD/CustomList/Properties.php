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
$glob = \CmsDev\util\globals::init();
$SKT = $glob->getVar('SKT');
$SKT_ADMIN = $glob->getVar('SKTADMIN');
$SKTListFieldType = $SKT['SKTListFieldType'];
$SKTListFieldSize = $SKT['SKTListFieldSize'];

function ListField($field) {
    if ($field !== null && $field !== '' && $field !== 'undefined') {
        $fieldtrue = explode('|', $field);
        return utf8_encode($fieldtrue[1]);
    }
}

function ListFieldType($field) {
    if ($field !== null && $field !== '' && $field !== 'undefined') {
        $fieldtrue = explode('|', $field);
        return $fieldtrue[0];
    }
}

$Lists_Fields = $SKTDB->get_row("SELECT IDLists, Field1, Field2, Field3, Field4, Field5, Field6, Field7, Field8, Field9, Field10, Field11, Field12, Field13, Field14, Field15, Field16, Field17, Field18, Field19, Field20, Field21, Field22, Field23, Field24, Field25, Field26, Field27, Field28, Field29, Field30, Field31, Field32, Field33, Field34, Field35, Field36, Field37, Field38, Field39, Field40 FROM lists_fields WHERE IDLists = '$_POST[InputSelectedListID]'");
$ListsName = $SKTDB->get_row("SELECT * FROM lists WHERE ID = " . GetSQLValueString($Lists_Fields->IDLists, 'int'));


?>


<form action="" method="get" name="PropertiesList" id="PropertiesList">
    <div class="grid_16">
        <div class="panel panel-default">

            <div class="panel-body">
                <input name="IDLists" id="IDLists" type="hidden" value="<?php echo $Lists_Fields->IDLists ?>" />
                <h3>Campos disponibles</h3>
                <hr>
                <div class="row row-border table table-striped">
                    <div class="col-md-12" id="ListaCampos">
                        <?php
                        $count = 0;
                        for ($i = 1; $i < $SKTListFieldSize + 1; $i++) {
                            $Field_Type_Field = 'Field_Type_Field' . $i;
                            $FieldName = 'Field' . $i;
                            $Field_Type_Opt = 'Field_Opt' . $i;
                            ?>  
                            <div class="col-md-12 item" style="border: 1px dotted #C5C5C5; padding:5px 5px 0px 5px;">
                                <div id="field<?php echo $i; ?>" itemid="<?php echo $i; ?>">
                                    <div class="col-md-2">
                                        <label><span><?php echo \SKT_ADMIN_TXT_Field . $i; ?></span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input style="width: 100%; max-width: 100%;" name="<?php echo $FieldName; ?>" type="text" size="30" maxlength="100" value="<?php echo ListField($Lists_Fields->$FieldName) ?>" class="form-control"/>
                                    </div>
                                    <div class="col-md-3">
                                        <?php echo select_field('Field_Type_Field' . $i, 'Field_Type_Field' . $i, $SKTListFieldType, ListFieldType($Lists_Fields->$FieldName)); ?>
                                    </div>
                                    <div class="col-md-3">
                                        <input style="width: 100%; max-width: 100%;" name="<?php echo $Field_Type_Opt; ?>" id="<?php echo $Field_Type_Opt; ?>" value="" type="text" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if (ListField($Lists_Fields->$FieldName) != '') {
                                $count++;
                            }
                        }
                        ?>
                        <div class="clear"></div>
                        <hr>
                        <div class="margin margin-t">
                            <div id="LessField" class="btn btn-danger"><i class="skt-icon-minus-squared"></i> Quitar el &Uacute;ltimo campo</div>
                            <div id="AddMoreField" class="btn btn-info"><i class="skt-icon-plus-squared"></i> Agregar otro campo</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="margin margin-t"><hr>
                            <div class="validateTips"></div>
                            <button class="btn btn-link" name="SubmitForm_Delete_List" id="SubmitForm_Delete_List" type="button" style="color:#dc322f;"><i class="skt-icon-delete"></i><span style="vertical-align: super;"><?php echo \SKT_ADMIN_Btn_Delete ?></span></button>
                            <button class="btn btn-primary" name="SubmitForm_List_Edit_Properties" id="SubmitForm_List_Edit_Properties" type="button" style="color:white; float: right" ><i class="skt-icon-acept"></i><span style="vertical-align: super;"><?php echo \SKT_ADMIN_Btn_Edit ?></span></button>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="margin margin-t"><hr>
                            <h3>Acceso url de los datos</h3>
                            <hr>
                            <div class="row row-border table table-striped">
                                <div class="col-md-12">
                                    <div style="position: relative" class="form-group">
                                        <label>JSon</label>
                                        <input class="form-control" type="text" style="padding-left: 55px;" value="<?php echo \SERVER_DIR . \SKTURL ?>_Service_/p/Lists/getJSON/<?php echo $ListsName->ListName ?>|ASC|datePost|5|null|null" >
                                        <a href="javascript:void(0);" class="skt-icon-link btn btn-default" target="_blank"  style="position: absolute;top:19px;"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div> 
        </div>
    </div>
</form>
<div class="clear"></div>
<script type="text/javascript">
    var FieldsShow = <?php echo $count ?>;

    $('#ListaCampos > .item:gt(' + FieldsShow + ')').hide();

    $('#ListaCampos #AddMoreField').click(function () {
        FieldsShow = FieldsShow + 1;
        $('#ListaCampos > .item:eq(' + FieldsShow + ')').show();
    });

    $('#ListaCampos #LessField').click(function () {
        $('#ListaCampos > .item:eq(' + FieldsShow + ')').hide();
        FieldsShow = FieldsShow - 1;
    });
    $("a.skt-icon-link").click(function () {
        var link = $(this).prev('input').val();
        $(this).attr('href', link);
        $(this).trigger("click");
    });
    
    $("#SubmitForm_Delete_List").click(function () {
        var Delete_List = confirm("Confirmar borrar lista.");
        if (Delete_List == true) {
            CustomListSKT.Deletelist(<?php echo $Lists_Fields->IDLists ?>);
        } 
    });    
    $('#SubmitForm_List_Edit_Properties').click(function () {
        jQuery.ajax({
            'type': 'POST',
            'url': URL_Query_List_Edit_Properties,
            'cache': false,
            'data': $("form#PropertiesList", "#dialog-form-Administrator").serialize(),
            'success': function (success_List_Edit_Properties) {
                if ($.trim(success_List_Edit_Properties) === "okay") {
                    jQuery.ajax({
                        'type': 'POST',
                        'url': URL_View_List_Properties,
                        'cache': false,
                        'data': $("form#FormLists", "#dialog-form-Administrator").serialize(),
                        'success': function (success_List_Properties) {
                            $('#CmsDevTabsContent').html(success_List_Properties);
                        }
                    });
                } else {
                    var RKO = '<label><div class="ui-state-error ui-corner-all"><p>' + SKT_ADMIN_Message_Update_Error + '<span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span></p></div></label>';
                    $('.validateTips').html(RKO);
                }
            }
        });
    });
</script> 
