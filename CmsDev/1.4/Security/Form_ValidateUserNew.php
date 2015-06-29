<?php
if ($Render === 'FormValidateCode') {
    ?>
    <form method="GET">
        <div class="text-center">
            <img src="/_FileSystems/images/relax.png" alt=""/>
            <h1>Relajese, falta poco!</h1>
            <h3>Pegue aqu&iacute; el c&oacute;digo que recibi&oacute; en su correo para validar el mail y listo!</h3>
            <div class="gap"></div>
            <div class="row">
                <div class="col-md-9">
                    <div class="control-group">
                        <div class="controls">
                            <input type="text" name="code" value=""  class="input-lg btn-block form-control  text-center"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-block btn-primary input-lg" >Validar</button>
                </div>
            </div>
        </div>
    </form>
    <?php
} else {
    if ($Validated === true) {
        ?>
        <div class="text-center">
            <img src="/_FileSystems/images/excelente.png" alt=""/>
            <h1>Excelente!</h1>
            <h3><i class="skt-icon-ok"></i> El mail fu&eacute; validado con &eacute;xito, ahora puede iniciar sessi&oacute;n. </h3>
            <div class="gap"></div>
            <a data-effect="mfp-move-from-top" href="#login-dialog" class="popup-text btn btn-mega text-uppercase btn-primary"><i class="fa fa-sign-in"></i> Ingresar</a>
        </div>
        <?php
    } else {
        ?>
        <div class="text-center">
            <h1>Algo no anda bien, intenta nuevamente.</h1>
    <form method="GET">
        <div class="text-center">
            <h3>Pegue aqu&iacute; el c&oacute;digo que recibi&oacute; en su correo para validar el mail y listo!</h3>
            <div class="gap"></div>
            <div class="row">
                <div class="col-md-9">
                    <div class="control-group">
                        <div class="controls">
                            <input type="text" name="code" value=""  class="input-lg btn-block form-control  text-center"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-block btn-primary input-lg" >Validar</button>
                </div>
            </div>
        </div>
    </form>
        </div>
        <?php
    }
}
?>


