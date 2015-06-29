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
                    <div class="text-left col-md-6 col-sm-12">
                        [Finalized]<br>[Semaphore]
                    </div>
                    <div class="text-right col-md-6 col-sm-12">
                        <a class="popup-text btn btn-info ml10" href="#Order[OrderPurchase]-dialog" data-effect="mfp-zoom-out">Ver Datos del Vendedor</a>
                        <a class="popup-text btn btn-warning" href="#Order[OrderPurchase]-Confirm" data-effect="mfp-zoom-out">Confirmar Recepci&oacute;n</a>
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
                        <h3>Confirmación de Recepci&oacute;n de pedido</h3>
                        <form class="dialog-form" id="Semaphore">
                            <input type="hidden" value="Customer" name="Who"/>
                            <input type="hidden" value="[OrderPurchase]" name="OrderPurchase"/>
                            <input type="hidden" value="[Customer]" name="Whois"/>
                            <div class="form-group">
                                <label class="alert OrderPurchaseOk">Se concreto la compra <input type="radio" name="SendOrderPurchase" id="SendOrderPurchase_0" class="form-control" value="0" checked="checked"></label>
                                <label class="alert OrderPurchaseCancel">La compra se cancela <input type="radio" name="SendOrderPurchase" id="SendOrderPurchase_1" class="form-control" value="1"></label>
                            </div>
                            <div class="form-group">
                                <b>Como calificaría el producto?</b><br>
                                <div class="ranking">
                                    <label class="rank1"><span>Malo</span><input type="radio" name="Ranking" id="Ranking_1" class="form-control" value="1"></label>
                                    <label class="rank2"><span>Regular</span><input type="radio" name="Ranking" id="Ranking_2" class="form-control" value="2"></label>
                                    <label class="rank3"><span>Bueno</span><input type="radio" name="Ranking" checked="checked" id="Ranking_3" class="form-control" value="3"></label>
                                    <label class="rank4"><span>Recomendable</span><input type="radio" name="Ranking" id="Ranking_4" class="form-control" value="4"></label>
                                    <label class="rank5"><span>Excelente</span><input type="radio" name="Ranking" id="Ranking_5" class="form-control" value="5"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <b>Observaciones</b>
                                <textarea name="Opinion" class="form-control" placeholder="Ej.: Excelente vendedor, entrego en tiempo y forma."></textarea>
                            </div>
                            <a  href="javascript:SemaphoreSell('[OrderPurchase]');" class="btn btn-primary">Enviar</a>
                            <div class="validateTips"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </td>
</tr>