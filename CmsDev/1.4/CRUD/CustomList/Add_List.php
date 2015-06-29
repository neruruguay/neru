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
?>

<div style="max-width: 960px;">
    <?php

    function ListField($field) {
        $fieldtrue = explode('|', $field);
        return $fieldtrue[1];
    }

    function ListFieldType($field) {
        $fieldtrue = explode('|', $field);
        return $fieldtrue[0];
    }
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Agregar Lista</h3>
        </div>
        <div class="panel-body">


            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style=" font-size: 14px; color: #FF1263;" colspan="2">Campos Auto-generados</td>
                    </tr>
                    <tr class="even">
                        <td>ID</td>
                        <td>(int)</td>
                    </tr>
                    <tr class="odd">
                        <td>IDLists</td>
                        <td>(int)</td>
                    </tr>
                    <tr class="even">
                        <td>RecycleBin</td>
                        <td>(enum = '0','1')</td>
                    </tr>
                    <tr class="odd">
                        <td>Position</td>
                        <td>(int)</td>
                    </tr>
                    <tr class="odd">
                        <td>datePost</td>
                        <td>(date)</td>
                    </tr>
                </tbody>
            </table>

            <form action="" method="post" name="Add_List_Form" id="Add_List_Form">
                <table border="0" align="center" cellpadding="0" cellspacing="0"  class="table table-striped">
                    <thead>
                        <tr class="alert alert-info">
                            <th align="right" valign="middle"><b>Nombre de la lista</b></th>
                            <th valign="middle"><input name="ListName" id="ListName" type="text" size="30" maxlength="100" value="" placeholder="Escriba aqu&aacute; el nombre de la lista"  class="form-control btn-lg"/></th>
                            <th valign="middle"><?php echo \SKT_ADMIN_TXT_Field_Type; ?></th>
                            <th valign="middle"><?php echo \SKT_ADMIN_TXT_OptionalEnumListValue; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 1; $i < $SKTListFieldSize + 1; $i++) {
                            $Add_Field_Type_Field = 'Field_Type_Field' . $i;
                            $Add_FieldName = 'Field' . $i;
                            $Add_Field_Type_Opt = 'Field_Opt' . $i;
                            ?>  
                            <tr id="field<?php echo $i; ?>" itemid="<?php echo $i; ?>">
                                <td align="right" valign="middle"><label><span><?php echo \SKT_ADMIN_TXT_Field . $i; ?></span></label></td>
                                <td valign="middle"><input name="<?php echo $Add_FieldName; ?>" id="<?php echo $Add_FieldName; ?>" type="text" size="30" maxlength="100" value="" class="form-control"></td>
                                <td valign="middle"><?php echo select_field($Add_Field_Type_Field, $Add_Field_Type_Field, $SKTListFieldType, 2); ?></td>
                                <td valign="middle"><input name="<?php echo $Add_Field_Type_Opt; ?>" id="<?php echo $Add_Field_Type_Opt; ?>" value="" type="text" class="form-control"/></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">
                                <div id="LessField" class="btn btn-danger"><i class="skt-icon-minus-squared"></i> Quitar el &Uacute;ltimo campo</div><div id="AddMoreField" class="btn btn-info"><i class="skt-icon-plus-squared"></i> Agregar otro campo</div></td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <button class="btn btn-lg btn-primary" name="SubmitForm_List_Add_List" id="SubmitForm_List_Add_List" type="button" style="color:white; float: right" ><i class="skt-icon-acept"></i><span style="vertical-align: super;"><?php echo \SKT_ADMIN_Btn_Acept ?></span></button>
                            </td>
                        </tr>
                        <tr><td colspan="8"><div class="validateTips alert alert-danger"></div></td></tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </div>
</div>
<div class="clear"></div>
<script type="text/javascript">
    var FieldsShow = 5;

    $('#Add_List_Form tbody tr:gt(' + FieldsShow + ')').hide();

    $('#Add_List_Form #AddMoreField').click(function () {
        FieldsShow = FieldsShow + 1;
        $('#Add_List_Form tbody tr:eq(' + FieldsShow + ')').show();
    });

    $('#Add_List_Form #LessField').click(function () {
        $('#Add_List_Form tbody tr:eq(' + FieldsShow + ')').hide();
        FieldsShow = FieldsShow - 1;
    });

</script>