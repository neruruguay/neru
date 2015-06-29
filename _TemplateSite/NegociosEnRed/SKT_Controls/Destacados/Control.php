<div class="bg-holder highlighted">
    <div class="bg-mask"></div>
    <div style="background-image:url(<?php echo SKTURL_TemplateSite; ?>assets/img/backgrounds/fullslide1.jpg)" class="bg-blur"></div>
    <div class="bg-holder-content">
        <div class="gap text-center">
            <h1 class="mb30 text-white">Selección de artículos destacados</h1>
            <div class="row row-wrap">
                <div class="owl-carousel" id="owl-carousel" data-items="6" >
                    <?php
                    $TemplateItem = '<div><b class="linkCompany">[Company]</b>
    <a href="[UrlDetail]" class="product-thumb">
    [MEDAL]
        <header class="product-header">
            [ProductImage]
        </header>
        <div class="product-inner">
            <h5 class="product-title">[Title]</h5>
            <!-- <p class="product-desciption">[ProductDescription]</p> -->
            <div class="product-meta">
                <ul class="product-price-list">
                    <li><span class="product-price">[Currency+Price][UnitOrAll]</span></li>
                </ul>
            </div>
            <p class="product-location"><div data-countdown="[expiredate]" class="countdown countdown-inline text-color"></div></p>
        </div>
    </a>
</div>';
                    $InstancsParams = array(
                        'TemplateItem' => $TemplateItem,
                        'ProductImageSize' => array('x' => '280', 'y' => ''),
                        'CatP' => '',
                        'Cat' => '',
                        'Query' => '',
                        'IDUser' => '',
                        'Limit' => 20
                    );
                    $List = new CmsDev\CRUD\ViewEditElementsAsList\Lists\Products\_classes();
                    echo $List->GetList($InstancsParams);
                    ?>
                </div>
            </div>
            <a class="btn btn-white btn-lg btn-ghost" href="javascript:void(0);">Encuentre m&aacute;s</a>
        </div>
    </div>
</div>