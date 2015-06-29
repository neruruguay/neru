<?php
$SKTDB = \CmsDev\Sql\db_Skt::connect();
$Query = "SELECT * FROM " . \DB_PREFIX . "categories WHERE category_idx = 7 Order By category_position ASC";
$query_CurculosEmpresariales = $SKTDB->get_results($Query);

$Query2 = "SELECT * FROM " . \DB_PREFIX . "categories WHERE category_idx = 8 Order By category_position ASC";
$query_Oportunidades = $SKTDB->get_results($Query2);

?>
<div class="container">
    <div class="gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="text-center">
                    <h1>C&iacute;rculos Empresariales</h1>
                    <p class="text-bigger">Nuestras principales redes activas y las empresas vinculadas a cada red est&aacute;n a su disposici&oacute;n para contactar y concretar negocios sin intermediarios.
                        Nuestra misi&oacute;n es lograr un proceso &aacute;gil y seguro que beneficie a todos.</p>
                </div>
            </div>
        </div>
    </div>
    <div  class="row mt40 row-wrap circulos" id="masonry">
        <?php foreach ($query_CurculosEmpresariales as $items) { ?>
            <div class="col-md-3 col-md-offset-0 mt30 col-sm-7 col-sm-offset-3 col-xs-7 col-xs-offset-3 col-masonry">
                <a href="/empresas/0/0/<?php echo $items->category_id; ?>/<?php echo $items->category_url; ?>/" class="hover-img">
                    <div class="product-banner">
                        <img alt="<?php echo $items->category_name; ?>" class="img-responsive" src="<?php echo $items->category_image; ?>" />
                        <div class="product-banner-inner gradient_black padding">
                            <h2 class="white"><?php echo $items->category_name; ?></h2>
                            <p class="white hidden"><?php echo $items->category_Description; ?></p>
                        </div>
                    </div>
                </a>
            </div>     
        <?php } ?>
    </div>
    <div class="gap"></div> 
    <div class="text-center">
        <a href="/empresas/0/0/0/" class="btn btn-default btn-large size-3-i">Ver listado de todas las empresas</a>
    </div>
    <div class="gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="text-center">
                    <h1>Oportunidades de Negocios, Coaching, Servicios y Productos.</h1>
                </div>
            </div>
        </div>
    </div>
    <div  class="row mt40 row-wrap circulos" id="masonry">
        <?php foreach ($query_Oportunidades as $items) { ?>
            <div class="col-md-3 col-md-offset-0 mt30 col-sm-7 col-sm-offset-3 col-xs-7 col-xs-offset-3 col-masonry">
                <a href="/<?php echo $items->category_url; ?>/" class="hover-img">
                    <div class="product-banner">
                        <img alt="<?php echo $items->category_name; ?>" class="img-responsive" src="<?php echo $items->category_image; ?>" />
                        <div class="product-banner-inner gradient_black padding">
                            <h2 class="white"><?php echo $items->category_name; ?></h2>
                            <p class="white hidden"><?php echo $items->category_Description; ?></p>
                        </div>
                    </div>
                </a>
            </div>     
        <?php } ?>
    </div>
    <div class="gap"></div>
</div>