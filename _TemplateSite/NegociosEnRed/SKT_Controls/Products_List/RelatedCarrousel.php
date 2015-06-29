
<div class="bg-holder RelatedCarrousel">
    <div class="bg-holder-content">
        <div class="gap text-center">
            <h3 class="mb30 text-color">Otros art&iacute;culos de <?php echo $CCParams['Company']; ?></h3>
            <div class="row" style="padding: 0px 50px;">
                <div class="owl-carousel" id="owl-carousel" data-items="4">
                    <?php
                    $TemplateItem = '<div><b class="linkCompany">[Company]</b>
                        <a href="[UrlDetail]" class="product-thumb">
                        [MEDAL]
                            <header class="product-header">
                                [ProductImage]
                            </header>
                            <div class="product-inner">
                                <h5 class="product-title">[Title]</h5>
                                <p class="product-desciption">[ProductDescription]</p>
                                <div class="product-meta">
                                    <ul class="product-price-list">
                                        <li><span class="product-price">[Currency+Price][UnitOrAll]</span>
                                        </li>
                                    </ul>
                                </div>
                                <p class="product-location"><div data-countdown="[expiredate]" class="countdown countdown-inline text-color"></div></p>
                            </div>
                        </a>
                    </div>';
                    $InstancsParams = array(
                        'TemplateItem' => $TemplateItem,
                        'ProductImageSize' => array('x' => '280', 'y' => '250'),
                        'CatP' => '',
                        'Cat' => '',
                        'Query' => '',
                        'IDUser' => $CCParams['id'],
                        'ExcludeID' => $CCParams['Exclude'],
                        'Limit' => 20
                    );
                    $Detail = new CmsDev\CRUD\ViewEditElementsAsList\Lists\Products\_classes();
                    echo $Detail->GetListOtherFromUser($InstancsParams);
                    ?>
                </div>
            </div>
            <?php echo $Detail->CompanyLink($CCParams['id'], $CCParams['CompanyUrl'], $CCParams['Company'], 'Encuentre m&aacute;s', 'btn btn-color btn-lg btn-ghost'); ?>
        </div>
    </div>
</div>