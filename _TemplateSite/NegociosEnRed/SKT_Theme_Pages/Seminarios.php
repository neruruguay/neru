<?php
$SKT_CC = new \CmsDev\CustomControl\LoadControl();
$SKT_CC->Render('Banner_Seminarios');
?>
<section id="services">
    <div class="gap"></div>
    <div class="container">
        <?php
        $SKT_CC->Render('Calendar_list');
        ?>  
    </div>
</section>
<div class="gap"></div>