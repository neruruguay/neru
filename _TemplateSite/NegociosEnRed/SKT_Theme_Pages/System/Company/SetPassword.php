<div class="row">
    <h4 class="text-color skt-icon-rewrite"> Cambia tu contrase&ntilde;a</h4>
    <div class="alert alert-info">Verifica que tenga m&aacute;s de 6 caracteres, es recomendable que incorpore letras y n&uacute;meros sin espacios.</div>
    <div class="gap"></div>
    <div class="col-md-6 col-sm-12 col-xs-12">
        <form class="dialog-form" id="f<?php echo $User->token; ?>">
            <input type="hidden" name="ID" value="<?php echo $User->id; ?>">
            <input type="hidden" name="token" value="<?php echo $User->token; ?>">
            <div id="PasswordChange">
                <div class="form-group">
                    <input name="password" id="password" type="password" placeholder="Escriba su nueva contraseña" class="form-control">
                </div>
                <div class="form-group">
                    <input name="password2" id="password2" type="password" placeholder="Confirme su nueva contraseña" class="form-control">
                </div>
                <div class="gap"></div>
                <input type="button" value="Confirmar nueva contrase&ntilde;a" id="U<?php echo $User->token; ?>" class="btn btn-primary">
            </div>
            <div class="validateTips"></div>
        </form>

    </div>
</div>

<script type="text/javascript">
    $('#U<?php echo $User->token; ?>').click(function () {
        U<?php echo $User->token; ?>();
    });

    function U<?php echo $User->token; ?>() {
        var passwordok = false;
        var password = $('#password').val();
        var password2 = $('#password2').val();
        if (password == password2 && password2 != '' && password2.length >= 6) {
            passwordok = true;
        } else {
            $('#f<?php echo $User->token; ?> .validateTips').html('Las contrase&ntilde;as no coinciden, verifique tambi&eacute;n que tenga m&aacute;s de 6 caracteres.');
            passwordok = false;
        }
        if (passwordok == true) {
            var UrlUserPasswordRecovery = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Users/UserUpdatePassword');
            jQuery.ajax({
                'type': 'POST',
                'url': UrlUserPasswordRecovery,
                'cache': false,
                'data': $('#f<?php echo $User->token; ?>').serialize(),
                'success': function (data) {
                    $('#f<?php echo $User->token; ?> .validateTips').html(data);
                }
            });
        }
    }
</script>