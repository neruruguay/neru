<?php
$SKT_CC = new \CmsDev\CustomControl\LoadControl();
$Company = isset($_GET['usr']) ? $_GET['usr'] : 0;
$SKTDB = \CmsDev\Sql\db_Skt::connect();
$Query = "SELECT *
FROM users as user join userprofile as profile 
ON user.id = profile.IDX
WHERE user.isactive = '1' AND user.id = " . GetSQLValueString($Company, "int") . "";
$User = $SKTDB->get_row($Query);

echo '<script>'
 . 'var MapAddress = "' . $User->Address . '";'
 . 'var MapLat = "' . $User->Lat . '";'
 . 'var MapLon = "' . $User->Lon . '";'
 . 'var MapZoom = ' . $User->zoom . ';'
 . 'var MapCompany = "' . $User->Company . '";'
 . 'var MapIcon = "' . \SKT_URL_BASE . $User->ClientAuth_picture . '";'
 . 'var MapPhone = "' . $User->Phone . '";'
 . 'var MapEmail = "' . $User->email . '";'
 . '</script>';
$ValidateUser = \CmsDev\Security\loginIntent::action('validate');
$ValidateSelfUser = \CmsDev\Security\loginIntent::action('validate', 'SelfUser', $User->id);
$ValidateAction = isset($_GET['uAction']) ? $_GET['uAction'] : '0';
$DirectoryCompany = dirname(__FILE__) . DS . 'Company' . DS;
$DirectoryUser = dirname(__FILE__) . DS . 'User' . DS;

$CCParams_Products_List = array('id' => $User->id, 'User' => $User);

if ($User->level === 'Publishers') {
    ?>
    <div class="container Company-page">
        <div class="row row-wrap">
            <div class="alert alert-info" id="SKT_UpdateDataInfo" style="display: none;"></div>
            <?php
//        var_dump($_SESSION);
//        var_dump($_GET);
            if ($User) {
                if ($ValidateSelfUser === TRUE && $User->ViewHelp != 0) {
                    require ($DirectoryCompany . 'ViewHelpFirstTime.php');
                }
                if ($ValidateSelfUser === TRUE && $_GET['uAction'] == 'Resumen') {
                    require ($DirectoryCompany . 'Resumen.php');
                } elseif ($ValidateSelfUser === TRUE && $_GET['uAction'] == 'Edit') {
                    require ($DirectoryCompany . 'Edit.php');
                } elseif ($ValidateSelfUser === TRUE && $_GET['uAction'] == 'Messager') {
                    require ($DirectoryCompany . 'Messager.php');
                } elseif ($ValidateSelfUser === TRUE && $_GET['uAction'] == 'Publisher') {
                    require ($DirectoryCompany . 'Publisher.php');
                } elseif ($ValidateSelfUser === TRUE && $_GET['uAction'] == 'Design') {
                    require ($DirectoryCompany . 'Design.php');
                } elseif ($ValidateSelfUser === TRUE && $_GET['uAction'] == 'Help') {
                    require ($DirectoryCompany . 'Help.php');
                } else {
                    require ($DirectoryCompany . 'PublicProfile.php');
                }
            } else {
                require ($DirectoryCompany . '404.php');
            }
            ?>
        </div>
        <div class="gap gap-small"></div>
    </div>
    <?php
} else {

    if ($User) {
        ?>
        <div class="container Company-page mt40">
            <div class="row">
                <div class="col-md-3">
                    <img src="<?php echo $User->ClientAuth_picture; ?>" alt="" class="img-responsive img-thumbnail img-circle mt0 mb40" style="width: 40%"/>
                </div>
                <div class="col-md-9">
                    <h1><?php echo $User->Name; ?> <?php echo $User->Surname; ?></h1>
                    <?php if ($ValidateUser == TRUE) { ?>
<!--                    <p><?php echo $User->email; ?></p>-->
                    <p><?php echo $User->Description; ?></p>
                        <?php } else { ?>
                    <p class="mt40 mb40">Registrate o inicia sesión para acceder a esta información.</p>
                        <div class="wrapper-login-admin">
                            <div class="login-admin" style="width: 300px;">
                                <ul class="tabs nav nav-tabs">
                                    <li class="active"><a href="UserLogin">Iniciar sesi&oacute;n</a></li>
                                    <li><a href="UserRegistration">Registrarse</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active center" id="login">
                                        <?php $LoginFormUser = new \CmsDev\Security\LoginFormUser(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="alert alert-info" id="SKT_UpdateDataInfo" style="display: none;"></div>
                <div class="col-md-12">
                    <?php
                    if (($ValidateSelfUser == TRUE && $User->ViewHelp != 0) || ($ValidateSelfUser == TRUE && $_GET['uAction'] == 'Help')) {
                        require ($DirectoryUser . 'ViewHelpFirstTime.php');
                    }
                    if ($ValidateSelfUser == TRUE && $_GET['uAction'] == 'Resumen') {
                        require ($DirectoryUser . 'Resumen.php');
                    } elseif ($ValidateSelfUser == TRUE && $_GET['uAction'] == 'Edit') {
                        require ($DirectoryUser . 'Edit.php');
                    } elseif ($ValidateSelfUser == TRUE && $_GET['uAction'] == 'Messager') {
                        require ($DirectoryUser . 'Messager.php');
                    } elseif ($ValidateSelfUser == TRUE && $_GET['uAction'] == 'Publisher') {
                        require ($DirectoryUser . 'Publisher.php');
                    } elseif ($ValidateSelfUser == TRUE && $_GET['uAction'] == 'Design') {
                        require ($DirectoryUser . 'Design.php');
                    } elseif ($ValidateSelfUser == TRUE && $_GET['uAction'] == 'Help') {
                        require ($DirectoryUser . 'Help.php');
                    } else {
                        require ($DirectoryUser . 'PublicProfile.php');
                    }
                    ?>
                </div>
            </div>
            <div class="gap gap-small"></div>
        </div>
        <?php
    } else {
        require ($DirectoryCompany . '404.php');
    }
}
?>
