<footer class="main" id="main-footer">
    <div class="footer-top-area">
        <div class="container">
            <div class="row row-wrap">
                <div class="col-md-3">
                    <a href="/" class="logofooter">
                        <img src="<?php echo SKTURL_TemplateSite; ?>assets/img/logo.png" alt="logo" title="logo" class="img-responsive">
                    </a>
                    <ul class="list list-social">
                        <li>
                            <a class="fa fa-twitter box-icon" href="https://twitter.com/negociosuy" target="_blank" data-toggle="tooltip" title="Negocios en Twitter"></a>
                        </li>
                        <li>
                            <a class="fa fa-linkedin box-icon" href="https://www.linkedin.com/profile/view?id=409356200"  target="_blank" data-toggle="tooltip" title="LinkedIn"></a>
                        </li>
                    </ul>
                    <p>Encuentre propuestas interesantes tambien en las redes.</p>
                </div>
                <div class="col-md-3">
                    <h4>Tome un momento para informarse</h4>
                    <ul class="quicklinks">
                        <li><a href="/quienes_somos/" title="Quienes Somos">Quienes Somos</a></li>
                        <li><a href="/politcas_de_privacidad/" title="Politicas de privacidad">Politicas de privacidad</a></li>
                        <li><a href="/terminos_de_uso/" title="Terminos de uso">Terminos de uso</a></li>
                    </ul>
                    <p>Copyright &copy; 2015, <?php echo \CmsDev\skt_Code::Charset(\SKT_SITE_NAME); ?></p>
                </div>
                <div class="col-md-6">
                    <h4>Suscribete al Newsletter</h4>
                    <div class="box">
                        <form method="post" id="FormNewsletter">
                            <div class="form-group mb10">
                                <label>E-mail</label>
                                <input type="email" name="email" class="form-control" id="subscribe_email" placeholder="Escriba su e-mail *">
                            </div>
                            <p class="mb10">Solo se enviara un correo informativo mensualmente.</p>
                            <div class="input-group-btn">
                                <button class="btn btn-inverse btn-block" type="submit" id="subscribe_submit"><i class="fa fa-envelope-o"></i> Enviar suscripci&oacute;n</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-3 hidden">
                    <h4>Negocios en Twitter</h4>
                    <div class="twitter-ticker" id="twitter-ticker">
                        <!-- START TWITTER
                        <a class="twitter-timeline" href="https://twitter.com/negociosuy" data-widget-id="564596902847451136">Tweets por el @negociosuy.</a>
                        <script>!function (d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                                if (!d.getElementById(id)) {
                                    js = d.createElement(s);
                                    js.id = id;
                                    js.src = p + "://platform.twitter.com/widgets.js";
                                    fjs.parentNode.insertBefore(js, fjs);
                                }
                            }(document, "script", "twitter-wjs");</script>
                        END TWITTER -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>