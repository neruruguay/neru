<div class="row row-wrap isotope masonrylist">
    <?php
    $TemplateItem = '<div class="col-md-4 col-masonry element-item">
        <a href="[UrlDetail]" class="product-thumb">
    [MEDAL]
        <header class="product-header">
            [ProductImage]
        </header>
        <div class="product-inner">
            
            <h5 class="product-title">[Title]</h5>
            <p class="product-desciption hidden">[ProductDescription]</p>
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
        'ShowExpired' => 1,
        'IDUser' => $CCParams['id'],
        //'ExcludeID' => $CCParams['Exclude'],
        'Limit' => 100
    );
    $List = new CmsDev\CRUD\ViewEditElementsAsList\Lists\Products\_classes();
    echo $List->GetList($InstancsParams);
    ?>
</div>
<ul class="pagination hidden">
    <li class="prev disabled">
        <a href="#"></a>
    </li>
    <li class="active"><a href="#">1</a>
    </li>
    <li><a href="#">2</a>
    </li>
    <li><a href="#">3</a>
    </li>
    <li><a href="#">4</a>
    </li>
    <li><a href="#">5</a>
    </li>
    <li class="next">
        <a href="#"></a>
    </li>
</ul>
<div class="gap-small"></div>