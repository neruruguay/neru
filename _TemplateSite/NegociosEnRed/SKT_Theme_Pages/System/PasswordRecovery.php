<div class="gap"></div>
<div class="container">
    <section class="skts_content">
        <div class="row">
            <?php
            if (isset($_GET['codeValidate']) && $_GET['codeValidate'] != '' && isset($_GET['tokenValidate']) && $_GET['tokenValidate'] != '') {
                $Users = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\Users\_classes;
                $test = $Users->UserToken($_GET['codeValidate'], $_GET['tokenValidate']);
                if ($test) {
                    ?>
                    <div class="col-md-3 hidden-sm hidden-xs"></div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <h1>Hola <?php echo $test->Name ?>, cambia la contrase&ntilde;a y memorizala.</h1>
                        <div class="gap"></div>
                        <div class="alert alert-info">Verifique que tenga m&aacute;s de 6 caracteres, es recomendable que incorpore letras y n&uacute;meros sin espacios.</div>
                        <div class="gap"></div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <form class="dialog-form" id="f<?php echo $test->token; ?>">
                                    <input type="hidden" name="ID" value="<?php echo $test->id; ?>">
                                    <input type="hidden" name="token" value="<?php echo $test->token; ?>">
                                    <div id="PasswordChange">
                                        <div class="form-group">
                                            <input name="password" id="password" type="password" placeholder="Escriba su nueva contraseña" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <input name="password2" id="password2" type="password" placeholder="Confirme su nueva contraseña" class="form-control">
                                        </div>
                                        <div class="gap"></div>
                                        <input type="button" value="Confirmar nueva contrase&ntilde;a" id="U<?php echo $test->token; ?>" class="btn btn-primary">
                                    </div>
                                    <div class="validateTips"></div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 hidden-sm hidden-xs"></div>
                    <?php
                }
            }
            ?>
        </div>
    </section>
</div>
<script type="text/javascript">
    $('#U<?php echo $test->token; ?>').click(function () {
        U<?php echo $test->token; ?>();
    });

    function U<?php echo $test->token; ?>() {
        var passwordok = false;
        var password = $('#password').val();
        var password2 = $('#password2').val();
        if (password == password2 && password2 != '' && password2.length >= 6) {
            passwordok = true;
        } else {
            $('#f<?php echo $test->token; ?> .validateTips').html('Las contrase&ntilde;as no coinciden, verifique tambi&eacute;n que tenga m&aacute;s de 6 caracteres.');
            passwordok = false;
        }
        if (passwordok == true) {
            var UrlUserPasswordRecovery = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Users/UserUpdatePassword');
            jQuery.ajax({
                'type': 'POST',
                'url': UrlUserPasswordRecovery,
                'cache': false,
                'data': $('#f<?php echo $test->token; ?>').serialize(),
                'success': function (data) {
                    $('#f<?php echo $test->token; ?> .validateTips').html(data);
                }
            });
        }
    }
</script>