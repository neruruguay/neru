<button id="PrevStepProduct" type="submit" class="btn btn-large btn-default float-left"><i class="skt-icon-left-open-1"></i> Modificar publicación</button>
<h3 class="title-page text-center"> Vista Previa del producto </h3>
<div class="clear"></div>
<div class="gap"></div>
<div class="hidden"><input type="text" id="Title" name="Title" value="<?php echo $Title; ?>" />
    <input type="text" id="ProductDescription" name="ProductDescription" value="<?php echo $ProductDescription; ?>" />
    <input type="text" id="Currency" name="Currency" value="<?php echo $Currency; ?>" />
    <input type="text" id="Price" name="Price" value="<?php echo $Price; ?>" />
    <input type="text" id="Date" name="Date" value="<?php echo $Date; ?>" />
    <input type="text" id="ProductImage" name="ProductImage" value="<?php echo $ProductImage; ?>" />
    <input type="text" id="Image2" name="Image2" value="<?php echo $Image2; ?>" />
    <input type="text" id="Image3" name="Image3" value="<?php echo $Image3; ?>" /> 
    <input type="text" id="Image4" name="Image4" value="<?php echo $Image4; ?>" />
    <input type="text" id="Image5" name="Image5" value="<?php echo $Image5; ?>" />
    <input type="text" id="Image6" name="Image6" value="<?php echo $Image6; ?>" />
    <input type="text" id="Tags" name="Tags" value="<?php echo $Tags; ?>" />
    <input type="text" id="ProductWeight" name="ProductWeight" value="0" />
    <input type="text" id="ProductStatus" name="ProductStatus" value="1" />
    <input type="text" id="ProductOrder" name="ProductOrder" value="0" />
    <input type="text" id="ProductNew" name="ProductNew" value="0" />
    <input type="text" id="ProductOffer" name="ProductOffer" value="0" />
    <input type="text" id="TextOffer" name="TextOffer" value="" />
    <input type="text" id="RecycleBin" name="RecycleBin" value="0" />
    <input type="text" id="Packing" name="Packing" value="0" />
    <input type="text" id="RelatedDocument" name="RelatedDocument" value="" />
    <textarea id="ProductDescriptionHTML" name="ProductDescriptionHTML"><?php echo $ProductDescriptionHTML; ?></textarea>
    <input type="text" id="expiredate" name="expiredate" value="" />
    <input type="text" id="Priority" name="Priority" value="" />
    <input type="text" id="Plan" name="Plan" value="" />
    <input type="text" id="Edit" name="Edit" value="" />
    <input type="text" id="PlanGift" name="PlanGift" value="0" />
    <input type="text" id="UnitOrAll" name="UnitOrAll" value="<?php echo $UnitOrAll; ?>" />
    <input type="text" id="stock" name="stock" value="<?php echo $stock; ?>" />
    <input type="text" id="MinSell" name="MinSell" value="<?php echo $MinSell; ?>" />
</div>

<div class="row box">
    <div class="col-md-5">
        <div class="fotorama" data-nav="thumbs" data-allowfullscreen="1" data-thumbheight="150" data-thumbwidth="150">
            <img src="<?php echo $ProductImage; ?>" alt="" title="" />
            <img src="<?php echo $Image2; ?>" alt="" title="" />
            <img src="<?php echo $Image3; ?>" alt="" title="" />
            <img src="<?php echo $Image4; ?>" alt="" title="" />
            <img src="<?php echo $Image5; ?>" alt="" title="" />
            <img src="<?php echo $Image6; ?>" alt="" title="" />
        </div>
    </div>
    <div class="col-md-7">
        <div class="product-info">
            <h3><?php echo $Title; ?></h3>
            <p class="product-info-price"><?php
                if ($Price !== 0) {
                    if ($Currency == 0) {
                        echo '$';
                    } else {
                        echo 'U$S';
                    } echo $Price;
                }
                ?>
            </p>
            <p class="text-smaller text-muted"><?php echo $ProductDescription; ?></p>
            <p class="text-smaller text-muted"><?php echo $ProductDescriptionHTML; ?></p>
        </div>
    </div>
