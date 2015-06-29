<style>
    .img-responsive.center-block.margin-b {
        background: url("/CmsDev/1.4.assets/img/transparent.png") repeat scroll 0 0 rgba(0, 0, 0, 0);
    }
</style>
<div class="container" style="margin: 0px auto;">
    <h1 class="Title"><i class="skt-icon-folder"></i> Sistema de Archivos</h1>
    <div class="Function">
        <h4>SKTFSys</h4>
        <p>Administrador de archivos del sitio</p>
        <div class="row">
            <div class="col-md-12">
                <a href="<?php echo \SKTURL; ?>SKTFSys/" target="_blank"><img src="<?php echo SKTURL_assets; ?>help/SKTFSys.jpg" alt="" class="img-responsive"/></a>
            </div>
        </div>
    </div>
    <h2 class="Secondary"><i class="skt-icon-image"></i> Imágenes</h2>
    <div class="Function">
        <h4>SKTSize</h4>
        <p>Permite colocar la ruta al archivo incluyendo propiedades de tamaño y transparencia</p>
        <p>Usted puede mostrar imagens cargadas en el sistema de forma segura, usando las funcionalidades del sistema mediante las siguientes formas:</p>
        <div class="row">
            <?php
            $ArrExt = array('foto.jpg', '24-bit-transparente.png', 'animado1.gif');
            $ArrExtCount = count($ArrExt);
            for ($i = 0; $i < $ArrExtCount; $i++) {
                $ext = $ArrExt[$i];
                ?>
                <div class="col-md-4">
                    <ul style="margin: 0px; padding: 0;">
                        <li style="margin: 2%px 0px; padding: 10px; list-style: none;" class="alert alert-info">
                            <h5>Imagen cuadrada</h5>
                            <a target="_blank" href="<?php echo \SKTURL; ?>SKTSize/images/demostration/<?php echo $ext; ?>?100">
                                <img src="<?php echo \SKTURL; ?>SKTSize/images/demostration/<?php echo $ext; ?>?100" class="img-responsive center-block  margin-b"/>
                            </a>
                            <pre><code class="xml">&lt;img src=&quot;<?php echo \SKTURL; ?>SKTSize/images/<?php echo $ext; ?>?100&quot;/&gt;</code></pre>
                            <p>SKTImageURL(Ruta, Lado);</p>
                        </li>
                        <li style="margin: 2%px 0px; padding: 10px; list-style: none;" class="alert alert-info">
                            <h5>Imagen con medidas específicas</h5>
                            <a target="_blank" href="<?php echo \SKTURL; ?>SKTSize/images/demostration/<?php echo $ext; ?>?320x240">
                                <img src="<?php echo \SKTURL; ?>SKTSize/images/demostration/<?php echo $ext; ?>?320x240" class="img-responsive center-block  margin-b"/>
                            </a>
                            <pre><code class="xml">&lt;img src=&quot;<?php echo \SKTURL; ?>SKTSize/images/<?php echo $ext; ?>?320x240&quot;/&gt;</code></pre>
                            <p>SKTImageURL(Ruta, Ancho, Alto);</p>
                        </li>
                        <li style="margin: 2%px 0px; padding: 10px; list-style: none;" class="alert alert-info">
                            <h5>Imagen a tamaño Natural</h5>
                            <a target="_blank" href="<?php echo \SKTURL; ?>SKTSize/images/demostration/<?php echo $ext; ?>">
                                <img src="<?php echo \SKTURL; ?>SKTSize/images/demostration/<?php echo $ext; ?>" class="img-responsive center-block  margin-b"/>
                            </a>
                            <pre><code class="xml">&lt;img src=&quot;<?php echo \SKTURL; ?>SKTSize/images/<?php echo $ext; ?>&quot;/&gt;</code></pre>
                            <p>SKTImageURL(Ruta);</p>
                        </li>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    hljs.initHighlightingOnLoad();
</script>