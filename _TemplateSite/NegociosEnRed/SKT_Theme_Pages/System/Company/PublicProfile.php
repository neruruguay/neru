<div class="col-md-12 mt30">
    <div class="col-md-3">
        <header class="Company-header mb30">
            <?php
            echo '<img class="img-responsive" id="CompanyLogo" title="' . $User->Company . '" alt="' . $User->Company . '" src="' . \SKT_URL_BASE . $User->ClientAuth_picture . '">';
            ?>
        </header>
        <div class="clear"></div>
        <?php
        $SKT_CC->Render('Companies', $CCParams_Products_List, 'Aside.php');
        ?>
    </div>
    <div class="Company-inner  col-md-9 mt30">
        <h2 class="Company-title"><?php echo $User->Company; ?></h2>
        <div class="Company-desciption" id="CompanyDesciption">
            <?php echo $User->Description; ?>
            <div class="gap-small"></div>
        </div>
        <?php
        if ($ValidateSelfUser === TRUE && $User->ViewHelp != 0) {
            require ($DirectoryCompany . 'Product_demo.php');
        }
        $SKT_CC->Render('Products_List', $CCParams_Products_List);
        ?>
    </div>
</div>
<div class="gap"></div>
<div class="col-md-6">
    <div class="google-map">
        <div id="map_canvas" style="width:100%; height:auto;"></div>
    </div>