</div>
<div class="gap-small"></div>
<h3 class="title-page">Seleccione el Plan para finalizar la publicación</h3>
<div class="gap-small"></div>
<div class="clear"></div>
<div class="row">
    <div class="col-md-9">
        <?php
        $User_plan = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\User_plan\_classes;
        $itemPlan = $User_plan->Dataset($User->id);
        $CurrentPlanCount = $itemPlan->Limit_Plan;
        if ($CurrentPlanCount >= 1) {
            ?>
            <div class="priceTable">
                <div class="pricetab <?php echo $itemPlan->Plan_Name; ?>" data-free="1" itemid="<?php echo $itemPlan->Plan_id; ?>" data-Priority="<?php echo $itemPlan->Plan_Priority . $itemPlan->Plan_Feature1 . $itemPlan->Plan_Feature2 . $itemPlan->Plan_Feature3; ?>">
                    <div class="col-md-2">
                        <img src="<?php echo SKTURL_TemplateSite; ?>assets/img/<?php echo $itemPlan->Plan_Name; ?>.png" alt="" class="planimg img-responsive"/>
                    </div>
                    <div class="col-md-3">
                        <div class="price">
                            <span style="position: absolute; width: 100%; display: block; left: 0px; top: 15px;">Restan <b><?php echo $CurrentPlanCount; ?></b> publicaciones</span>
                            <h2> GRATIS </h2>
                            <span style="position: absolute; width: 100%; display: block; left: 0px; bottom: -15px;">que vencen el <b><?php echo $itemPlan->Date_Finish; ?></b></span>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="infos">
                            <?php if ($itemPlan->Plan_Name === 'Platinum') { ?>
                                <h3><img src="<?php echo SKTURL_TemplateSite; ?>assets/img/1approved.png" alt=""/> Se envia por correo a los socios. </h3>
                            <?php } ?>
                            <h3><img src="<?php echo SKTURL_TemplateSite; ?>assets/img/<?php echo $itemPlan->Plan_Feature1; ?>approved.png" alt=""/> <?php echo $itemPlan->Plan_TFeature1; ?> </h3>
                            <h3><img src="<?php echo SKTURL_TemplateSite; ?>assets/img/<?php echo $itemPlan->Plan_Feature2; ?>approved.png" alt=""/> <?php echo $itemPlan->Plan_TFeature2; ?> </h3>
                            <h3><img src="<?php echo SKTURL_TemplateSite; ?>assets/img/<?php echo $itemPlan->Plan_Feature3; ?>approved.png" alt=""/> <?php echo $itemPlan->Plan_TFeature3; ?> </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="gap"></div>
            <h3 class="title-page">O puede aumentar la vizualización de este producto comprando un plan.</h3>
            <div class="gap-small"></div>
        <?php } ?>
        <div class="priceTable">
            <?php
            $QueryP = "SELECT * FROM plan WHERE Plan_TypePlan = " . \GetSQLValueString($ProductType, "int");
            $QueryPlan = $SKTDB->get_results($QueryP);
            foreach ($QueryPlan as $itemPlan) {
                ?>   
                <div class="pricetab <?php echo $itemPlan->Plan_Name; ?>" data-free="0" itemid="<?php echo $itemPlan->Plan_id; ?>" data-Priority="<?php echo $itemPlan->Plan_Priority . $itemPlan->Plan_Feature1 . $itemPlan->Plan_Feature2 . $itemPlan->Plan_Feature3; ?>">
                    <div class="col-md-2">
                        <img src="<?php echo SKTURL_TemplateSite; ?>assets/img/<?php echo $itemPlan->Plan_Name; ?>.png" alt="" class="planimg img-responsive"/>
                    </div>
                    <div class="col-md-3">
                        <div class="price"> 
                            <h2> $<?php echo $itemPlan->Plan_Price; ?> </h2> 
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="infos">
                            <?php if ($itemPlan->Plan_Name === 'Platinum') { ?>
                                <h3><img src="<?php echo SKTURL_TemplateSite; ?>assets/img/1approved.png" alt=""/> Se envia por correo a los socios. </h3>
                            <?php } ?>
                            <h3><img src="<?php echo SKTURL_TemplateSite; ?>assets/img/<?php echo $itemPlan->Plan_Feature1; ?>approved.png" alt=""/> <?php echo $itemPlan->Plan_TFeature1; ?> </h3>
                            <h3><img src="<?php echo SKTURL_TemplateSite; ?>assets/img/<?php echo $itemPlan->Plan_Feature2; ?>approved.png" alt=""/> <?php echo $itemPlan->Plan_TFeature2; ?> </h3>
                            <h3><img src="<?php echo SKTURL_TemplateSite; ?>assets/img/<?php echo $itemPlan->Plan_Feature3; ?>approved.png" alt=""/> <?php echo $itemPlan->Plan_TFeature3; ?> </h3>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>   
        </div>
    </div>
    <div class="col-md-3 PlanSelected">
        <h1 class="title_color text-center text-color">Su Plan:</h1>
        <img src="<?php echo SKTURL_TemplateSite; ?>assets/img/<?php echo $itemPlan->Plan_Name; ?>.png" alt="" class="img-responsive text-center"/>
        <h2 class="text-color">Valor $<?php echo $itemPlan->Plan_Price; ?> </h2> 
        <h1>
            <button id="FinishValidateProduct" type="button" class="btn btn-large btn-primary btn-mega btn-block"><i class="skt-icon-acept"></i> Publicar <?php echo $productDesc[$_GET['uValue']][1]; ?></button>
        </h1>
    </div>
</div>
<div class="clear"></div>
<div class="gap"></div>
<script>

    $('#SKTNewProduct').submit(function () {
        return false;
    });

    $('#FinishValidateProduct').click(function () {
        FinishValidateProduct();
    });
    $('.pricetab').click(function () {
        var id = $(this).attr('itemid');
        var Priority = $(this).attr('data-Priority');
        var PlanGift = $(this).attr('data-free');
        var src = $(this).find('.planimg').attr('src');
        var text = $(this).find('.price h2').text();
        //alert(id);
        $('input#Plan').attr('value', id);
        $('.pricetab').removeClass('pricetabmid');
        $(this).addClass('pricetabmid');
        $('.PlanSelected').addClass('selected');
        $('.PlanSelected img').attr('src', src);
        $('.PlanSelected h2').text(text);
        $('#Priority').val(Priority);
        $('#PlanGift').val(PlanGift);

        var dString = $('#Date').val();
        var dParts = dString.split('-');
        var in30Days = new Date(dParts[0] + '/' +
                dParts[1] + '/' +
                (+dParts[2] + 31)
                );
        var curr_date = ("0" + in30Days.getDate()).slice(-2);
        var curr_month = ("0" + (in30Days.getMonth() + 1)).slice(-2);
        var curr_year = in30Days.getFullYear();
        $('#expiredate').val(curr_year + '-' + curr_month + '-' + curr_date);
    });
    function FinishValidateProduct() {
        var UrlValidateProduct = '/SKTGoTo/' + admd2('CRUD/ViewEditElementsAsList/Lists/Products/_Create');
        jQuery.ajax({
            'type': 'POST',
            'url': UrlValidateProduct,
            'cache': false,
            'data': $('#SKTNewProductForm').serialize(),
            'success': function (data) {
                if ($.trim(data) == 'okay') {
                    document.location.href = '<?php echo \PublisherLink; ?>';
                } else {
                    alert('Ha ocurrido un error, intente nuevamente o contactese con nosotros.');
                }
            }
        });

    }



</script>