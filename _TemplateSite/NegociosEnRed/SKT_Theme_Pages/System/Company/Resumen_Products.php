<?php
$DSTemplate = dirname(__FILE__) . DIRECTORY_SEPARATOR;
$TemplateItem = \file_get_contents($DSTemplate . 'Resumen_Products.tpl');
?>
<h2>Mis Publicaciones</h2>
<div class="row">
    <div class="text-right col-md-12 col-sm-12">
        <span class="btn btn-default viewActive active" >Ver activos</span>
        <span class="btn btn-default viewInActive" >Ver inactivos</span>
    </div>
    <table class="table cart-table table-striped dataTableB3" id="tableProducts">
        <thead>
            <tr>
                <th>Item</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Activo</th>
                <th>Moneda</th>
                <th>Precio</th>
                <th>Volúmen</th>
                <th class="hidden">Borrar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $InstancsParams = array(
                'TemplateItem' => $TemplateItem,
                'ProductImageSize' => array('x' => '70', 'y' => '70'),
                'CatP' => '',
                'Cat' => '',
                'Query' => '',
                'ShowExpired' => 1,
                'IDUser' => $CCParams_Products_List['id'],
                //'ExcludeID' => $CCParams['Exclude'],
                'Limit' => 150
            );
            $List = new CmsDev\CRUD\ViewEditElementsAsList\Lists\Products\_classes();
            echo $List->GetList($InstancsParams);
            ?>
        </tbody>
    </table>
</div>
<div class="gap-small"></div>
<script type="text/javascript">
    $(document).ready(function () {
        
        $(".viewInActive").click(function(){
            $(".viewInActive").addClass('active');
             $(".viewActive").removeClass('active');
             
            $('#tableProducts tr.active').addClass('hidden');
            $('#tableProducts tr.Expired').removeClass('hidden');
        });
        $(".viewActive").click(function(){
             $(".viewInActive").removeClass('active');
              $(".viewActive").addClass('active');
              
            $('#tableProducts tr.active').removeClass('hidden');
            $('#tableProducts tr.Expired').addClass('hidden');
        });
        
        /*$('#tableProducts').dataTable({
         "language": {
         "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
         },
         stateSave: true,
         "aoColumnDefs": [{
         "aTargets": [4],
         "sType": "currency",
         "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
         var $currencyCell = $(nTd);
         var commaValue = $currencyCell.text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
         $currencyCell.text(commaValue);
         }
         }]
         });*/
    });
</script>