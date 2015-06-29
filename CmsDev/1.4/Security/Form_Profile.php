<?php
$USER = new \CmsDev\Query\UserProfile();
$USER->GetDataSet();
if ($USER->UserOk === true) {
    ?>
    <form action="" method="post">
        <div class="container">
            <div class="row">

                <h1 class="PageTitle">Perfil de usuario</h1>
                <div class="cols cols6">
                    <section class="first col">
                        <img src="<?php echo $USER->user_list->ClientAuth_picture ?>" id="ImageProfile"/>
                    </section>
                    <section class="col5">
                        <div id="tabsUserProfile">
                            <ul>
                                <li class="active"><a href="<?php echo TOTAL_REQUEST ?>#tabs-1"><h1>1</h1> <span><?php echo SKT_ADMIN_CreateAccount_Tab1 ?></span> <h2>&RightArrow;</h2></a></li>
                                <li><a href="<?php echo TOTAL_REQUEST ?>#tabs-2"><h1>2</h1> <span><?php echo SKT_ADMIN_CreateAccount_Tab2 ?></span> <h2>&RightArrow;</h2></a></li>
                                <li><a href="<?php echo TOTAL_REQUEST ?>#tabs-3"><h1>3</h1> <span><?php echo SKT_ADMIN_CreateAccount_Tab3 ?></span> <h2>&RightArrow;</h2></a></li>
                                <li><a href="<?php echo TOTAL_REQUEST ?>#tabs-4"><h1>4</h1><span><?php echo SKT_ADMIN_CreateAccount_Tab4 ?></span> <h2>&RightArrow;</h2></a></li>
                            </ul>
                            <div id="tabs-1">
                                <div class="cols cols4" >
                                    <section class="first col2">
                                        <div class="login-box-name"><?php echo \SKT_ADMIN_TXT_username ?></div>
                                        <div class="login-box-field">
                                            <input name="username" class="form-login" title="<?php echo \SKT_ADMIN_TXT_username ?>" value="<?php echo $USER->user_list->username ?>" size="30" maxlength="30"  />
                                        </div>
                                        <div class="login-box-name"><?php echo \SKT_ADMIN_TXT_Email ?></div>
                                        <div class="login-box-field">
                                            <input name="email" class="form-login" title="<?php echo \SKT_ADMIN_TXT_Email ?>" value="<?php echo $USER->user_list->email ?>" size="30" maxlength="30"  />
                                        </div>
                                        <div class="login-box-name"><?php echo \SKT_ADMIN_TXT_Phone ?></div>
                                        <div class="login-box-field">
                                            <input name="Phone" class="form-login" title="<?php echo \SKT_ADMIN_TXT_Phone ?>" value="<?php echo $USER->user_list->Phone ?>" size="30" maxlength="30"  />
                                        </div>     
                                    </section>
                                    <section class="col2">
                                        <div class="login-box-name"><?php echo \SKT_ADMIN_TXT_Company ?></div>
                                        <div class="login-box-field">
                                            <input name="Company" class="form-login" title="<?php echo \SKT_ADMIN_TXT_Company ?>" value="<?php echo $USER->user_list->Company ?>" size="30" maxlength="30"  />
                                        </div>
                                        <div class="login-box-name"><?php echo \SKT_ADMIN_TXT_RUT ?></div>
                                        <div class="login-box-field">
                                            <input name="RUT" class="form-login" title="<?php echo \SKT_ADMIN_TXT_RUT ?>" value="<?php echo $USER->user_list->RUT ?>" size="30" maxlength="30"  />
                                        </div>
                                        <div class="login-box-name"><?php echo \SKT_ADMIN_TXT_Position ?></div>
                                        <div class="login-box-field">
                                            <input name="Position" class="form-login" title="<?php echo \SKT_ADMIN_TXT_Position ?>" value="<?php echo $USER->user_list->Position ?>" size="30" maxlength="30"  />
                                        </div>  
                                    </section>
                                    <div class="clear"></div>
                                </div>
                            </div>
                            <div id="tabs-2">
                                <div class="cols cols4" >
                                    <section class="first col2">
                                        <div class="login-box-name"><?php echo SKT_ADMIN_TXT_Email ?></div>
                                        <div class="login-box-field">
                                            <p><?php echo $USER->user_list->ClientAuth ?></p>
                                        </div>
                                        <div class="login-box-name"><?php echo SKT_ADMIN_TXT_Email ?></div>
                                        <div class="login-box-field">
                                            <p><?php echo $USER->user_list->ClientAuth_id ?></p>
                                        </div>
                                        <div class="login-box-name"><?php echo SKT_ADMIN_TXT_Email ?></div>
                                        <div class="login-box-field">
                                            <p><?php echo $USER->user_list->ClientAuth_link ?></p>
                                        </div>
                                        <div class="login-box-name"><?php echo SKT_ADMIN_TXT_Email ?></div>
                                        <div class="login-box-field">
                                            <p><?php echo $USER->user_list->ClientAuth_gender ?></p>
                                        </div>
                                    </section>
                                    <section class="col2">

                                    </section>
                                    <div class="clear"></div>
                                </div>
                            </div>
                            <div id="tabs-3">
                                <div class="cols cols4" >
                                    <section class="first col2">
                                        <div class="login-box-name"><?php echo SKT_ADMIN_TXT_Country ?></div>
                                        <div class="login-box-field">
                                            <input name="Country" class="form-login" title="<?php echo SKT_ADMIN_TXT_Country ?>" value="<?php echo $USER->user_list->Country ?>" size="30" maxlength="30"  />
                                        </div>
                                        <div class="login-box-name"><?php echo SKT_ADMIN_TXT_City ?></div>
                                        <div class="login-box-field">
                                            <input name="City" class="form-login" title="<?php echo SKT_ADMIN_TXT_City ?>" value="<?php echo $USER->user_list->City ?>" size="30" maxlength="30"  />
                                        </div>
                                        <div class="login-box-name"><?php echo SKT_ADMIN_TXT_CP ?></div>
                                        <div class="login-box-field">
                                            <input name="CP" class="form-login" title="<?php echo SKT_ADMIN_TXT_CP ?>" value="<?php echo $USER->user_list->CP ?>" size="30" maxlength="30"  />
                                        </div>
                                        <div class="login-box-name"><?php echo SKT_ADMIN_TXT_Address ?></div>
                                        <div class="login-box-field">
                                            <textarea name="Address" class="form-login" title="<?php echo SKT_ADMIN_TXT_Address ?>" ><?php echo $USER->user_list->Address ?></textarea>
                                        </div>
                                    </section>
                                    <section class="col2">
                                        <div class="login-box-name"><?php echo SKT_ADMIN_TXT_payment_method ?></div>
                                        <div class="login-box-field">
                                            <input name="payment_method" class="form-login" title="<?php echo SKT_ADMIN_TXT_payment_method ?>" value="<?php echo $USER->user_list->payment_method ?>" size="30" maxlength="30"  />
                                        </div>
                                        <div class="login-box-name"><?php echo SKT_ADMIN_TXT_From ?></div>
                                        <div class="login-box-field">
                                            <input name="From" class="form-login" title="<?php echo SKT_ADMIN_TXT_From ?>" value="<?php echo $USER->user_list->eFrom ?>" size="30" maxlength="30"  />
                                        </div>
                                        <div class="login-box-name"><?php echo SKT_ADMIN_TXT_To ?></div>
                                        <div class="login-box-field">
                                            <input name="To" class="form-login" title="<?php echo SKT_ADMIN_TXT_To ?>" value="<?php echo $USER->user_list->eTo ?>" size="30" maxlength="30"  />
                                        </div>
                                    </section>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="col6">
                        <input class="loginSend" type="submit" value="<?php echo SKT_ADMIN_Btn_Acept ?>"/>
                    </section>
                    <div class="clear"></div>
                </div>

            </div>
        </div>
        <?php \var_dump($USER); ?>
    </form>
    <script>
        $(function () {
            $("#tabsUserProfile").tabs();
            $("#tabsUserProfile ul li").hover(function () {
                $(this).addClass('ui-tabs-active active');
            }, function () {
                if ($(this).hasClass('ui-state-active') === false) {
                    $(this).removeClass('ui-tabs-active active');
                }
            });
        });
    </script>
<?php } else { ?>
    <div class="container">
        <div class="row">
            <h3 class="UserNoLogin color-error text-center">
                <i class="skt-icon-error size-4-i"></i>
                <br>Lo sentimos, <br>usted no ha iniciado sesión<br>o su sesión a expirado.
            </h3>
        </div>
    </div>
<?php } ?>
<div class="clear"></div>