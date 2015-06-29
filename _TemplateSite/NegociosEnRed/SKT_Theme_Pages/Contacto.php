<section id="contact">
    <div class="container">
        <div class="gap"></div>
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-heading">Contactanos</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-12 col-xs-12">
                <form name="sentMessage" id="contactForm" novalidate>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Nombre *" id="name" required data-validation-required-message="Please enter your name.">
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Email *" id="email" required data-validation-required-message="Please enter your email address.">
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="form-group">
                                <input type="tel" class="form-control" placeholder="Teléfono *" id="phone" required data-validation-required-message="Please enter your phone number.">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea class="form-control" style="height: 150px; resize: none;" placeholder="Deja tu mensaje *" id="message" required data-validation-required-message="Please enter a message."></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-12 text-center">
                            <div id="success"></div>
                            <button type="submit" class="btn btn-xl btn-inverse btn-block skt-icon-icon-email">Enviar consulta</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-9 hidden-sm hidden-xs OnlyDesktop">
                <?php
                $SKT_CC = new \CmsDev\CustomControl\LoadControl();
                $SKT_CC->Render('BannerHome');
                ?>
                <?php
                $SKT_CC = new \CmsDev\CustomControl\LoadControl();
                \CmsDev\Content\LoadMod::render('Gene', 'Zona entera Gene');
                ?>
            </div>
        </div>
    </div>
</section>

<div class="gap"></div>