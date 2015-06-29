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
if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {

    $SKTDB = \CmsDev\sql\db_Skt::connect();
    $ListID = $_POST['ListID'];
    $ID = $_POST['ID'];

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
            <h3 class="panel-title">Editando Item</h3>
        </div>
        <div class="panel-body">


            <?php
            include_once '_Functions.php';
            $Lists_Fields = $SKTDB->get_row("SELECT * FROM lists_fields WHERE IDLists = " . GetSQLValueString($ListID, "int"));
            $lists_values = $SKTDB->get_row("SELECT * FROM lists_values WHERE ID = " . GetSQLValueString($ID, "int"));
            $Values = json_clean_decode($lists_values->Value, true);
            //echo "<pre>". var_dump($Values)."</pre>";
            $rand = rand(2, 100000);
            ?>
            <form action="" method="post" name="Edit_Item_List" id="Edit_Item_List" style="margin-bottom: 100px;">
                <input name="ID" id="ID" type="hidden" value="<?php echo $ID ?>" />
                <input name="IDLists" id="IDLists" type="hidden" value="<?php echo $ListID ?>" />
                <table width="100%" border="0" align="left" cellpadding="5" cellspacing="0" class="table table-striped">
                    <tr>
                        <td align="right"><label><span>Publicaci&oacute;n</span></label></td>
                        <td colspan="2">
                            <input name="datePost" id="datePost" type="date" value="<?php echo $lists_values->datePost ?>" data-format="Y-m-d"  class="datepicker form-control"  style="width: 89px;"/>
                        </td>
                        <td><label><span><sup>datePost</sup></span></label></td>
                    </tr>
                    <?php
                    for ($i = 1; $i < $SKTListFieldSize + 1; $i++) {
                        $x = 'Field' . $i;
                        $x1 = 'Field_Type_Field' . $i;
                        $xName = '' . ListField($Lists_Fields->$x);
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
                                        echo '<input name="' . $x . '" type="text" size="70" maxlength="255" value="' . $Values[$xName] . '" class="form-control" placeholder="' . ListField($Lists_Fields->$x) . '">';
                                    } elseif (ListType($x1, $x1, $SKTListFieldType, ListFieldType($Lists_Fields->$x)) == 'link') {
                                        echo '<input name="' . $x . '" type="text" size="70" maxlength="255" value="' . $Values[$xName] . '" class="form-control" style="padding-left: 55px;" placeholder="' . ListField($Lists_Fields->$x) . '"><a href="javascript:void(0);" class="skt-icon-link btn btn-default" target="_blank"  style="position: absolute; top: 7px;"></a>';
                                    } elseif (ListType($x1, $x1, $SKTListFieldType, ListFieldType($Lists_Fields->$x)) == 'text') {
                                        echo '<textarea name="' . $x . '" cols="52" rows="5" placeholder="' . ListField($Lists_Fields->$x) . '" class="form-control">' . $Values[$xName] . '</textarea>';
                                    } elseif (ListType($x1, $x1, $SKTListFieldType, ListFieldType($Lists_Fields->$x)) == 'html') {
                                        echo '<textarea name="' . $x . '" cols="52" rows="5" class="htmlfield' . $rand . ' form-control">' . $Values[$xName] . '</textarea>';
                                    } elseif (ListType($x1, $x1, $SKTListFieldType, ListFieldType($Lists_Fields->$x)) == 'Basic html') {
                                        echo '<textarea name="' . $x . '" cols="52" rows="5" class="Richfield' . $rand . ' form-control">' . $Values[$xName] . '</textarea>';
                                    } elseif (ListType($x1, $x1, $SKTListFieldType, ListFieldType($Lists_Fields->$x)) == 'int') {
                                        echo '<input name="' . $x . '" type="text" size="15" maxlength="20" value="' . $Values[$xName] . '" class="form-control">';
                                    } elseif (ListType($x1, $x1, $SKTListFieldType, ListFieldType($Lists_Fields->$x)) == 'enum') {
                                        enumCreate($x, $lists_values->ListField($Lists_Fields->$x));
                                    } elseif (ListType($x1, $x1, $SKTListFieldType, ListFieldType($Lists_Fields->$x)) == 'date') {
                                        echo '<input name="' . $x . '" type="text" size="15" maxlength="10" value="' . $Values[$xName] . '" class="datepicker form-control"  style="width: 89px;">';
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
                            <input name="Order" style="width:150px !important;" class="form-control" type="number" value="<?php echo $lists_values->Position; ?>">
                        </td>
                        <td><label><span><sup>Order</sup></span></label></td>
                    </tr>
                    <tr>
                        <td align="center" colspan="4">
                            <button class="btn btn-lg btn-warning" name="SubmitForm_Delete_Item_List" id="SubmitForm_Delete_Item_List" type="button" style="color:white;" ><i class="skt-icon-delete"></i><span style="vertical-align: super;"><?php echo \SKT_ADMIN_Btn_Delete ?></span></button>
                            <button class="btn btn-lg btn-primary" name="SubmitForm_Add_Item_List" id="SubmitForm_Add_Item_List" type="button" style="color:white;" ><i class="skt-icon-acept"></i><span style="vertical-align: super;"><?php echo \SKT_ADMIN_Btn_Save ?></span></button>
                        </td>
                    </tr>
                </table>
            </form>
            <div class="clear"></div>
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
                'docCSSFile': "<?php echo \SKTURL_TemplateSite ?>/css/style.css",
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
                'url': URL_Query_Edit_Item_query,
                'cache': false,
                'data': $("form#Edit_Item_List").serialize(),
                'success': function (success_List_Edit_Properties) {

                    if (success_List_Edit_Properties.indexOf('okay') != -1) {
                        CustomListSKT.ViewItems();
                        $('#Load_Item').html('Item Editado con &eacute;xito:');
                    } else {
                        var RKO = '<label><div class="ui-state-error ui-corner-all"><p>' + SKT_ADMIN_Message_Update_Error + '<span style="float: left; margin-right: .3em;" class="ui-icon ui-icon-alert"></span></p></div></label>';
                        $('.validateTips').html(RKO);
                    }
                }
            });
        });
    </script>
<?php } ?>