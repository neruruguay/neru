<?php
$SKT_CC = new \CmsDev\CustomControl\LoadControl();
$Company = isset($_GET['usr']) ? $_GET['usr'] : 0;
$uAction = isset($_GET['uAction']) ? $_GET['uAction'] : 0;
?>

<div class="OnlyMobile mobile-fixed-top-area bg_color hidden-md hidden-lg">
    <a href="<?php echo \SKT_URL_BASE; ?>" class="logo">
        <img src="<?php echo SKTURL_TemplateSite; ?>assets/img/logo.png" class="img-responsive"  alt="Negocios en Red" title="Ir al inicio" />
    </a>
    <div id="showRightPush" class="flexnav-menu-button "><i class="skt-icon-menu-3lines"></i></div>
</div>
<nav class="OnlyMobile cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right hidden-md hidden-lg" id="RightPush">

    <?php $SKT_CC->Render('Menu'); ?>

</nav>
<div class="global-wrap">
    <header class="main hidden-sm hidden-xs main-color fixed">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <a href="<?php echo \SKT_URL_BASE; ?>" class="logo2">
                        <img src="<?php echo SKTURL_TemplateSite; ?>assets/img/logo.png" class="img-responsive" alt="Ir al inicio" title="Ir al inicio" />
                    </a>
                </div>
                <div class="col-md-6">
                    <div class="search-area hidden-sm hidden-xs">
                        <?php
                        $SKT_CC->Render('Search');
                        ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <ul class="login-register float-right">

                        <?php
                        $Markup_Google = new \CmsDev\google\oauth();
                        $googleUser = $Markup_Google->GoogleUser();
                        $GoogleLoginLink = $Markup_Google->createAuthUrl;
                        define('GoogleLoginLink', $GoogleLoginLink);
                        if (\CmsDev\Security\loginIntent::action('validate', 'UserBoxActions') === true) {
                            ?>
                            <?php
                            $UserBoxActions = new \CmsDev\Security\UserBoxActions();
                            echo "<li>" . $UserBoxActions->Render() . "</li>";
                            ?> 
                            <?php
                        } else {
                            ?>
                            <li class="mt10"><a class="popup-text" href="#login-dialog" onclick="javascript:ActivateRightPush();" data-effect="mfp-move-from-top"><i class="fa fa-sign-in"></i>Ingresar</a>
                            </li>
                            <li class="mt10"><a href="<?php echo \SKT_URL_BASE; ?>UserRegistration" onclick="javascript:ActivateRightPush();"><i class="fa fa-edit"></i>Registrarse</a>
                            </li>
                            <li class="mt10"><a class="ConnectGoogle" data-toggle="tooltip" data-placement="bottom"  title="Inicia sesi&oacute;n con Google Plus" href="<?php echo $GoogleLoginLink; ?>"><i class="fa fa-google-plus"></i></a>
                            </li>
<?php } ?>
                    </ul>
                    <div id="UserMenuStepOne"></div>
                </div>
            </div>
        </div>
        <div class="color">
            <div class="container">
                <nav>
                <?php $SKT_CC->Render('Menu'); ?>
                </nav>
<?php //echo $_SESSION['login']; ?>
            </div>
        </div>
    </header>

    <?php
    $SKT_CC->Render('PopUp');
    $SKT_CC->Render('login-register');
    \CmsDev\Template\Page::render();
    $SKT_CC->Render('Footer');
    ?>
</div>
<?php
include('footer.php');
include('analyticstracking.php');
?>
