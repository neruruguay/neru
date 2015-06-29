<?php
$User_plan = new \CmsDev\CRUD\ViewEditElementsAsList\Lists\User_plan\_classes;
$itemPlan = $User_plan->Dataset($User->id);
$CurrentPlanCount = $itemPlan->Limit_Plan;
if ($CurrentPlanCount >= 1) {
    ?>
    <div class="alert alert-block alert-default mt30 row">
        <div class="col-md-2">
            <img src="<?php echo SKTURL_TemplateSite; ?>assets/img/<?php echo $itemPlan->Plan_Name; ?>.png" alt="" class="planimg img-responsive"/>
        </div>
        <div class="col-md-10">
            <h3 class="mb20 text-color">Mi Plan actual es: <b>"<?php echo $itemPlan->Plan_Name; ?>"</b></h3>
            <h5>Restan <b><?php echo $CurrentPlanCount; ?></b> publicaciones <b>GRATIS</b> que vencen el <b>
                    <?php echo invertirFecha($itemPlan->Date_Finish); ?></b></h5>
        </div>
    </div>
<?php } ?>