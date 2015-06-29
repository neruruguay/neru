<?php if (\CmsDev\Security\loginIntent::action('validate') !== true) { ?>
    <div id="RegisterNoLogin-dialog" class="mfp-with-anim mfp-hide mfp-dialog clearfix">
        <i class="fa fa-gift dialog-icon"></i>
        <h3 class="text-color">Promo Empresas</h3>
        <form class="dialog-form" action="<?php echo \SKT_URL_BASE; ?>UserRegistration" method="POST">
            <img src="/_FileSystems/images/vendedor0.jpg" alt="" class="img-responsive mt0 mb40" style="width: 100%"/>
            <h3>No importa si eres una PYME o formas parte de una gran Empresa.</h3>
            <h3><b>Registrate y obten 100 Publicaciones de productos y/o Servicios por 6 meses para tu empresa.<br>
                    <br><span class="text-color fa-2x text-center">GRATIS!</span></b><br></h3>
            <div class="gap"></div>
            <div class="gap-border"></div>
            <input type="hidden" value="1" name="PromoEmpresas"/>
            <input type="submit" value="Quiero la promoci&oacute;n GRATIS" class="btn btn-primary float-right"/>
            <a class="popup-text" href="#login-dialog" data-effect="mfp-zoom-out"  style="display: inline-block; margin-top: 15px; font-size: 14px;font-weight: 600;">Ya estoy registrado</a>
        </form>
    </div>
    <a id="GoPopup" href="#RegisterNoLogin-dialog" class="popup-text" data-effect="mfp-zoom-out"><i class="fa fa-gift fa-3x"></i><br>Promo<br>Empresas</a>
    <script type="text/javascript">
        $(document).ready(function () {
            PopUpRegister();
        });
        function PopUpRegister() {
            if (!$.cookie("PopUpRegister")) {
                $.cookie("PopUpRegister", "1", {expires: 7, path: '/'});
                $('#GoPopup').trigger('click');
            }
        }
    </script>

<?php } ?>