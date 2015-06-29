<div class="col-md-6">
    <h2 class="mt40 text-color"><i class="skt-icon-view-1"></i> Resumen de Cuenta e Hist&oacute;rico</h2>
</div>     
<div class="row">
    <div class="col-md-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active"><a href="#tab-1" data-toggle="tab">Compras Activas</a>
                </li>
                <li><a href="#tab-2" data-toggle="tab">Histórico de Compras</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="tab-1">
                    <?php
                    require (dirname(dirname(__FILE__)) . DS . 'User' . DS . 'Resumen_Purchase_Buy.php');
                    ?> 
                </div>
                <div class="tab-pane fade" id="tab-2">
                    <?php
                    require (dirname(dirname(__FILE__)) . DS . 'User' . DS . 'Resumen_History.php');
                    ?>  
                </div>
            </div>
        </div>

    </div>
</div>
