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


echo '<label><span>Listado de Items en:</span> <span class="ListsSelectedName"></span></label>
            <div class="grid_16" style="background-color:#FFF">';

function ListField($field) {
    $fieldtrue = explode('|', $field);
    return $fieldtrue[1];
}

function ListFieldType($field) {
    $fieldtrue = explode('|', $field);
    return $fieldtrue[0];
}

$InputSelectedListID = isset($_POST['InputSelectedListID']) ? $_POST['InputSelectedListID'] : '';

if ($InputSelectedListID != '') {

    $Query_Lists_Values = $SKTDB->get_results("SELECT Value FROM lists_values WHERE IDList = " . GetSQLValueString($InputSelectedListID, "int"));


    $data = '';
    if ($Query_Lists_Values) {
        foreach ($Query_Lists_Values as $Values) {
            $data.= $Values->Value . ',';
        }
    }
    if (json_encode(utf8_encode($data)) != '""') {
        ?>
        <script>
            $(document).ready(function () {
                var json = [<?php echo $data ?>];
                $('#DynamicGridLoading').hide();
                $('#DynamicGrid').append(CreateTableView(json, "CustomList", true)).fadeIn();
                $('.CustomList').DataTable();
                $('.CustomList tbody tr').click(function(){
                    var ID = $(this).find('td:eq(0)').text();
                    var ListID = $(this).find('td:eq(1)').text();
                    CustomListSKT.EditItem(ID,ListID);
                });
            });
        </script>
        <div id="DynamicGrid" >
            <div id="DynamicGridLoading" >
                <img src="<?php echo \ASSETS; ?>img/loading.gif" /><span> Cargando... </span>
            </div>
        </div>
    <?php } else { ?> 
        <div id="DynamicGrid" >
            <div id="DynamicGridLoading" >
                <span> No se encontraron resultados </span>
            </div>
        </div>
        <?php
    }
}
?> 
</div>
<div class="clear"></div>