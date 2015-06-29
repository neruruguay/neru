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
$InputSelectedListID = $_POST['InputSelectedListID'];

$glob = \CmsDev\util\globals::init();
$SKT = $glob->getVar('SKT');
$SKT_ADMIN = $glob->getVar('SKTADMIN');
$SKTListFieldType = $glob->getVar('SKTListFieldType');
$SKTListFieldSize = $glob->getVar('SKTListFieldSize');
?>

<style media="all" type="text/css">
    #CmsDevTabs .cleditorMain iframe, .cleditorMain textarea{
        display: block;
        height: 81% !important;
        width: 100% !important;
    }
    .labelradio{
        clear: none !important;
        float: left;
        padding: 0 10px;
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Nuevo Item</h3>
    </div>
    <div class="panel-body">

        <div class="grid_16">
            <label><span>Lista:</span> '<span class="ListsSelectedName"></span>'</label>

            <?php

            function ListField($field) {
                $fieldtrue = explode('|', $field);
                return utf8_encode($fieldtrue[1]);
            }

            function ListFieldType($field) {
                $fieldtrue = explode('|', $field);
                return $fieldtrue[0];
            }

            function showListType($a, $select = '') {
                $formatedarray = '';
                foreach ($a as $k => $v) {
                    if ($select == $v) {
                        $formatedarray.= "$k";
                    } else {
                        
                    }
                }
                return $formatedarray;
            }

            function ListType($name, $id, $passarray, $select = '') {
                $optionarray = showListType($passarray, $select);
                return $optionarray;
            }

            function enumCreate($x, $Fields) {
                $ListEnum = explode(',', ListField($Fields));
                //echo count($ListEnum);
                $i = 0;
                foreach ($ListEnum as $value) {
                    $value = str_replace('\'', '', $value);
                    if ($i == 0) {
                        $check = 'checked';
                    } else {
                        $check = '';
                    }
                    echo '<label for="' . $x . '_' . $i . '" class="labelradio"><span><input name="' . $x . '" type="radio" ' . $check . ' value="' . $value . '" id="' . $x . '_' . $i . '">' . $value . '</span></label>';
                    $i++;
                }
            }

            $Lists_Fields = $SKTDB->get_row("SELECT IDLists, Field1, Field2, Field3, Field4, Field5, Field6, Field7, Field8, Field9, Field10, Field11, Field12, Field13, Field14, Field15, Field16, Field17, Field18, Field19, Field20, Field21, Field22, Field23, Field24, Field25, Field26, Field27, Field28, Field29, Field30, Field31, Field32, Field33, Field34, Field35, Field36, Field37, Field38, Field39, Field40 FROM lists_fields WHERE IDLists = '$InputSelectedListID'");

            $rand = rand(2, 100000);
            ?>
            <form action="" method="post" name="Add_Item_List" id="Add_Item_List" style="margin-bottom: 100px;">
                <input name="IDLists" id="IDLists" type="hidden" value="<?php echo $Lists_Fields->IDLists ?>" />

                <table width="100%" border="0" align="left" cellpadding="5" cellspacing="0" class="table table-striped">

                    <tr>
                        <td align="right"><label><span>Publicaci&oacute;n</span></label></td>
                        <td colspan="2">
                            <input name="datePost" id="datePost" type="date" value="<?php echo date('Y-m-d'); ?>" data-format="Y-m-d"  class="datepicker form-control"  style="width: 89px;"/>
                        </td>
                        <td><label><span><sup>datePost</sup></span></label></td>
                    </tr>

                    <?php
                    for ($i = 1; $i < $SKTListFieldSize + 1; $i++) {
                        $x = 'Field' . $i;
                        $x1 = 'Field_Type_Field' . $i;
                        if ($Lists_Fields->$x != '') {
                            ?>
                            <tr>
                                <td width="10%" align="right"><label><span>
                                            <?php
                                            if (ListType($x1, $x1, $SKTListFieldType, ListFieldType($Lists_Fields->$x)) != 'enum') {
                                                echo ListField($Lists_Fields->$x);
                                            } else {
                                                echo 'Opciones:';
                                            }
                                            ?>
                                        </span></label></td>
                                <td colspan="2" style="position: relative">
                                    <?php
                                    if (ListType($x1, $x1, $SKTListFieldType, ListFieldType($Lists_Fields->$x)) == 'varchar') {
                                        echo '<input name="' . $x . '" type="text" size="70" maxlength="255" value="" class="form-control" placeholder="' . ListField($Lists_Fields->$x) . '">';
                                    } elseif (ListType($x1, $x1, $SKTListFieldType, ListFieldType($Lists_Fields->$x)) == 'link') {
                                        echo '<input name="' . $x . '" type="text" size="70" maxlength="255" value="" class="form-control" style="padding-left: 55px;" placeholder="' . ListField($Lists_Fields->$x) . '"><a href="javascript:void(0);" class="skt-icon-link btn btn-default" target="_blank"  style="position: absolute; top: 7px;"></a>';
                                    } elseif (ListType($x1, $x1, $SKTListFieldType, ListFieldType($Lists_Fields->$x)) == 'text') {
                                        echo '<textarea name="' . $x . '" cols="52" rows="5" placeholder="' . ListField($Lists_Fields->$x) . '" class="form-control"></textarea>';
                                    } elseif (ListType($x1, $x1, $SKTListFieldType, ListFieldType($Lists_Fields->$x)) == 'html') {
                                        echo '<textarea name="' . $x . '" cols="52" rows="5" class="htmlfield' . $rand . ' form-control"></textarea>';
                                    } elseif (ListType($x1, $x1, $SKTListFieldType, ListFieldType($Lists_Fields->$x)) == 'Basic html') {
                                        echo '<textarea name="' . $x . '" cols="52" rows="5" class="Richfield' . $rand . ' form-control"></textarea>';
                                    } elseif (ListType($x1, $x1, $SKTListFieldType, ListFieldType($Lists_Fields->$x)) == 'int') {
                                        echo '<input name="' . $x . '" type="text" size="15" maxlength="20" value="" class="form-control">';
                                    } elseif (ListType($x1, $x1, $SKTListFieldType, ListFieldType($Lists_Fields->$x)) == 'enum') {
                                        enumCreate($x, $Lists_Fields->$x);
                                    } elseif (ListType($x1, $x1, $SKTListFieldType, ListFieldType($Lists_Fields->$x)) == 'date') {
                                        echo '<input name="' . $x . '" type="text" size="15" maxlength="10" value="" class="datepicker form-control"  style="width: 89px;">';
                                    }
                                    //echo ListType($x1, $x1, $SKTListFieldType, ListFieldType($Lists_Fields->$x));
                                    ?>
                                </td>
                                <td>
                                    <label>
                                        <span>
                                            <sup>
                                                <?php
                                                echo $x;
                                                ?>
                                            </sup>
                                        </span>
                                    </label>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?> 
                    <tr>
                        <td align="right"><label><span>Visibilidad</span></label></td>
                        <td colspan="2">
                            <table border="0" cellpadding="0" cellspacing="0" style="width:auto !important">
                                <tr>
                                    <td align="left">
                                        <label for="RecycleBin_0"><span><?php echo \SKT_ADMIN_TXT_ShowContentVisible ?></span></label>
                                    </td>
                                    <td align="left">
                                        <input type="radio" name="RecycleBin" checked="checked" value="0" id="RecycleBin_0" />
                                    </td>
                                    <td align="left">&nbsp;</td>
                                    <td align="left">
                                        <label for="RecycleBin_1"><span><?php echo \SKT_ADMIN_TXT_ShowContentHidden ?></span></label>
                                    </td>
                                    <td align="left">
                                        <input type="radio" name="RecycleBin" value="1" id="RecycleBin_1" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td><label><span><sup>RecycleBin</sup></span></label></td>
                    </tr>
                    <tr>
                        <td align="right"><label><span>Orden</span></label></td>
                        <td colspan="2">
                            <select name="Order" style="width:150px !important;" class="form-control">
                                <?php
                                for ($i = 1; $i < 50; $i++) {
                                    /* if($PositionSelect==$i){
                                      echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
                                      }else{ */
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                    //}
                                }
                                ?>
                            </select>
                        </td>
                        <td><label><span><sup>Order</sup></span></label></td>
                    </tr>
                    <tr>
                        <td align="center" colspan="4">
                            <button class="btn btn-lg btn-primary" name="SubmitForm_Add_Item_List" id="SubmitForm_Add_Item_List" type="button" style="color:white;" ><i class="skt-icon-acept"></i><span style="vertical-align: super;"><?php echo \SKT_ADMIN_Btn_Acept ?></span></button>
                        </td>
                    </tr>
                </table>
            </form>
            <div class="clear"></div>
        </div>

    </div>
</div>
<div class="clear"></div>
<a id="LinkDummy" href="#" target="_blank"></a>
<script type="text/javascript">
    function HTML_Content_htmlfield<?php echo $rand; ?>() {
        AppSKT.CreateContentEditor({
            'Element': '.htmlfield<?php echo $rand; ?>',
            'width': '100%',
            'height': '300',
            'colors': "<?php echo \SKT_EDITOR_COLORS; ?>",
            'fonts': "<?php echo \SKT_EDITOR_FONTS ?>",
            'bodyStyle': "<?php echo \SKT_EDITOR_BODY ?>",
            'docCSSFile': "<?php echo \SKTURL_TemplateSite ?>/assets/NegociosEnRed.css",
            'docType': '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'
        });
    }
    function HTML_Content_Richfield<?php echo $rand; ?>() {
        AppSKT.CreateContentEditor({
            'Element': '.Richfield<?php echo $rand; ?>',
            'width': '100%',
            'height': '300',
            'colors': '<?php echo \SKT_EDITOR_COLORS; ?>',
            'fonts': '<?php echo \SKT_EDITOR_FONTS ?>',
            'bodyStyle': '<?php echo \SKT_EDITOR_BODY ?>',
            'docCSSFile': '<?php echo \SKTURL_TemplateSite ?>/css/style.css',
            'docType': '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
            'controls': 'bold italic underline | removeformat | bullets numbering | outdent indent | alignleft center alignright justify | undo redo | pastetext'
        });
    }


    $(document).ready(function () {
        if ($('.htmlfield<?php echo $rand; ?>').length != 0) {
            setTimeout("HTML_Content_htmlfield<?php echo $rand; ?>();", 1000);
        }
        if ($('.Richfield<?php echo $rand; ?>').length != 0) {
            setTimeout("HTML_Content_Richfield<?php echo $rand; ?>();", 1000);
        }
        $("a.skt-icon-link").click(function () {
            var link = $(this).prev('input').val();
            $(this).attr('href', link);
            $(this).trigger("click");
        });
    });

    $(function () {
        $('.datepicker', 'form#Add_Item_List').datepicker({dateFormat: "yy-mm-dd"});
        $('#ui-datepicker-div').wrap('<div class="skt" />');
    });


    $('#SubmitForm_Add_Item_List').click(function () {
        jQuery.ajax({
            'type': 'POST',
            'url': URL_Query_Add_Item_query,
            'cache': false,
            'data': $("form#Add_Item_List", "#dialog-form-Administrator").serialize(),
            'success': function (success_List_Edit_Properties) {

                if (success_List_Edit_Properties.indexOf('okay') != -1) {
                    var ListID = success_List_Edit_Properties.replace('|okay', '');
                    var ListName = $('.ListsSelectedName').val();

                    jQuery.ajax({
                        'type': 'POST',
                        'url': URL_View_List_Properties,
                        'cache': false,
                        'data': $("form#FormLists", "#dialog-form-Administrator").serialize(),
                        'success': function (success_List_Properties) {
                            $('#dialog-form-Administrator #tabs-2').html(success_List_Properties);
                            $('#dialog-form-Administrator #tabs-2 .ListsSelectedName').html('' + ListName + '');
                        }
                    });

                    jQuery.ajax({
                        'type': 'POST',
                        'url': URL_View_List_Items,
                        'cache': false,
                        'data': $("form#FormLists", "#dialog-form-Administrator").serialize(),
                        'success': function (success_List_Items) {
                            $('#dialog-form-Administrator #tabs-3').html(success_List_Items);
                            $('#dialog-form-Administrator #tabs-3 .ListsSelectedName').html('' + ListName + '');
                        }
                    });
                    $('.validateTips').html('Item creado con &eacute;xito:' + ListName);


                } else {

                    var RKO = '<label><div class="ui-state-error ui-corner-all"><p>' + SKT_ADMIN_Message_Update_Error + '<span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span></p></div></label>';

                    $('.validateTips').html(RKO);

                }


            }
        });
    });

</script>
