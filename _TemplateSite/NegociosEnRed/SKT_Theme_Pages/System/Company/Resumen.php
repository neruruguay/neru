<div class="col-md-6">
    <h2 class="mt40 text-color"><i class="skt-icon-basquet"></i> Resumen de Cuenta e Hist&oacute;rico</h2>
</div>
<div class="col-md-6">
    <?php
    require (dirname(dirname(__FILE__)) . DS . 'Company' . DS . 'Resumen_Plan.php');
    ?>
</div>      
<div class="row">
    <div class="col-md-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active"><a href="#tab-1" data-toggle="tab">Compras Activas</a>
                </li>
                <li><a href="#tab-2" data-toggle="tab">Ventas Activas</a>
                </li>
                <li><a href="#tab-3" data-toggle="tab">Mis Publicaciones</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="tab-1">
                    <?php
                    require (dirname(dirname(__FILE__)) . DS . 'Company' . DS . 'Resumen_Purchase_Sell.php');
                    ?> 
                </div>
                <div class="tab-pane fade" id="tab-2">
                    <?php
                    require (dirname(dirname(__FILE__)) . DS . 'Company' . DS . 'Resumen_Purchase_Buy.php');
                    ?>  
                </div>
                <div class="tab-pane fade" id="tab-3">
                    <?php
                    require (dirname(dirname(__FILE__)) . DS . 'Company' . DS . 'Resumen_Products.php');
                    ?> 
                </div>
            </div>
        </div>

    </div>
</div>