</div>
<?php if ($ValidateSelfUser !== TRUE) { ?>
    <div class="col-md-3">
        <h4>Enviar mensaje...</h4>
        <?php
        $SelfUserData = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Users\Users();
        $SelfData = $SelfUserData->GetUserLogged();
        ?>
        <form name = "contactForm" id = "contact-form" class = "contact-form" method = "post" action = "">
            <fieldset>
                <?php if ($SelfData) {
                    ?>
                    <div class="form-group">
                        <label>De: <?php echo $SelfData->Name . ' ' . $SelfData->Surname . '<br>' . $SelfData->Company; ?></label>
                    </div>
                    <div class="form-group">
                        <label>Para: <?php echo $User->Name . ' ' . $User->Surname . '<br>' . $User->Company; ?></label>
                    </div>
                    <input class="form-control" value="<?php echo $SelfData->Name . '' . $SelfData->Surname . ' - ' . $SelfData->Company; ?>" name="Name" id="Name" type="hidden"/>
                    <input class="form-control" value="<?php echo $SelfData->email; ?>" name="EmailFrom" id="EmailFrom" type="hidden"/>
                <?php } else { ?>
                    <div class="form-group">
                        <label>Nombre</label>
                        <div class="bg-warning form-alert" id="form-alert-name">Escriba su nombre</div>
                        <input class="form-control" value="" name="Name" id="Name" type="text" placeholder="Escriba su nombre aqu&iacute;" />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <div class="bg-warning form-alert" id="form-alert-email">Ingrese un E-mail v&aacute;lido</div>
                        <input class="form-control" value="" name="EmailFrom" id="EmailFrom" type="text" placeholder="Su E-mail" />
                    </div>
                <?php } ?>
                <div class="form-group">
                    <div class="bg-warning form-alert" id="form-alert-message">Escriba su mensaje</div>
                    <textarea class="form-control rezise-y" name="Message" id="Message" style="height: 150px;" placeholder="Escriba su mensaje aquí..."></textarea>
                </div>
                <div class="bg-warning alert-success form-alert" id="form-success">Su mensaje fu&eacute; enviado con &eacute;xito!</div>
                <div class="bg-warning alert-error form-alert" id="form-fail">Lo sentimos no se pudo enviar su mensaje.</div>
                <button id="send-message" onclick="sendmessage<?php echo $User->id ?>();" type="button" class="btn btn-primary">Enviar</button>
            </fieldset>
        </form>
    </div>
<?php } ?>
<div class="col-md-3" id="CompanyContactInfo">
    <h4>Informaci&oacute;n de contacto</h4>
    <?php if ($ValidateUser == TRUE) { ?>
        <ul class="list">
            <?php if($User->Address!=''){ ?><li><i class="fa fa-map-marker"></i> Direcci&oacute;n: <?php echo $User->Address; ?></li><?php } ?>
            <?php if($User->Phone!=''){ ?><li><i class="fa fa-phone"></i> Tel&eacute;fono: <?php echo $User->Phone; ?></li><?php } ?>
            <?php if($User->email!=''){ ?><li><i class="fa fa-envelope-o"></i> E-mail: <a href="mailto:<?php echo $User->email; ?>"><?php echo $User->email; ?></a></li><?php } ?>
            <?php if($User->website!=''){ ?><li><i class="fa fa-globe"></i> Web: <a href="<?php echo $User->website; ?>" target="_blank"><?php echo $User->website; ?></a></li><?php } ?>
        </ul>
    <?php } else { ?>
        <p><b>Necesita estar logueado para ver más información de contacto como Direción, Teléfono, Email, etc.</b></p>
        <a href="/UserRegistration" target="_blank"><img src="/_FileSystems/images/BannerRegistrarse.png" class="img-responsive" alt="Registrese Gratis para obtener los beneficios de la red"/></a>
        <?php } ?>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#map_canvas').html('<img src="http://maps.googleapis.com/maps/api/staticmap?center=' + MapLat + ',' + MapLon + '&zoom=' + MapZoom + '&size=600x400&maptype=roadmap&markers=color:green%7Clabel:%7C' + MapLat + ',' + MapLon + '&sensor=false" class="img-responsive">');
    });
    function sendmessage<?php echo $User->id ?>() {
        var Urlsendmessage = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Messenger/_Create');

        var error = false;
        var name = $('#Name').val();
        var email = $('#EmailFrom').val();
        var message = $('#Message').val();
        var alert = 'form-alert-';

        if (name.length == 0) {
            var error = true;
            $('#' + alert + 'name').fadeIn(500).delay(3000).fadeOut(500);
        } else {
            $('#' + alert + 'name').fadeOut(500);
        }
        if (email.length == 0 || email.indexOf('@') == '-1') {
            var error = true;
            $('#' + alert + 'email').fadeIn(500).delay(3000).fadeOut(500);
        } else {
            $('#' + alert + 'email').fadeOut(500);
        }
        if (message.length == 0) {
            var error = true;
            $('#' + alert + 'message').fadeIn(500).delay(3000).fadeOut(500);
        } else {
            $('#' + alert + 'message').fadeOut(500);
        }
        if (error == false) {
            $('#send-message').attr({'disabled': 'true', 'value': 'Enviando...'});
            var ID = '<?php echo $User->id; ?>';
            var EmailTo = '<?php echo $User->email; ?>';
            jQuery.ajax({
                'type': 'POST',
                'url': Urlsendmessage,
                'cache': false,
                'data': $('#contact-form').serialize() + '&ID=' + ID + '&EmailTo=' + EmailTo,
                'success': function (data) {
                    if ($.trim(data) == 'ok') {
                        $('#form-success').html('Mensaje enviado, gracias.').show();
                        $('#Name').val('').attr({'disabled': 'true', 'readonly': 'readonly'});
                        $('#EmailFrom').val('').attr({'disabled': 'true', 'readonly': 'readonly'});
                        $('#Message').val('').attr({'disabled': 'true', 'readonly': 'readonly'});
                        setTimeout(function () {
                            $('#form-success').hide().html('');
                        }, 3500);
                    } else if ($.trim(data) == 'error') {
                        $('#form-success').html('Parece que tenemos un problema.<br>Intente nuevamente mas tarde.').show();
                        setTimeout(function () {
                            $('#form-success').hide().html('');
                        }, 3500);
                    } else if ($.trim(data) == 'login') {
                        $('#form-success').html('Solo los usuarios registrados pueden enviar mensajes, <a href="/UserRegistration" target="_blank">Registrese aqu&iacute;</a> o inicie sesi&oacute;n.').show();
                    } else {
                        $('#form-success').html('Mmm...Intente nuevamente!').show();
                    }
                }
            });
        }
    }
</script>