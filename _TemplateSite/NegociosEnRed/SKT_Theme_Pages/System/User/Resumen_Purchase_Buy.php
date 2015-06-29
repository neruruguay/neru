<?php
$TemplateItem = '
<tr class="[ClassExpired]" id="[OrderPurchase]">
    <td>
<div class="row">
    <div class="cart-item-image col-md-1">
        <a href="[UrlDetail]">
            [ProductImage]
        </a>
    </div>
    <div class="ProductInfo col-md-11">
        <div class="row">
            <div class="ProductInfo col-md-5">
                <a href="[UrlDetail]"><b>[Title]</b></a>
                <p>[ProductDescription]</p>
            </div>
            <div class="col-md-1 text-right">
                <b>[OrderDate]</b>
            </div>
            <div class="ProductInfo col-md-3 text-right">
                <label><b class="text-color">[Quantity] Unid.</b> </label><span> a [UnitPrice] [Currency] c/u </span>
            </div>
            <div class="ProductInfo col-md-3 text-right">
                <b class="text-color"><label> Total </label><span> [TotalPrice] [Currency] </span></b>
            </div>
        </div>
        <div class="row ProductBtns">
            <div class="text-right">
                <a class="popup-text btn btn-info ml10" href="#Order[OrderPurchase]-dialog" data-effect="mfp-zoom-out">Ver Datos del Vendedor</a>
                <a class="popup-text btn btn-warning" href="#Order[OrderPurchase]-Confirm" data-effect="mfp-zoom-out">Confirmar Envío</a>
                <a class="popup-text btn btn-default" href="#Order[OrderPurchase]-Comments" data-effect="mfp-zoom-out">Ver comentarios</a>
             </div>
        </div>
        <div class="row hidden">
            <div id="Order[OrderPurchase]-dialog" class="mfp-with-anim mfp-hide mfp-dialog clearfix">
                <i class="skt-icon-access dialog-icon"></i>
                <h3>Datos del Proveedor</h3>
                <div class="SellerInfo">
                    <b>[SellerCompany]</b>
                    <span>RUT: [RUT]</span>
                    <span class="skt-icon-user">[SellerName]</span>
                    <a href="mailto:[email]" class="skt-icon-icon-email">[email]</a>
                    <span class="skt-icon-mobile-1">[Phone]</span>
                </div> 
            </div>
            <div id="Order[OrderPurchase]-Comments" class="mfp-with-anim mfp-hide mfp-dialog clearfix">
                <i class="skt-icon-access dialog-icon"></i>
                <h3>Comentarios</h3>
                <div class="SellerInfo row">
                    [Semaphore]
                </div>
            </div>            
            <div id="Order[OrderPurchase]-Confirm" class="mfp-with-anim mfp-hide mfp-dialog clearfix">
                <i class="skt-icon-access dialog-icon"></i>
                <h3>Confirmación de envío</h3>
                <form class="dialog-form" id="Semaphore">
                <input type="hidden" value="Customer" name="Who"/>
                <input type="hidden" value="[OrderPurchase]" name="OrderPurchase"/>
                <input type="hidden" value="[Customer]" name="Whois"/>
                    <div class="form-group">
                        <label class="alert alert-info">Fue enviado correctamente <input type="radio" name="SendOrderPurchase" id="name="SendOrderPurchase_0" class="form-control" value="0"></label>
                        <label class="alert alert-warning">El pedido se cancela <input type="radio" name="SendOrderPurchase" id="name="SendOrderPurchase_1" class="form-control" value="1"></label>
                    </div>
                    <div class="form-group">
                        <label>Observaciones</label>
                        <textarea name="Opinion" class="form-control" placeholder="Excelente vendedor, entrego en tiempo y forma.<br>No se concreto la compra.">Excelente vendedor, entrego en tiempo y forma</textarea>
                    </div>
                    <a  href="javascript:Semaphore(\'[OrderPurchase]\');" class="btn btn-primary">Enviar</a>
                    <div class="validateTips"></div>
                </form>
            </div>
        </div>
    </div>
</div>
    </td>
</tr>';
?>
<h2>Mis Compras</h2>
<div class="row">
    <table class="table cart-table table-striped dataTableB3" id="TablePurchaseCompras">
        <thead>
            <tr>
                <th>Productos</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $InstancsParams = array(
                'TemplateItem' => $TemplateItem,
                'ProductImageSize' => array('x' => '70', 'y' => '70'),
                'ShowExpired' => 0,
                'IDUser' => $User->id,
                'whois' => 'Customer',
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
        $('#TablePurchaseCompras').dataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            stateSave: true
        });
    });
    function Semaphore(OrderPurchase) {
        var UrlOrderPurchase = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Purchase_Requests/Confirm');
        var Form = $('#Order' + OrderPurchase + '-Confirm #Semaphore');
        jQuery.ajax({
            'type': 'POST',
            'url': UrlOrderPurchase,
            'cache': false,
            'data': Form.serialize(),
            'success': function (data) {
                $('.validateTips', Form).html(data);
            }
        });
    }
</script>