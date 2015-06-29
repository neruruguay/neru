<?php
$ListProductCategories = new CmsDev\Dataset\ProductCategories();
$SKT_CC = new \CmsDev\CustomControl\LoadControl();
$BreadCrumb1 = $ListProductCategories->getName()[$item->CatP]['category_name'];
$BreadCrumb2 = $ListProductCategories->getName()[$item->Cat]['category_name'];
if ($item->Currency == 0) {
    $Currency = '$';
} else {
    $Currency = 'U$S';
}
if ($item->UnitOrAll == 'All') {
    $lot = ' el lote';
} else {
    $lot = ' c/u';
}

if (\CmsDev\Security\loginIntent::action('validateUser') === true) {
    $linkBuy = '#buy-dialog';
} else {
    $linkBuy = '#login-dialog';
}
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
                <?php
                if ($item->ProductImage !== '') {
                    echo '<a href="' . $item->ProductImage . '" data-thumb="' . str_replace('_FileSystems', '_thumb_', $item->ProductImage) . '-150' . '"></a>';
                }
                if ($item->Image2 !== '') {
                    echo '<a href="' . $item->Image2 . '" data-thumb="' . str_replace('_FileSystems', '_thumb_', $item->Image2) . '-150"></a>';
                }
                if ($item->Image3 !== '') {
                    echo '<a href="' . $item->Image3 . '" data-thumb="' . str_replace('_FileSystems', '_thumb_', $item->Image3) . '-150"></a>';
                }
                if ($item->Image4 !== '') {
                    echo '<a href="' . $item->Image4 . '" data-thumb="' . str_replace('_FileSystems', '_thumb_', $item->Image4) . '-150"></a>';
                }
                if ($item->Image5 !== '') {
                    echo '<a href="' . $item->Image5 . '" data-thumb="' . str_replace('_FileSystems', '_thumb_', $item->Image5) . '-150"></a>';
                }
                if ($item->Image6 !== '') {
                    echo '<a href="' . $item->Image6 . '" data-thumb="' . str_replace('_FileSystems', '_thumb_', $item->Image6) . '-150"></a>';
                }
                ?>
            </div>
        </div>
        <div class="col-md-7">
            <div  class="col-md-12 mb30">
                <h2><?php echo $item->Title; ?></h2>
            </div>
            <div class="product-info mt30">
                <p class="product-info-price">
                    <?php
                    if ($item->Price !== 0) {
                        echo '<span class="price">' . $Currency;
                        echo (int) $item->Price;
                        echo $lot;
                        echo '</span>';
                    }
                    ?>
                    <a href="<?php echo $linkBuy; ?>" id="BtnBuyDetail" class="btn btn-primary btn-large popup-text" data-effect="mfp-zoom-out"> Comprar</a>
                </p>
                <p class="text-smaller text-muted">
                    <?php
                    if ($item->stock >= 1 && $item->UnitOrAll == 'Unit') {
                        echo '<span class="mb30">' . $item->stock . ' unidades en Stock.</span><hr>';
                    }
                    ?>
                    <b class="mb30">Venta m&iacute;nima: <?php echo $item->MinSell ?> unidad/es.</b>
                <hr>
                <?php echo $item->ProductDescription; ?>
                <hr>
                <?php echo $item->ProductDescriptionHTML; ?>
                <hr>
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
<div id="buy-dialog" class="mfp-with-anim mfp-hide mfp-dialog clearfix">
    <i class="fa fa-money dialog-icon"></i>
    <h3>Comprar <?php
        if ($item->UnitOrAll == 'All') {
            echo 'Lote';
        }
        ?></h3>
    <form class="dialog-form" id="buy-dialog-form" action="" method="POST">
        <h3><?php echo $item->Title; ?></h3>
        <div class="gap-border"></div>
        <?php
        if ($item->UnitOrAll == 'Unit') {
            ?>
            <div class="form-group">
                <div class="row priceset">
                    <div class="col-md-3 text-right">
                        <label>Cantidad</label>
                    </div>
                    <div class="col-md-3">
                        <input id="Quantity" name="Quantity" type="number" placeholder="" class="form-control" value="<?php echo (int) $item->MinSell; ?>">
                        <input name="Price" type="hidden" value="<?php echo ((int) $item->MinSell * (int) $item->Price); ?>">
                    </div>
                    <div class="col-md-6">
                        <h4 id="QuantityValue" class="alert alert-block alert-info btn-block text-center"><?php echo $Currency . ' ' . ((int) $item->MinSell * (int) $item->Price); ?></h4>
                    </div>
                </div>
            </div>
            <div class="gap-border"></div>
            <div class="gap-small"></div>
            <?php
        } else {
            ?>
            <div class="form-group">
                <h4 id="QuantityValue" class="alert alert-block alert-info btn-block text-center"><?php
                    if ($item->Price !== 0) {
                        echo $Currency;
                        echo (int) $item->Price;
                    }
                    ?>
                </h4>
                <input id="Quantity" name="Quantity" type="hidden" value="<?php echo (int) $item->MinSell; ?>">
            </div>
            <?php
        }
        if (\CmsDev\Security\loginIntent::action('validateUser') === true) {
            $PurchaseRequestsFields = array(
                'Seller' => $item->IDUser,
                'Customer' => $_SESSION['UserIDU'],
                'PID' => $item->ProductUID,
                'Currency' => $item->Currency,
                'UnitPrice' => $item->Price,
                'OrderDate' => date('Y-m-d'),
                'OrderPurchase' => base64_encode(microtime()),
                'SellerOpinion' => '',
                'CustomerOpinion' => '',
                'SellerSemaphore' => '1',
                'CustomerSemaphore' => '1',
                'Finalized' => '0',
                'FinalizedDate' => 'Null',
                'ProductType' => 'Product'
            );
            $dataProdBlockJSON = json_encode($PurchaseRequestsFields);
            $dataProdBlock = CmsDev\skt_Code::Encode($dataProdBlockJSON);
            echo '<input name="data" type="hidden" value="' . $dataProdBlock . '">'
            . '<div class="gap-big"></div><input type="button" id="BtnBuyCheck" value="Confirmar Compra" class="btn btn-primary btn-block">';
        }
        ?>

    </form>
    <?php if (\CmsDev\Security\loginIntent::action('validateUser') !== true) { ?>
        <div class="gap-large"></div>
        <div class="gap-border"></div>
        <ul class="dialog-alt-links">
            <li>
                <a class="popup-text btn btn-primary" href="#login-dialog" data-effect="mfp-zoom-out">Ingresar con mi usuario</a>
            </li>
            <li>
                <a class="btn btn-warning" href="<?php echo \SKT_URL_BASE; ?>UserRegistration" target="_self">A&uacute;n no soy miembro</a>
            </li>
        </ul>
    <?php } ?>
