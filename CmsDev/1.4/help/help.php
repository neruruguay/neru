<?php
$glob = \CmsDev\util\globals::init();
$SKT = $glob->getVar('SKT');
if (\CmsDev\Security\loginIntent::action('validateAdmin') === true) {
    $SKT_Header = \CmsDev\Header\Make::instance();
    $SKT_Header->lang('es');
    $SKT_Header->charset('windows-1252');
    $SKT_Header->base(\SKT_URL_BASE);
    $SKT_Header->custom("<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,800,600' rel='stylesheet' type='text/css'>"
            . "<style>"
            . "body{font-family:'Open Sans'; font-size:12px; padding-top: 0 !important; }"
            . "</style>");
    echo $SKT_Header->RenderHeader();
    if (!isset($Page)) {
        $Page = 'index';
    }
    define('SKTURL_HELP', \SKTURL . 'SKT_HELP/');
    ?>
    <body>
        <div id="wrapper">
            <div class="mobile">
                <input type="checkbox" id="tm" />
                <ul class="sidenav">
                    <li><a href="<?php echo \SKTURL ?>SKT_HELP/index"><i class="skt-icon-CmsDev"></i><b>Introducción</b></a></li>
                    <li><a href="#"><i class="skt-icon-upload"></i><b>Instalación</b></a></li>
                    <li><a href="#"><i class="skt-icon-config"></i><b>Configuración</b></a></li>
                    <li><a href="#"><i class="skt-icon-language"></i><b>Idiomas</b></a></li>
                    <li><a href="#"><i class="skt-icon-glyph-9"></i><b>Temas</b></a></li>
                    <li><a href="#"><i class="skt-icon-theme-layout"></i><b>Layouts</b></a></li>
                    <li><a href="#"><i class="skt-icon-page"></i><b>Páginas</b></a></li>
                    <li><a href="#"><i class=" skt-icon-control"></i><b>Contenidos</b></a>
                        <ul>
                            <li><a href="#"><i class="skt-icon-link"></i><b>Vínculos en los menú</b></a></li>
                            <li><a href="#"><i class="skt-icon-image"></i><b>Agregar imagen</b></a></li>
                            <li><a href="#"><i class="skt-icon-video"></i><b>Agregar Video</b></a></li>
                            <li><a href="#"><i class="skt-icon-html"></i><b>Agregar Contenido HTML</b></a></li>
                            <li><a href="#"><i class="skt-icon-view-2"></i><b>Agregar Nota</b></a></li>
                            <li><a href="#"><i class="skt-icon-script"></i><b>Agregar Texto Plano y Script</b></a></li>
                            <li><a href="#"><i class=" skt-icon-control"></i><b>Complementos (Módulos)</b></a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo \SKTURL ?>SKT_HELP/FileSystems"><i class="skt-icon-folder"></i><b>Sistema de archivos</b></a></li>
                    <li><a href="#"><i class="skt-icon-calendar"></i><b>Calendario</b></a></li>
                    <li><a href="#"><i class="skt-icon-user-profile"></i><b>Usuarios</b></a></li>
                    <li><a href="<?php echo \SKTURL ?>SKT_HELP/CustomList"><i class="skt-icon-list"></i><b>Listas personalizadas</b></a></li>
                </ul>
                <section>
                    <label for="tm"><i class="skt-icon-menu-3lines"></i></label>
                </section>
            </div>
            <?php include(dirname(__FILE__) . '/' . $Page . '.php'); ?>
        </div>
    </body>
    <?php
    echo "</html>";
}
?>