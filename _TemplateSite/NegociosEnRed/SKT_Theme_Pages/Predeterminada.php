<?php
$SKT_CC = new \CmsDev\CustomControl\LoadControl();
?>
<section class="container">
    <?php \CmsDev\Content\LoadMod::render('Banner', 'Banner'); ?>
    <div  class="row mt40">
        <div class="col-md-12"><h1 class="title_color"><?php echo \SKT_SECTION_TITLE; ?></h1></div>
    </div>
    <?php
    \CmsDev\Content\LoadMod::render('General', 'Zona General de contenidos');
    ?>
    <div class="row">
        <div class="col-md-4">
            <?php
            \CmsDev\Content\LoadMod::render('Columna1', 'Columna Izquierda');
            ?>
        </div>
        <div class="col-md-4">
            <?php
            \CmsDev\Content\LoadMod::render('Columna2', 'Columna Central');
            ?>
        </div>
        <div class="col-md-4">
            <?php
            \CmsDev\Content\LoadMod::render('Columna3', 'Columna Derecha');
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php
            \CmsDev\Content\LoadMod::render('General2', 'Columna entera base');
            ?>
        </div>
    </div>
</section>