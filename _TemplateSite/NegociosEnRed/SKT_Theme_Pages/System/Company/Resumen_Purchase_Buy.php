<?php
$DSTemplate = dirname(__FILE__) . DIRECTORY_SEPARATOR;
$TemplateItem = \file_get_contents($DSTemplate . 'Resumen_Purchase_Buy.tpl');
?>
<h2>Mis Ventas</h2>
<div class="row" id="TablePurchaseVentas"> 
    <table class="table cart-table table-striped dataTableB3">
        <thead>
            <tr>
                <th class="col-md-5">Productos</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $InstancsParams = array(
                'TemplateItem' => $TemplateItem,
                'ProductImageSize' => array('x' => '70', 'y' => '70'),
                'ShowExpired' => 1,
                'IDUser' => $User->id,
                'whois' => 'Seller',
                'Limit' => 500
            );
            $PurchaseRequests = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Purchase_Requests\_classes();
            echo $PurchaseRequests->GetList($InstancsParams);
            ?>
        </tbody>
    </table>
</div>
<div class="gap-small"></div>
<script type="text/javascript">
    $(document).ready(function () {
        dataTableSell();
    });
    function dataTableBuy() {
        /*$('#TablePurchaseVentas .table').dataTable({
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ning&uacute;n dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "&Uacute;ltimo",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
            stateSave: true
        });*/
        $('.OrderPurchaseCancel').click(function () {
            $(this).parent('.form-group').next('.form-group').hide();
        });
        $('.OrderPurchaseOk').click(function () {
            $(this).parent('.form-group').next('.form-group').show();
        });
    }
    function SemaphoreBuy(OrderPurchase) {
        var UrlOrderPurchase = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Purchase_Requests/Confirm');
        var Form = $('.mfp-content #Order' + OrderPurchase + '-Confirm #Semaphore');
        $("#loader-wrapper").removeClass('load_hide');
        jQuery.ajax({
            'type': 'POST',
            'url': UrlOrderPurchase,
            'cache': false,
            'data': Form.serialize(),
            'success': function (data) {
                $('.validateTips', Form).html(data);
                $("#loader-wrapper").addClass('load_hide');
                //location.reload();
            }
        });
    }
</script>