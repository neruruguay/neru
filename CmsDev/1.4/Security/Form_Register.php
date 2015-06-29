<?php
$randomize = rand(2, 65487);
$Type1 = 'selected="selected"';
$Type2 = '';
if (isset($_POST['PromoEmpresas'])) {
    $Type1 = '';
    $Type2 = 'selected="selected"';
}
?>
<div class="mb30" >
    <?php
    if (isset($_POST['username']) && $_POST['username'] != '' && isset($_POST['password']) && $_POST['password'] != '' && isset($_POST['password2']) && $_POST['password2'] != '' && isset($_POST['email']) && $_POST['email'] != '' && $_POST['password'] === $_POST['password2']) {
        echo \CmsDev\Security\UserRegister::checkAction($_POST);
        ?> 
        <?php
    } else {
        ?>   
        <div class="col-md-7">
            <h2 class="page-header"><i class="skt-icon-user-profile"></i> <?php echo SKT_ADMIN_TitleRegistration ?></h2>
            <div class="gap-small"></div>
            <form action="" method="post" id="SKTRegister" enctype="multipart/form-data">
                <input type="hidden" id="level" name="level" value="Publishers" />
                <input type="hidden" id="usernameValid" name="usernameValid" value="0" />
                <div class="col-md-12">
                    <h3><strong>1.</strong> <span>Finalidad del registro:</span></h3>
                    <div class="control-group ">
                        <div class="controls">
                            <select name="Type" class="form-control" id="Type">
                                <option value="Customers" <?php echo $Type1; ?>>Me interesa conocer las ofertas y poder ofertar/comprar solamente.</option>
                                <option value="Publishers" <?php echo $Type2; ?>>Represento a una empresa y quiero vender productos.</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="gap-small"></div>
                <hr>
                <div class="gap-small"></div>
                <div class="col-md-12">
                    <h3><strong>2.</strong> <span>Datos de Usuario</span></h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="control-group">
                                <label class="control-label" for="username">
                                    <?php echo SKT_ADMIN_TXT_username ?>
                                    <span class="form-required" title="Escriba un nombre de usuario o el de su empresa.">*</span>
                                </label>
                                <div class="controls">
                                    <input type="text" name="username" id="username" class="form-control" value="" placeholder="<?php echo SKT_ADMIN_TXT_username ?>" required  onblur="CheckUserName(this.value, 'infoUsername');"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6"><p id="infoUsername"><span style="color:black !important">Escriba el nombre sin espacios, puntos ni carcteres especiales</span></p></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="control-group ">
                                <label class="control-label" for="password">
                                    <?php echo SKT_ADMIN_TXT_Password ?>
                                    <span class="form-required" title="Campo requerido">*</span>
                                </label>
                                <div class="controls">
                                    <input name="password" id="password" type="password" class="form-control" value="" placeholder="<?php echo SKT_ADMIN_TXT_Password ?>" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="control-group ">
                                <label class="control-label" for="password2">
                                    <?php echo SKT_ADMIN_User_Password2 ?>
                                    <span class="form-required" title="Campo requerido">*</span>
                                </label>
                                <div class="controls">
                                    <input name="password2" id="password2" type="password" class="form-control" value="" placeholder="<?php echo SKT_ADMIN_User_Password2 ?>" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr><br>
                    <div id="UserTypeData"></div>
                </div>
                <div class="clearfix"></div>
                <hr><br>
                <div class="col-md-12 validatemail_tips  alert" style="padding: 7px 7px 14px 18px; color: #ff3300">
                    <p>Complete todos los campos.</p>
                </div>
                <div class="col-md-12 text-right">
                    <h3>
                        <button id="NextStepRegister" type="button" class="btn btn-large btn-primary btn-block"><i class="skt-icon-right-open-1"></i> Validar Registro</button>
                        <button id="SendRegister" style="display: none;" type="submit" class="btn btn-large btn-primary btn-block btn-mega"><i class="skt-icon-acept"></i> Finalizar env&iacute;o de Registro</button>
                    </h3>
                </div>
            </form>
            <div id="FormPublishers" style="display: none;">
                <h3><strong>3.</strong> <span>Datos de empresa / Contacto</span></h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="control-group ">
                            <label class="control-label" for="Company">
                                <?php echo SKT_ADMIN_TXT_name . ' de ' . SKT_ADMIN_TXT_Company ?>
                                <span class="form-required" title="Campo requerido">*</span>
                            </label>
                            <div class="controls">
                                <input type="text" name="Company" id="Company" class="form-control" value="" placeholder="<?php echo SKT_ADMIN_TXT_name . ' de ' . SKT_ADMIN_TXT_Company ?>" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="control-group">
                            <label class="control-label" for="RUT">
                                <?php echo SKT_ADMIN_TXT_RUT ?>
                                <span class="form-required" title="Campo requerido">*</span>
                            </label>
                            <div class="controls">
                                <input type="text" name="RUT" id="RUT" class="form-control" value="" placeholder="<?php echo SKT_ADMIN_TXT_RUT ?>" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 hidden">
                        <div class="control-group">
                            <label class="control-label" for="Address">
                                <?php echo SKT_ADMIN_TXT_Address ?>
                            </label>
                            <div class="controls">
                                <input type="text" name="Address" id="Address" class="form-control" value="" placeholder="<?php echo SKT_ADMIN_TXT_Address ?>" />

                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="control-group ">
                            <label class="control-label" for="Name">
                                <?php echo SKT_ADMIN_TXT_name ?> del contacto
                                <span class="form-required" title="Campo requerido">*</span>
                            </label>
                            <div class="controls">
                                <input type="text" name="Name" id="Name" class="form-control" value="" placeholder="<?php echo SKT_ADMIN_TXT_name ?> del contacto" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="control-group ">
                            <label class="control-label" for="Surname">
                                <?php echo SKT_ADMIN_TXT_surname ?>
                                <span class="form-required" title="Campo requerido">*</span>
                            </label>
                            <div class="controls">
                                <input type="text" name="Surname" id="Surname" class="form-control" value="" placeholder="<?php echo SKT_ADMIN_TXT_surname ?>" required />

                            </div>
                        </div>
                    </div>   
                    <div class="col-md-4 hidden">
                        <div class="control-group ">
                            <label class="control-label" for="Position">
                                <?php echo SKT_ADMIN_TXT_Position ?>
                            </label>
                            <div class="controls">
                                <input type="text" name="Position" id="Position" class="form-control" placeholder="<?php echo SKT_ADMIN_TXT_Position ?>" value="" />

                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="control-group">
                            <label class="control-label" for="email">
                                <span class="form-required" title="Campo requerido">*</span>
                            </label>
                            <div class="controls">
                                <input type="text" name="email" id="email" class="form-control" value="" placeholder="<?php echo SKT_ADMIN_TXT_Email ?>" required />

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="control-group ">
                            <label class="control-label" for="Phone">
                                <?php echo SKT_ADMIN_TXT_Phone ?>(s)
                                <span class="form-required" title="Campo requerido">*</span>
                            </label>
                            <div class="controls">
                                <input name="Phone" id="Phone" class="form-control" value="" placeholder=" <?php echo SKT_ADMIN_TXT_Phone ?>(s)"  required />
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
            <div id="FormCustomers" style="display: none;">
                <div class="row">
                    <div class="col-md-4">
                        <div class="control-group ">
                            <label class="control-label" for="Name">
                                <?php echo SKT_ADMIN_TXT_name ?>
                                <span class="form-required" title="Campo requerido">*</span>
                            </label>
                            <div class="controls">
                                <input type="text" name="Name" id="Name" class="form-control" value="" placeholder="<?php echo SKT_ADMIN_TXT_name ?>" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="control-group ">
                            <label class="control-label" for="Surname">
                                <?php echo SKT_ADMIN_TXT_surname ?>
                                <span class="form-required" title="Campo requerido">*</span>
                            </label>
                            <div class="controls">
                                <input type="text" name="Surname" id="Surname" class="form-control" value="" placeholder="<?php echo SKT_ADMIN_TXT_surname ?>" required />

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="control-group ">
                            <label class="control-label" for="Phone">
                                <?php echo SKT_ADMIN_TXT_Phone ?>(s)
                                <span class="form-required" title="Campo requerido">*</span>
                            </label>
                            <div class="controls">
                                <input name="Phone" id="Phone" class="form-control" value="" placeholder="<?php echo SKT_ADMIN_TXT_Phone ?>(s)" required />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="control-group">
                            <label class="control-label" for="email">
                                <?php echo SKT_ADMIN_TXT_Email ?>
                                <span class="form-required" title="Campo requerido">*</span>
                            </label>
                            <div class="controls">
                                <input type="text" name="email" id="email" class="form-control" value="" placeholder="<?php echo SKT_ADMIN_TXT_Email ?>" required />

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <?php
            if (isset($_POST['PromoEmpresas'])) {
                ?>
                <img src="/_FileSystems/Banners/PromoEmpresas.jpg" alt="" class="img-responsive img-rounded"/>
                <?php
            }
            ?>
        </div>
    <?php } ?>