</div>
<script type="text/javascript">

    $('#Quantity').bind("click blur", function () {
        var Qty = $(this).val();
        if (Qty <= <?php echo (int) $item->stock; ?> && Qty >= <?php echo (int) $item->MinSell; ?>) {
            var Nprice = "<?php echo $Currency; ?> " + (Qty * <?php echo (int) $item->Price; ?>);
            $('#QuantityValue').text(Nprice);
        } else {
            var Nprice = "<?php echo $Currency; ?> " + <?php echo ((int) $item->MinSell * (int) $item->Price); ?>;
            $('#QuantityValue').text(Nprice);
            $(this).val(<?php echo (int) $item->MinSell; ?>);
        }
    })
    $('#buy-dialog-form').on("submit", function () {
        BuyCheck();
    });
    $('#BtnBuyCheck').on("click", function () {
        BuyCheck();
    });
    function BuyCheck() {
        $("#loader-wrapper").removeClass('load_hide');
        var UrlBuyCheck = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Purchase_Requests/_Create');
        jQuery.ajax({
            'type': 'POST',
            'url': UrlBuyCheck,
            'cache': false,
            'data': $('#buy-dialog-form').serialize(),
            'success': function (data) {
<?php if (\DEBUG_MAILSEND == TRUE) { ?>
                    if ($('#infomail').length) {
                        $('#infomail').html(data);
                    } else {
                        $('body').append('<div id="infomail">' + data + '</div>');
                    }
                    $("#loader-wrapper").addClass('load_hide');
<?php } else { ?>
                    $('#buy-dialog-form').html('<div class="alert alert-info">' + data + '</div>');
                    $("#loader-wrapper").addClass('load_hide');
<?php } ?>
            }
        });
    }
</script>