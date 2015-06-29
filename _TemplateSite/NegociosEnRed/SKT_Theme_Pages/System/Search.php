<div class="container">
    <div class="gap-small"></div>
    <h3><i class="skt-icon-search"></i> Resultados de b&uacute;squeda de: <b><?php echo utf8_decode($_GET['SearchQuery']); ?></b></h3>
    <div class="gap-small"></div>
    <div id="paging">
        <div id="info"></div>
        <div id="SearchResults">
            <?php
            if ($_GET['SearchType'] == "Category") {
                $ProductBeforeList = '<div class="gap-small"></div><h1 class="text-center">Productos relacionados con "' . $_GET['SearchQuery'] . '"</h1><div class="gap-small"></div><div class="row row-wrap isotope masonrylist">';
                $ProductTemplate = '<div class="col-md-3 col-masonry element-item">
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
                $ProductAfterList = '</div>';
                $InstancsParams = array(
                    'TemplateItem' => $ProductTemplate,
                    'ProductImageSize' => array('x' => '250', 'y' => '250'),
                    'SearchType' => 'Category',
                    'SearchQuery' => $_GET['SearchQuery'],
                    'ProductBeforeList' => $ProductBeforeList,
                    'ProductAfterList' => $ProductAfterList,
                    'Limit' => 80
                );
                $List = new CmsDev\CRUD\ViewEditElementsAsList\Lists\Products\_classes();
                echo $List->GetSearchResults($InstancsParams);
            }
            if ($_GET['SearchType'] == "Tag") {
                $ProductBeforeList = '<div class="gap-small"></div><h1 class="text-center">Productos relacionados con "' . $_GET['SearchQuery'] . '"</h1><div class="gap-small"></div><div class="row row-wrap isotope masonrylist">';
                $ProductTemplate = '<div class="col-md-3 col-masonry element-item">
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
                $ProductAfterList = '</div>';
                $InstancsParams = array(
                    'TemplateItem' => $ProductTemplate,
                    'ProductImageSize' => array('x' => '250', 'y' => '250'),
                    'SearchType' => 'Tag',
                    'SearchQuery' => $_GET['SearchQuery'],
                    'ProductBeforeList' => $ProductBeforeList,
                    'ProductAfterList' => $ProductAfterList,
                    'Limit' => 80
                );
                $List = new CmsDev\CRUD\ViewEditElementsAsList\Lists\Products\_classes();
                echo $List->GetSearchResults($InstancsParams);
            }
            if ($_GET['SearchType'] == "Business" || $_GET['SearchType'] == "All") {
                $SearchResults = new \CmsDev\SearchEngine\SearchContentSection();
                $SearchResults->Get_Results($_GET['SearchType'], $_GET['SearchQuery'], 100);
            }
            ?>

            <?php
            if ($_GET['SearchType'] == "Product" || $_GET['SearchType'] == "All") {
                $ProductBeforeList = '<div class="gap-small"></div><h1 class="text-center">Productos relacionados con "' . $_GET['SearchQuery'] . '"</h1><div class="gap-small"></div><div class="row row-wrap isotope masonrylist">';
                $ProductTemplate = '<div class="col-md-3 col-masonry element-item">
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
                $ProductAfterList = '</div>';
                $InstancsParams = array(
                    'TemplateItem' => $ProductTemplate,
                    'ProductImageSize' => array('x' => '250', 'y' => '250'),
                    'SearchQuery' => $_GET['SearchQuery'],
                    'ProductBeforeList' => $ProductBeforeList,
                    'ProductAfterList' => $ProductAfterList,
                    'Limit' => 80
                );
                $List = new CmsDev\CRUD\ViewEditElementsAsList\Lists\Products\_classes();
                echo $List->GetSearchResults($InstancsParams);
            }

            if ($_GET['SearchType'] == "Company" || $_GET['SearchType'] == "All") {
                $ProductBeforeList = '<div class="gap-small"></div>'
                        . '<h1 class="text-center">Empresas</h1>'
                        . '<div class="gap-small"></div>'
                        . '<div class="row row-wrap isotope masonrylist">';
                $UserTemplate = '<div class="col-md-3 col-masonry element-item">
                    <a href="/usr/[id]/[CompanyUrl]/" class="product-thumb user-thumb">
                    <header class="product-header" style="padding-top:10px;">
                        <img title="[Company]" alt="[Company]" src="[ClientAuth_picture]" style="width:170px; margin:0 auto;"/>
                    </header>
                    <div class="product-inner">
                        <h5 class="product-title">[Company]</h5>
                        <div class="product-desciption">[Description]</div>
                        <div class="product-meta hidden"><span class="product-time"><i class="fa fa-map-marker"></i> [Address]</span>
                            <ul class="product-price-list">
                                <li>
                                    <span class="product-save"><i class="fa fa-phone"></i> [Phone]</span>
                                </li>
                            </ul>
                        </div>
                        <p class="product-location text-left">
                        <h5>Categor&iacute;as</h5>
                        <span class="small">[category1]</span><br>
                        <span class="small">[category2]</span><br>
                        <span class="small">[category3]</span><br>
                        <span class="small">[category4]</span><br>
                        <span class="small">[category5]</span>
                        </p>
                    </div>
            </a>
    </div>';
                $ProductAfterList = '</div>';
                $List = new CmsDev\CRUD\ViewEditElementsAsList\Lists\Users\_classes();
                echo $List->GetSearchResults($UserTemplate, $_GET['SearchQuery'], 100, $ProductBeforeList, $ProductAfterList);
            }
            ?>

        </div>
    </div>
    <div class="gap-small"></div>
</div>
