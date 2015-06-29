<div id="login-dialog" class="mfp-with-anim mfp-hide mfp-dialog clearfix">
    <i class="fa fa-sign-in dialog-icon"></i>
    <h3>Inicio de sesi&oacute;n</h3>
    <form class="dialog-form" action="<?php echo \SKT_URL_BASE; ?>UserLogin" method="POST">
        <div class="form-group">
            <label><?php echo SKT_ADMIN_User_Name ?></label>
            <input name="SKT_UserName" type="text" placeholder="" class="form-control" required>
        </div>
        <div class="form-group">
            <label><?php echo SKT_ADMIN_TXT_Password ?></label>
            <input name="SKT_Password" type="password" placeholder="" class="form-control" required>
        </div>
        <br>
        <input type="submit" value="<?php echo SKT_ADMIN_Btn_Acept ?>" class="btn btn-primary btn-block">
    </form>
    <ul class="dialog-alt-links row">
        <li class="col-md-12 btn-block ml0 mb30">
            <a href="<?php echo \GoogleLoginLink; ?>" class="skt-icon-google-plus btn btn-danger btn-block" title="Inicia sesi&oacute;n con Google Plus" target="_self">Inicia sesi&oacute;n con Google Plus</a>
        </li>
        <li class="col-md-5 mr0">
            <a href="<?php echo \SKT_URL_BASE; ?>UserRegistration" class="btn btn-default btn-block" target="_self">A&uacute;n no soy miembro</a>
        </li>
        <li class="col-md-6 mr0">
            <a class="popup-text btn btn-default btn-block" href="#password-recover-dialog" data-effect="mfp-zoom-out">Perd&iacute; mi clave</a>
        </li>
    </ul>
</div>

<div id="password-recover-dialog" class="mfp-with-anim mfp-hide mfp-dialog clearfix">
    <i class="skt-icon-access dialog-icon"></i>
    <h3>Recuperaci&oacute;n de contrase&ntilde;a</h3>
    <h5>Escriba su direcci&oacute;n de correo</h5>
    <form class="dialog-form" id="UPR">
        <div class="form-group">
            <label>E-mail</label>
            <input type="text" placeholder="email@dominio.com" name="PasswordRecovery" class="form-control" required>
        </div>
        <input type="button" id="GoUPR" value="Recuperar contrase&ntilde;a" class="btn btn-primary">
        <div class="validateTips"></div>
    </form>
    <ul class="dialog-alt-links">
        <li>
            <a href="<?php echo \SKT_URL_BASE; ?>UserRegistration" target="_self">A&uacute;n no soy miembro</a>
        </li>
        <li>
            <a class="popup-text" href="#login-dialog" data-effect="mfp-zoom-out">Ingresar</a>
        </li>
    </ul>
</div>
<script type="text/javascript">
    $('#GoUPR').click(function () {
        UserPasswordRecovery();
    });

    function UserPasswordRecovery() {
        var UrlUserPasswordRecovery = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Users/UserPasswordRecovery');
        jQuery.ajax({
            'type': 'POST',
            'url': UrlUserPasswordRecovery,
            'cache': false,
            'data': $('#UPR').serialize(),
            'success': function (data) {
                $('#UPR .validateTips').html(data);
            }
        });
    }
</script>