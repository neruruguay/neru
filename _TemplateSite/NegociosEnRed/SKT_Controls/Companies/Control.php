<?php
require_once 'Query.php';
$ListCatNames = new CmsDev\Dataset\Categories();
?>
<div class="row">
    <div class="col-md-5">
        <div class="product-sort">
            <span class="product-sort-selected">Filtrar por <b>Círculos Empresariales</b></span>
            <a href="<?php echo \SKT_URL_BASE . $RevertSort; ?>" class="product-sort-order fa <?php echo $CCParams['IconSort']; ?>"></a>
            <ul>
                <li><a href="javascript:viewListFilter('.viewListStyleElements','0');">No filtrar</a></li>
                <li><a href="javascript:viewListFilter('.viewListStyleElements','8');"><?php echo $ListCatNames->getName()[8];?></a></li>
                <li><a href="javascript:viewListFilter('.viewListStyleElements','10');"><?php echo $ListCatNames->getName()[10];?></a></li>
                <li><a href="javascript:viewListFilter('.viewListStyleElements','16');"><?php echo $ListCatNames->getName()[16];?></a></li>
                <li><a href="javascript:viewListFilter('.viewListStyleElements','18');"><?php echo $ListCatNames->getName()[18];?></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-3 col-md-offset-4 viewListStyleControl">
        <div class="product-view pull-right">
            <span>Ver como bloques o lista: </span>
            <a class="fa fa-th-large active" href="javascript:viewListStyle(this,'.viewListStyleElements','col-md-12','col-md-3');"></a>
            <a class="fa fa-list" href="javascript:viewListStyle(this,'.viewListStyleElements','col-md-3','col-md-12');"></a>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row row-wrap isotope masonrylist viewListStyleElements">
        <?php
        
        $Users = $SKTDB->get_results($Query);
        if ($Users) {
            foreach ($Users as $User) {
                ?>
                <div class="col-md-3 col-masonry element-item Cat-<?php echo $User->category1; ?> Cat-<?php echo $User->category2; ?> Cat-<?php echo $User->category3; ?> Cat-<?php echo $User->category4; ?> Cat-<?php echo $User->category5; ?>">
                    <a class="product-thumb user-thumb" href="<?php echo \SKT_URL_BASE . 'usr/' . $User->id . '/' . $User->Company . '/'; ?>">
                        <header class="product-header" style="padding-top:10px;">
                            <img title="<?php echo $User->Company; ?>" alt="<?php echo $User->Company; ?>" src="<?php echo \SKT_URL_BASE . $User->ClientAuth_picture; ?>" style="width:170px; margin:0 auto;"/>
                        </header>
                        <div class="product-inner">
                            <h5 class="product-title"><?php echo $User->Company; ?></h5>
                            <div class="product-desciption"><?php echo cut_string($User->Description, 150); ?></div>
                            <div class="product-meta hidden"><span class="product-time"><i class="fa fa-map-marker"></i> <?php echo $User->Address; ?></span>
                                <ul class="product-price-list">
                                    <li>
                                        <span class="product-save"><i class="fa fa-phone"></i> <?php echo $User->Phone; ?></span>
                                    </li>
                                </ul>
                            </div>
<!--                            <p class="product-location text-left">
                            <h5>Categor&iacute;as</h5>
                            <ul>
                                <li class="small"><?php //echo $ListCatNames->getName()[$User->category1]; ?></li>
                                <li class="small"><?php //echo $ListCatNames->getName()[$User->category2]; ?></li>
                                <li class="small"><?php //echo $ListCatNames->getName()[$User->category3]; ?></li>
                                <li class="small"><?php //echo $ListCatNames->getName()[$User->category4]; ?></li>
                                <li class="small"><?php //echo $ListCatNames->getName()[$User->category5]; ?></li>
                            </ul>
                            </p>-->
                        </div>
                    </a>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>
<div class="gap"></div>
