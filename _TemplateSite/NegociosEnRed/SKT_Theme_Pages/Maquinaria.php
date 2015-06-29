<?php
$SKT_CC = new \CmsDev\CustomControl\LoadControl();
?>
<?php
\CmsDev\Content\LoadMod::render('General', 'Zona General de contenidos');
?>
<div class="container">
    <?php
    $ServerFolder = SKTPATH_FileSystems . DS . 'Banners' . DS . 'Maquinaria' . DS;
    $PublicURL = SKTURL_FileSystems . '/Banners/' . DS . 'Maquinaria' . DS;
    $DirFolder = new CmsDev\AdminFilesystem\FolderRecoveryFiles(); // Create new instance
    $DirFolder->Folder($ServerFolder, $PublicURL, SKTServerURL);
    $DirFolder->TrumbnailImage(1200, 480, 85); // $Width, $Height, $Quality
    $DirFolder->Trumbnail(false);
    $DirFolder->View_image(1); // 0 or 1
    $DirFolder->View_video(0); // 0 or 1
    $DirFolder->View_Download(0); // 0 or 1
    $DirFolder->extArray(array("jpg"));
    $DirFolder->item_model_image('<div class="bg-holder">
    <img src="[PublicURL]" alt="" title="" />
    <div class="bg-mask"></div>
    <div class="vert-center text-white text-center slider-caption">
                            <h2 class="text-uc">[Title]</h2>
                            <p class="text-bigger">[Description]</p>
                            <p class="text-hero">[CustomData]</p><a href="[hiperlink]" class="btn btn-lg btn-ghost btn-white">Conoce m&aacute;s +</a>
                        </div>
                        <div class="bg-front vert-center text-white text-center">
    </div>
</div>');
    $DirFolder->item_model_video('');
    $DirFolder->item_model_Download('');
    if ($DirFolder->exist() == true && $DirFolder->FilesInFolder() != 0) {
        ?>
        <div class="top-area mt30">
            <div class="owl-carousel owl-slider" id="owl-carousel-slider" data-inner-pagination="true" data-white-pagination="true" data-nav="true">
                <?php
                echo $DirFolder->ListFolder();
                ?>
            </div>
        </div>
    <?php } ?>
    <div class="gap"></div>
    <?php $SKT_CC->Render('Bannersx3'); ?>
    <div  class="row">
        <div class="col-md-3">
            <aside class="sidebar-left">
                <?php $SKT_CC->Render('Categories'); ?>
            </aside>
        </div>
        <div class="col-md-9">
            <?php $SKT_CC->Render('Companies'); ?>
        </div>
    </div>

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
</div>
<div class="gap"></div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="text-center">
                <h1>Explore los mejores negocios en el mercado</h1>
                <p class="text-bigger">Quam aenean nec suscipit turpis lectus lobortis potenti faucibus amet netus ante facilisis facilisis aenean blandit potenti dictum iaculis morbi tortor cum proin ornare porta dictum placerat condimentum ligula pulvinar</p>
            </div>
        </div>
    </div>
</div>

<div class="gap"></div>
<div class="bg-holder">
    <div class="bg-mask"></div>
    <div style="background-image:url(<?php echo SKTURL_TemplateSite; ?>assets/img/backgrounds/phone.jpg)" class="bg-blur"></div>
    <div class="container bg-holder-content">
        <div class="gap gap-big text-center">
            <h1 class="mb30 text-white">Artículos destacados de la semana</h1>
            <div class="row row-wrap">
                <a href="#" class="col-md-3">
                    <div class="product-thumb">
                        <header class="product-header">
                            <img title="Green Furniture" alt="Image Alternative text" src="<?php echo SKTURL_TemplateSite; ?>assets/img/800x600.png">
                        </header>
                        <div class="product-inner">
                            <h5 class="product-title">Green Furniture Pack</h5>
                            <p class="product-desciption">Mauris mauris neque nostra viverra vehicula ridiculus donec</p>
                            <div class="product-meta"><span class="product-time"><i class="fa fa-clock-o"></i>  8 dias 12 h restantes</span>
                                <ul class="product-price-list">
                                    <li><span class="product-price">$73</span>
                                    </li>
                                    <li><span class="product-old-price">$177</span>
                                    </li>
                                    <li><span class="product-save">Save 41%</span>
                                    </li>
                                </ul>
                            </div>
                            <p class="product-location"><i class="fa fa-map-marker"></i> Boston</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="col-md-3">
                    <div class="product-thumb">
                        <header class="product-header">
                            <img title="a turn" alt="Image Alternative text" src="<?php echo SKTURL_TemplateSite; ?>assets/img/800x600.png">
                        </header>
                        <div class="product-inner">
                            <h5 class="product-title">Diving with Sharks</h5>
                            <p class="product-desciption">Mauris mauris neque nostra viverra vehicula ridiculus donec</p>
                            <div class="product-meta"><span class="product-time"><i class="fa fa-clock-o"></i>  8 dias 12 h restantes</span>
                                <ul class="product-price-list">
                                    <li><span class="product-price">$56</span>
                                    </li>
                                    <li><span class="product-old-price">$117</span>
                                    </li>
                                    <li><span class="product-save">Save 48%</span>
                                    </li>
                                </ul>
                            </div>
                            <p class="product-location"><i class="fa fa-map-marker"></i> Boston</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="col-md-3">
                    <div class="product-thumb">
                        <header class="product-header">
                            <img title="Food is Pride" alt="Image Alternative text" src="<?php echo SKTURL_TemplateSite; ?>assets/img/800x600.png">
                        </header>
                        <div class="product-inner">
                            <h5 class="product-title">Best Pasta</h5>
                            <p class="product-desciption">Mauris mauris neque nostra viverra vehicula ridiculus donec</p>
                            <div class="product-meta"><span class="product-time"><i class="fa fa-clock-o"></i>  8 dias 12 h restantes</span>
                                <ul class="product-price-list">
                                    <li><span class="product-price">$103</span>
                                    </li>
                                    <li><span class="product-old-price">$191</span>
                                    </li>
                                    <li><span class="product-save">Save 54%</span>
                                    </li>
                                </ul>
                            </div>
                            <p class="product-location"><i class="fa fa-map-marker"></i> Boston</p>
                        </div>
                    </div>
                </a>
                <a href="#" class="col-md-3">
                    <div class="product-thumb">
                        <header class="product-header">
                            <img title="Aspen Lounge Chair" alt="Image Alternative text" src="<?php echo SKTURL_TemplateSite; ?>assets/img/800x600.png">
                        </header>
                        <div class="product-inner">
                            <h5 class="product-title">Aspen Lounge Chair</h5>
                            <p class="product-desciption">Mauris mauris neque nostra viverra vehicula ridiculus donec</p>
                            <div class="product-meta"><span class="product-time"><i class="fa fa-clock-o"></i> 8 dias 12 h restantes</span>
                                <ul class="product-price-list">
                                    <li><span class="product-price">$99</span>
                                    </li>
                                    <li><span class="product-old-price">$235</span>
                                    </li>
                                    <li><span class="product-save">Save 42%</span>
                                    </li>
                                </ul>
                            </div>
                            <p class="product-location"><i class="fa fa-map-marker"></i> Boston</p>
                        </div>
                    </div>
                </a>
            </div>	<a class="btn btn-white btn-lg btn-ghost" href="#">Encuentre m&aacute;s</a>
        </div>
    </div>
</div>