</div>
<div class="clearfix"></div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#NextStepRegister').click(function () {
            NextStepRegister();
        });
        $('#Type').change(function () {
            var fields = "#Form";
            $("#Type option:selected").each(function () {
                fields = fields + $(this).val() + "";
            });
            //alert(fields);
            $("#UserTypeData").html($(fields).html());
            $("#level").val($(this).val());
        }).change();

    });
    //CheckUserName
    function CheckUserName(UserName, infoid) {
        $.post(URL_CheckUserName, {UserName: UserName, rand: Math.random()}, function (data) {
            if ($.trim(data) === 'exist') {
                $('#' + infoid).html('<i class="skt-icon-error"></i>El usuario ya existe, intente una variante.');
                $('#usernameValid').val(0);
            } else if ($.trim(data) === '') {
                $('#' + infoid).html('<i class="skt-icon-error"></i>Escriba un nombre de usuario.');
                $('#usernameValid').val(0);
            } else {
                $('#' + infoid).html('<span style="color:green !important"><i class="skt-icon-ok"></i>El usuario es v&aacute;lido.</span>');
                $('#username').val($.trim(data));
                $('#usernameValid').val('valid');
            }
        });
    }
    /*-----------------------------------------------  MAIL  ----------------------------------------------------------------*/
    function Register_updateTips(t) {
        var Register_tips = $(".validatemail_tips");
        Register_tips
                .html('<p>' + t + '</p>');
        setTimeout(function () {
            Register_tips.find('p').hide('slow');
        }, 5000);
    }
    function Register_checkLength(o, n, min, max) {
        $('.control-group').removeClass('has-error');
        if (o.val().length > max || o.val().length < min) {
            o.closest('.control-group').addClass('has-error').focus();
            if (max == min) {
                Register_updateTips("El campo \"<b>" + n + "</b>\"  es requerido y tiene ser de " + min + "caracteres.");
            } else {
                Register_updateTips("El campo \"<b>" + n + "</b>\"  es requerido y tiene que ser entre " + min + " y " + max + " caracteres.");
            }
            return false;
        } else {
            return true;
        }
    }
    function Register_checkValidUser() {
        if ($('#usernameValid').val() === 'valid') {
            return true;
        } else {
            $('#username').closest('.control-group').addClass('has-error').focus();
            Register_updateTips("Nombre de usuario no es v&aacute;lido.");
            return false;
        }
    }
    function Register_checkPassword(p, p2) {
        if (p.val() === p2.val() && p.val().length >= 6) {
            return true;
        } else {
            p.closest('.control-group').addClass('has-error').focus();
            p2.closest('.control-group').addClass('has-error');
            Register_updateTips("Las contrase&ntilde;as no cohinciden y tienen que tener al menos 6 caracteres.");
            return false;
        }
    }
    function Register_checkRegexp(o, regexp, n) {

        $('.control-group').removeClass('has-error');

        if (!(regexp.test(o.val()))) {
            o.closest('.control-group').addClass('has-error').focus();
            Register_updateTips(n);
            return false;
        } else {
            return true;

        }
        return true;
    }

    function NextStepRegister() {
        var Register_allFields = '';
        var username = $("#SKTRegister #username"),
                password = $("#SKTRegister #password"),
                password2 = $("#SKTRegister #password2"),
                Company = $("#SKTRegister #Company"),
                RUT = $("#SKTRegister #RUT"),
                Address = $("#SKTRegister #Address"),
                Name = $("#SKTRegister #Name"),
                Surname = $("#SKTRegister #Surname"),
                Position = $("#SKTRegister #Position"),
                email = $("#SKTRegister #email"),
                Phone = $("#SKTRegister #Phone")
        Register_allFields = $([]).add(username).add(password).add(password2).add(Company).add(RUT).add(Address).add(Name).add(Surname).add(Position).add(email).add(Phone);

        var bValid = true;
        Register_allFields.removeClass('has-error');
        bValid = bValid && Register_checkLength(username, "Nombre de usuario, sin espacios, puntos ni caracteres especiales", 3, 30);
        bValid = bValid && Register_checkValidUser();
        bValid = bValid && Register_checkLength(password, "Contrase&ntilde;a", 6, 20);
        bValid = bValid && Register_checkPassword(password, password2);

        if ($("#Type option:selected").val() == 'Vendedor') {
            bValid = bValid && Register_checkLength(Company, "Nombre de la empresa", 3, 30);
            bValid = bValid && Register_checkLength(RUT, "RUT", 12, 12);
        }
        //bValid = bValid && Register_checkLength(Address, "Ubicación de la empresa", 3, 250);
        bValid = bValid && Register_checkLength(Name, "Nombre de contacto", 3, 50);
        bValid = bValid && Register_checkLength(Surname, "Apellido", 3, 50);
        //bValid = bValid && Register_checkLength(Position, "Cargo del contacto", 3, 60);
        bValid = bValid && Register_checkRegexp(email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "E-Register example: nombre@empresa.com");
        //bValid = bValid && Register_checkLength(Phone, "Tel&eacute;fono(s) de la empresa", 3, 30);
        if (bValid) {
            $('#NextStepRegister').hide();
            $('.validatemail_tips').hide();
            $('#SendRegister').show();
        }
    }

</script>

