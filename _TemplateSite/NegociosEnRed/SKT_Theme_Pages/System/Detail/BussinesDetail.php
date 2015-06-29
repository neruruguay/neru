<?php
$ListProductCategories = new CmsDev\Dataset\ProductCategories();
$SKT_CC = new \CmsDev\CustomControl\LoadControl();
$BreadCrumb1 = $ListProductCategories->getName()[$item->CatP]['category_name'];
$BreadCrumb2 = $ListProductCategories->getName()[$item->Cat]['category_name'];
?>
<section class="container">
    <ul class="breadcrumb mt20">
        <li><?php echo $Detail->CompanyLink($item->id, $item->CompanyUrl, $item->Company); ?></li>
        <li><?php echo '<a data-toggle="tooltip" href="/Search/Category/' . $BreadCrumb1 . '/" title="Buscar productos con la Etiqueta (' . $BreadCrumb1 . ')">' . $BreadCrumb1 . '</a>'; ?></li>
        <li><?php echo '<a data-toggle="tooltip" href="/Search/Category/' . $BreadCrumb2 . '/" title="Buscar productos en la categor&iacute;a (' . $BreadCrumb2 . ')">' . $BreadCrumb2 . '</a>'; ?></li>
        <li class="CompanyCertifications">
            <?php
            $logo = '<img class="img-responsive hidden-xs hidden-sm sktToolTip" title="' . $item->Company . '" alt="' . $item->Company . '" src="' . \SKT_URL_BASE . $item->ClientAuth_picture . '">';
            $CompanyName = '<div class="hidden-md hidden-lg">' . $item->Company . '</div>';
            echo $Detail->CompanyLink($item->id, $item->CompanyUrl, $item->Company, $logo);
            echo $Detail->CompanyLink($item->id, $item->CompanyUrl, $item->Company, $CompanyName);
            echo $Detail->ProductMedal($item->Plan_Name, 'right');
            echo $Detail->ProductMedal('Certificada', 'right');
            ?>
        </li>
    </ul>
    <div class="row mt30 Detail">
        <div class="col-md-5">
            <div class="fotorama" data-nav="thumbs" data-allowfullscreen="1" data-thumbheight="150" data-thumbwidth="150">
                <a href="<?php echo $item->ProductImage; ?>" data-thumb="<?php echo str_replace('_FileSystems', '_thumb_', $item->ProductImage) . '-150'; ?>"></a>
                <a href="<?php echo $item->Image2; ?>" data-thumb="<?php echo str_replace('_FileSystems', '_thumb_', $item->Image2) . '-150'; ?>"></a>
                <a href="<?php echo $item->Image3; ?>" data-thumb="<?php echo str_replace('_FileSystems', '_thumb_', $item->Image3) . '-150'; ?>"></a>
                <a href="<?php echo $item->Image4; ?>" data-thumb="<?php echo str_replace('_FileSystems', '_thumb_', $item->Image4) . '-150'; ?>"></a>
                <a href="<?php echo $item->Image5; ?>" data-thumb="<?php echo str_replace('_FileSystems', '_thumb_', $item->Image5) . '-150'; ?>"></a>
                <a href="<?php echo $item->Image6; ?>" data-thumb="<?php echo str_replace('_FileSystems', '_thumb_', $item->Image6) . '-150'; ?>"></a>

            </div>
        </div>
        <div class="col-md-7">
            <div  class="col-md-12 mb30">
                <h2><?php echo $item->Title; ?></h2>
            </div>
            <div class="product-info mt30">

                <p class="product-info-price mb30">
                    <span class="price"><?php
                        if ($item->UnitOrAll == 'All') {
                            $lot = ' el lote';
                        } else {
                            $lot = ' c/u';
                        }
                        if ($item->Price !== 0) {
                            if ($item->Currency == 0) {
                                echo '$';
                            } else {
                                echo 'U$S';
                            } echo $item->Price;
                            echo $lot;
                        }
                        ?>
                    </span>
                    <button type="button" id="BtnBuyDetail" class="btn btn-primary btn-large"> Reservar</button>
                </p>
                <p class="text-smaller text-muted">
                    <?php echo $item->ProductDescription; ?>
                    <?php echo $item->ProductDescriptionHTML; ?>
                    <?php
                    $tags = explode(',', $item->Tags);
                    if (count($tags) >= 2) {
                        echo '<ul class="text-smaller tags-list">';
                        foreach ($tags as $Tag) {
                            echo '<li><a data-toggle="tooltip" href="/Search/Tag/' . $Tag . '/" title="Buscar productos con la Etiqueta (' . $Tag . ')">' . $Tag . '</a></li>';
                        }
                        echo '</ul>';
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>
    <?php
    \CmsDev\Content\LoadMod::render('General', 'Zona General de contenidos');
    ?>
    <div class="gap"></div>
    <?php
    $CCParams_Detail = array(
        'Company' => $item->Company,
        'id' => $item->id,
        'Exclude' => $DetailID,
        'CompanyUrl' => $item->CompanyUrl);
    $SKT_CC->Render('Products_List', $CCParams_Detail, 'RelatedCarrousel.php');
    ?>
    <div class="gap"></div>
</section>