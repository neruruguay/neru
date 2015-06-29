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
if (\CmsDev\Security\loginIntent::action('validate', 'Language', 'Edit') === true) {

    echo str_replace('[title]', \SKT_ADMIN_TXT_EditLanguage, \SKT_ADMIN_AdminWraperOpen);
    ?>
    <div class="container_16">
        <div class="CreateContentHtml">
            <div class="grid_16">
                <table width="50%" border="0" cellspacing="0" cellpadding="0" class="TableResult">
                    <tr class="Color">
                        <td><h5>Nombre</h5></td>
                        <td><h5>Prefijo</h5></td>
                        <td><h5>URL</h5></td>
                        <td><h5>Visible</h5></td>
                    </tr>
                    <?php

                    function languageActiveOnOff($action, $ID) {
                        if ($action != "" && $ID != "") {
                            switch ($action) {
                                case '0': $ResultActiveOnOff = '<a class="languageActiveOnOff" href="javascript:void(0)" id="' . $ID . '" rel="' . $action . '">Ocultar</a>';
                                    break;
                                case '1': $ResultActiveOnOff = '<a class="languageActiveOnOff" href="javascript:void(0)" id="' . $ID . '" rel="' . $action . '">Mostrar</a>';
                                    break;
                            }
                            return $ResultActiveOnOff;
                        }
                    }

                    $Lenguage_Menu_query = $SKTDB->get_results("SELECT ID,LanguageName,Prefix,URL,SID,Hidden FROM language ORDER BY LanguageName ASC");
                    foreach ($Lenguage_Menu_query as $Lenguage_Menu_Item) {
                        echo '<tr>
							<td>' . utf8_encode($Lenguage_Menu_Item->LanguageName) . '</td>
							<td>' . $Lenguage_Menu_Item->Prefix . '</td>
							<td><a href="' . \SUBSITE . $Lenguage_Menu_Item->URL . '">' . $Lenguage_Menu_Item->URL . '</a></td>
							<td>' . languageActiveOnOff($Lenguage_Menu_Item->Hidden, $Lenguage_Menu_Item->ID) . '</td>
						  </tr>';
                    }
                    ?>
                </table>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <?php echo \CmsDev\Language\AdminGlosary::getTableEdit(); ?>
    </div>
    <?php echo \SKT_ADMIN_AdminWraperClose ?> 

    <script type="text/javascript">
        $("#dialog").dialog("destroy");
        $("#dialog-form-Administrator").dialog({
            autoOpen: true,
            height: 1000,
            width: '90%',
            maxWidth: 990,
            modal: true,
            close: function () {
                AppSKT.skt_RemoveDialog();
            }
        });
        AppSKT.skt_WrapDialog();
        $('.languageActiveOnOff').button()
                .click(function () {
                    var Boton = $(this);
                    Boton.html('<span class="ui-button-text">...</span>');
                    jQuery.ajax({
                        'type': 'POST',
                        'url': URL_QueryLanguage_Activate_Update,
                        'cache': false,
                        'data': 'ID=' + $(this).attr('id') + '&Hidden=' + $(this).attr('rel'),
                        'success': function (MSG) {
                            Boton.html(MSG);
                        }
                    });
                    return false;
                });
    </script>
    <?php }
?>