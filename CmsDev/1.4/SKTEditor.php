<?php
if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
    $SKTDB = \CmsDev\sql\db_Skt::connect();
    $sup = $SKTDB->get_row("SELECT * FROM site WHERE TemplateSite = " . GetSQLValueString(\SKT_TEMPLATE, 'text') . "");
    if ($sup) {
        $s = $sup->s;
        $u = $sup->u;
        $p = $sup->p;
        $e = $sup->e;
        $r = $sup->r;
    } else {
        $s = $u = $p = $e = $r = 'free';
    }
    $View_DesignCMSValue = isset($_SESSION['View_DesignCMS']) ? $_SESSION['View_DesignCMS'] : 0;
    $View_DesignCMSValueCookie = isset($_COOKIE['View_DesignCMS']) ? $_COOKIE['View_DesignCMS'] : 0;
    ?>

    <div id="skt-menu-admin" class="skt SKTNotRemove">
        <ul class="skt-menu-main"  id="skt-menu-admin-ui">
            <li class="skt-trigger">
                <a class="skt-icon-menu skt-icon-menu-3lines"><span class="hidden">Menu</span></a>
                <nav class="skt-menu-wrapper">
                    <div class="skt-scroller">
                        <ul class="skt-menu">
                            <li id="PanelActionAdd" title="<?php echo \SKT_ADMIN_TasksTitle ?>">
                                <form action="" method="post" id="ActionAdd">
                                    <input name="Action" id="Action" type="hidden" value="" />
                                    <?php
                                    if (!_iscurlinstalled()) {
                                        $MessageBox2 = CmsDev\Info\Asistance::get();
                                        $MessageBox2->TipError(\SKT_ADMIN_CUrlError, false);
                                    };

                                    echo '<div style="display:none">';

                                    $url = parse_url(\SERVER_DIR);
                                    $k = $v = 0;
                                    $data = $dd = $sktauth = $sktexp = $l = $v1 = $v2 = $k1 = $k2 = $taskssend = $lic = $ext = $file = '';
                                    $skt = 'aHR0cDovL2xpY2Vuc2UuY21zLWRldi5jb20v';
                                    $sktp = 'aHR0cDovL2xpY2Vuc2UuY21zLWRldi5jb20vcHJvbW8v';
                                    $skti = 'aHR0cDovL2xpY2Vuc2UuY21zLWRldi5jb20vaW5mby8';
                                    $dir = \SKTPATH_FileSystems;
                                    $tasks = array('Add_Pages' => 1, 'Add_Link' => 1, 'Add_Photo' => 1, 'Add_Note' => 1, 'EditLicense' => 1, 'FilesAndFolders' => 1, 'EditAccess' => 1, 'Add_html' => 1, 'Add_txt' => 1, 'Add_Custom' => 1, 'EditLanguage' => 1, 'EditUsers' => 1, 'Add_Product' => 1);
                                    $AdmAct[1] = "Q1JVRC9TZWN0aW9uL0FkZA"; // Section
                                    $AdmAct[2] = "Q1JVRC9IVE1ML0FkZA"; // HTML
                                    $AdmAct[3] = "Q1JVRC9QbGFpblRleHQvQWRk"; // PlainText
                                    $AdmAct[4] = "Q1JVRC9DdXN0b21Db250cm9sL0FkZA"; //CC
                                    $AdmAct[5] = "QWRtaW5GaWxlc3lzdGVtL2luZGV4X1BvcFVw"; // FileSystems
                                    $AdmAct[6] = "Q1JVRC9BY2Nlc3MvU2VraXRvQWNjZXNz"; // Access
                                    $AdmAct[7] = "Q1JVRC9Qcm9kdWN0L0FkZA"; // Products
                                    $AdmAct[8] = "Q1JVRC9Ob3RlL0FkZA"; // Note
                                    $AdmAct[9] = "Q1JVRC9JbWFnZS9BZGQ"; // Image
                                    $AdmAct[10] = "Q1JVRC9MYW5ndWFnZS9FZGl0"; // Language
                                    $AdmAct[11] = "Q1JVRC9Vc2VyL1VzZXI"; // User
                                    $AdmAct[12] = "U2VjdXJpdHkvTGljZW5zZQ"; // License
                                    $AdmAct[13] = "Q1JVRC9MaW5rL0FkZA"; // Link

                                    if (is_dir($dir)) {
                                        $dh = \opendir($dir);
                                        while (($file = readdir($dh)) !== false) {
                                            $ext = strtolower(substr($file, strrpos($file, ".") + 1, 3));
                                            if ($ext == 'skt') {
                                                $lic.=str_replace('.skt', '', $file) . '*';
                                                $Localdata = \file_get_contents(\SKTPATH_FileSystems . $file, true);
                                            }
                                        }
                                        closedir($dh);
                                    }
                                    //$Localdata = '0*0|0*0|0*0|PGRsIGlkPVwiZHJvcGRvd25cIiBjbGFzcz1cImRyb3Bkb3duXCI%2BPGR0PjxhIGhyZWY9XCJqYXZhc2NyaXB0OnZvaWQoMClcIj48c3Bhbj5bVGFza3NUaXRsZV08L3NwYW4%2BPC9hPjwvZHQ%2BPGRkPjx1bD48bGk%2BPGEgaHJlZj1cImphdmFzY3JpcHQ6dm9pZCgwKVwiPjxzcGFuIGNsYXNzPVwidWktaWNvbiB1aS1pY29uLWRvY3VtZW50XCI%2BPC9zcGFuPltUYXNrczFdPHNwYW4gY2xhc3M9XCJ2YWx1ZVwiPjE8L3NwYW4%2BPC9hPjwvbGk%2BPGxpPjxhIGhyZWY9XCJqYXZhc2NyaXB0OnZvaWQoMClcIj48c3BhbiBjbGFzcz1cInVpLWljb24gdWktaWNvbi1saW5rXCI%2BPC9zcGFuPltUYXNrczEzXSA8c3BhbiBjbGFzcz1cInZhbHVlXCI%2BMTM8L3NwYW4%2BPC9hPjwvbGk%2BPGxpPjxhIGhyZWY9XCJqYXZhc2NyaXB0OnZvaWQoMClcIj48c3BhbiBjbGFzcz1cInVpLWljb24gdWktaWNvbi1pbWFnZVwiPjwvc3Bhbj5bVGFza3M5XSA8c3BhbiBjbGFzcz1cInZhbHVlXCI%2BOTwvc3Bhbj48L2E%2BPC9saT48bGk%2BPGEgaHJlZj1cImphdmFzY3JpcHQ6dm9pZCgwKVwiPjxzcGFuIGNsYXNzPVwidWktaWNvbiB1aS1pY29uLWNvbW1lbnRcIj48L3NwYW4%2BW1Rhc2tzOF0gPHNwYW4gY2xhc3M9XCJ2YWx1ZVwiPjg8L3NwYW4%2BPC9hPjwvbGk%2BPGxpPjxhIGhyZWY9XCJqYXZhc2NyaXB0OnZvaWQoMClcIj48c3BhbiBjbGFzcz1cInVpLWljb24gdWktaWNvbi1jb21tZW50XCI%2BPC9zcGFuPltUYXNrczJdIDxzcGFuIGNsYXNzPVwidmFsdWVcIj4yPC9zcGFuPjwvYT48L2xpPjxsaT48YSBocmVmPVwiamF2YXNjcmlwdDp2b2lkKDApXCI%2BPHNwYW4gY2xhc3M9XCJ1aS1pY29uIHVpLWljb24tZG9jdW1lbnRcIj48L3NwYW4%2BW1Rhc2tzN10gPHNwYW4gY2xhc3M9XCJ2YWx1ZVwiPjc8L3NwYW4%2BPC9hPjwvbGk%2BPGxpPjxhIGhyZWY9XCJqYXZhc2NyaXB0OnZvaWQoMClcIj48c3BhbiBjbGFzcz1cInVpLWljb24gdWktaWNvbi1zY3JpcHRcIj48L3NwYW4%2BW1Rhc2tzM10gPHNwYW4gY2xhc3M9XCJ2YWx1ZVwiPjM8L3NwYW4%2BPC9hPjwvbGk%2BPGxpPjxhIGhyZWY9XCJqYXZhc2NyaXB0OnZvaWQoMClcIj48c3BhbiBjbGFzcz1cInVpLWljb24gdWktaWNvbi1zY3JpcHRcIj48L3NwYW4%2BW1Rhc2tzNF0gPHNwYW4gY2xhc3M9XCJ2YWx1ZVwiPjQ8L3NwYW4%2BPC9hPjwvbGk%2BPGxpPjxhIGhyZWY9XCJqYXZhc2NyaXB0OnZvaWQoMClcIj48c3BhbiBjbGFzcz1cInVpLWljb24gdWktaWNvbi1jYWxjdWxhdG9yXCI%2BPC9zcGFuPltUYXNrczE0XSA8c3BhbiBjbGFzcz1cInZhbHVlXCI%2BMTQ8L3NwYW4%2BPC9hPjwvbGk%2BPGxpPjxhIGhyZWY9XCJqYXZhc2NyaXB0OnZvaWQoMClcIj48c3BhbiBjbGFzcz1cInVpLWljb24gdWktaWNvbi1mb2xkZXItb3BlblwiPjwvc3Bhbj5bVGFza3M1XSA8c3BhbiBjbGFzcz1cInZhbHVlXCI%2BNTwvc3Bhbj48L2E%2BPC9saT48bGk%2BPGEgaHJlZj1cImphdmFzY3JpcHQ6dm9pZCgwKVwiPjxzcGFuIGNsYXNzPVwidWktaWNvbiB1aS1pY29uLWZsYWdcIj48L3NwYW4%2BW1Rhc2tzMTBdIDxzcGFuIGNsYXNzPVwidmFsdWVcIj4xMDwvc3Bhbj48L2E%2BPC9saT48bGk%2BPGEgaHJlZj1cImphdmFzY3JpcHQ6dm9pZCgwKVwiPjxzcGFuIGNsYXNzPVwidWktaWNvbiB1aS1pY29uLWxvY2tlZFwiPjwvc3Bhbj5bVGFza3M2XSA8c3BhbiBjbGFzcz1cInZhbHVlXCI%2BNjwvc3Bhbj48L2E%2BPC9saT48bGk%2BPGEgaHJlZj1cImphdmFzY3JpcHQ6dm9pZCgwKVwiPjxzcGFuIGNsYXNzPVwidWktaWNvbiB1aS1pY29uLXBlcnNvblwiPjwvc3Bhbj5bVGFza3MxMV0gPHNwYW4gY2xhc3M9XCJ2YWx1ZVwiPjExPC9zcGFuPjwvYT48L2xpPjxsaT48YSBocmVmPVwiamF2YXNjcmlwdDp2b2lkKDApXCI%2BPHNwYW4gY2xhc3M9XCJ1aS1pY29uIHVpLWljb24ta2V5XCI%2BPC9zcGFuPltUYXNrczEyXSA8c3BhbiBjbGFzcz1cInZhbHVlXCI%2BMTI8L3NwYW4%2BPC9hPjwvbGk%2BPC91bD48L2RkPjwvZGw%2B';
                                    isset($url['host']) ? preg_match('/\w+\.\w+$/', $url['host'], $m) : null;
                                    $url = isset($m[0]) ? $m[0] : null;
                                    foreach ($tasks as $k => $v) {
                                        $taskssend .= "$k*$v,";
                                    }
                                    $h = new \CmsDev\Security\skt();
                                    $h->init();
                                    $data = $h->get(ludecsec($skt) . \SKT_VERSION . '/*/' . luencsec($s . $e . $u . $e . $p . $e . $r . $e . $url . $e . $taskssend . $e . $lic));
                                    echo "<div id='GoLicense'>" . ludecsec($skt) . \SKT_VERSION . '/*/' . luencsec($s . $e . $u . $e . $p . $e . $r . $e . $url . $e . $taskssend . $e . $lic) . "</div>";
                                    $h->close();
                                    if (!$data or $data == '') {
                                        $data = $Localdata;
                                    }
                                    list($sktauth, $sktexp, $l, $dd) = explode("|", $data);
                                    list($k1, $v1) = explode("*", $sktauth);
                                    list($k2, $v2) = explode("*", $sktexp);

                                    echo '<script type="text/javascript">var DATA = "' . ludecsec($skt) . luencsec($s . $e . $u . $e . $p . $e . $r . $e . $url . $e . $taskssend . $e . $lic) . '";';
                                    echo 'var AdmAct = new Array(12);';
                                    foreach ($AdmAct as $k => $v) {
                                        echo 'AdmAct[' . $k . '] = "' . $v . '"; ';
                                    }
                                    echo '</script></div>';

                                    echo \CmsDev\Language\RenderLang::Localdata(ludecsec($dd));
                                    ?>
                                </form>
                            </li>
                        </ul>
                    </div>
                </nav>
            </li>
            <li>
                <a href="javascript:AppSKT.TogglePageConfig();" title="<?php echo \SKT_ADMIN_TXT_Section_Properties ?>" class="sktToolTip">
                    <i class="skt-icon-page-config"></i>
                </a>
            </li>
            <li class="SKTViewModeSet sktToolTip" title="Intercambiar Vistas ( Edición / Previa )">
                <?php
                if (!(strcmp(0, $View_DesignCMSValue))) {
                    $check0 = "checked=\"checked\"";
                    $check1 = "";
                    $active0 = "active";
                    $active1 = "";
                } else {
                    $check1 = "checked=\"checked\"";
                    $check0 = "";
                    $active1 = "active";
                    $active0 = "";
                }
                ?>
                <span for="View_DesignCMS0" id="LabelView_DesignCMS0" class=" <?php echo $active0 ?>"  title="<?php echo \SKT_ADMIN_TXT_LabelView_DesignCMS0 ?>">
                    <i class="skt-icon-edit"></i>
                    <span>Vista de Edici&oacute;n</span>
                    <input type="radio" id="View_DesignCMS0" name="View_DesignCMS"  class="hidden" <?php echo $check0 ?> />
                </span>
                <span for="View_DesignCMS1" id="LabelView_DesignCMS1" class=" <?php echo $active1 ?>" title="<?php echo \SKT_ADMIN_TXT_LabelView_DesignCMS1 ?>">
                    <i class="skt-icon-view"></i>
                    <span>Vista de Dise&ntilde;o</span>
                    <input type="radio" id="View_DesignCMS1" name="View_DesignCMS" class="hidden" <?php echo $check1 ?> />
                </span>
            </li>
            <!--            <li>
                            <a class="sktToolTip" href="#" id="PrintScreen" title="Imprimir Pantalla">
                                <i class="skt-icon-image2"></i>
                            </a>
                        </li> -->
            <li>
                <a id="ViewEditElementsAsList2" class="ViewListEdition sktToolTip" target="_blank" href="<?php echo \URL_ViewEditElementsAsList; ?>"  title="<?php echo \SKT_ADMIN_TXT_ViewListEdition ?>">
                    <i class="skt-icon-view-2"></i>
                </a>
            </li> 
            <li>
                <a class="sktToolTip" href="<?php echo \URL_View_List_Index; ?>" id="GestorListas" target="_blank" title="Gestión de Listas">
                    <i class="skt-icon-list"></i>
                </a>
            </li>
            <li>
                <a class="sktToolTip" href="<?php echo \URL_SKTFSys; ?>" id="SKTFSystem" target="_blank" title="Sistema de Archivos">
                    <i class="skt-icon-folder-1"></i>
                </a>
            </li>
            <?php
            $errorlogs = new CmsDev\skt_error_log();
            if ($errorlogs->infologs() != 0) {
                ?>
                <li class="floatRight">
                    <a class="sktToolTip sktToolTip" href="<?php echo \URL_logs; ?>" title="View error logs" target="_blank">
                        <i class="skt-icon-error" style="position: relative; color: #E74C3C !important;"><span class="navbar-new"  style="font-size: 12px;font-style: normal;"><?php echo $errorlogs->infologs(); ?></span></i>
                    </a>
                </li>
            <?php } ?>
            <li class="floatRight">
                <a class="exit sktToolTip" href="<?php echo \SUBURL; ?>/CloseAdmin" title="<?php echo \SKT_ADMIN_TXT_CloseAdmin ?>">
                    <i class="skt-icon-exit"></i>
                    <span>Salir</span>
                </a>
            </li>
            <li class="floatRight">
                <a href="http://www.negociosenred.uy/" target="_blank" title="Versión <?php echo \SKT_VERSION ?>" class="sktToolTip">
                    <i class="skt-icon-sekito"></i>
                </a>
            </li>
            <li class="floatRight">
                <a href="<?php echo \SKTURL ?>SKT_HELP/index" target="_blank" title="HELP!" class="sktToolTip">
                    <i class="skt-icon-help"></i>
                </a>
            </li>
            <li class="floatRight">
                <a href="javascript:AppSKT.ToggleDefined();" title="Parámetros pre-definidos" class="sktToolTip"><i class="skt-icon-defined"></i></a>
            </li>
            <li class="floatRight">
                <div class="sktChangeStyle">
                    <div class="btn-group btn-group-xs sktToolTip" title="Posición" role="group" aria-label="...">
                        <button type="button" id="Normal" class="btn btn-default  skt-icon-up-open"></button>
                        <button type="button" id="Bottom" class="btn btn-default skt-icon-down-open"></button>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <script>
        $('body').addClass('skt-body-admin');
        new gnMenu(document.getElementById('skt-menu-admin-ui'));
    </script>

    <div id="SKTNotificationBox">
        <?php
        $h2 = new \CmsDev\Security\skt();
        $h2->init();
        $data2 = $h2->get(\SKT_VERSION . '/' . ludecsec($sktp) . luencsec($s . $e . $u . $e . $p . $e . $r . $e . $url . $e . $taskssend . $e . $lic));
        $h2->close();
        if ($data2 or $data2 !== '') {
            echo '<div id="SKTPromoBox">' . $data2 . '</div>';
        }
        $h3 = new \CmsDev\Security\skt();
        $h3->init();
        $data3 = $h3->get(\SKT_VERSION . '/' . ludecsec($skti) . luencsec($s . $e . $u . $e . $p . $e . $r . $e . $url . $e . $taskssend . $e . $lic));
        $h3->close();
        if ($data3 or $data3 !== '') {
            echo '<div id="SKTInfoBox">' . $data3 . '</div>';
        }
        ?>
    </div>
    <div class="preload"></div>

    <div style="display: none;" class="skt SKTNotRemove">

        <div id="PopUpEditorScript" title="Editando contenido">
            <div class="containerPopUpScript">
                <form action="" method="post">
                </form>
            </div>
        </div>
        <div id="dialog-ToggleDefined" title="Parámetros pre-definidos">
            <div class="containerPopUpDefined">
                <?php
                $definedParams = \CmsDev\Init\definedParams::get();
                $render = $definedParams->render();
                ?>
            </div>
        </div>
        <div id="dialog-TogglePageConfig" title="<?php echo \SKT_ADMIN_TXT_Section_Properties ?>">
            <div id="TogglePageConfig" class="skts_content">
                <div id="server_response_SectionData"></div>
                <div id="LoadAsync"></div>
                <div class="SKTrow">
                    <div class="col first">
                        <h3><i class="skt-icon-page-properties"></i><?php echo \SKT_ADMIN_Section_TXT_Config ?> - ID: <?php echo \SKT_SECTION_ID ?></h3>
                        <?php
                        include('CRUD/Section/SectionData.php');
                        ?>
                    </div>
                    <div class="col last">
                        <h3><i class="skt-icon-tags"></i><?php echo \SKT_ADMIN_Section_TXT_ConfigMeta; ?></h3>
                            <?php
                            include('CRUD/Section/SectionMeta.php');
                            ?>
                    </div>
                </div> 
            </div>
        </div>   
    </div>
<?php } ?>