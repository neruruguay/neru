<aside class="sidebar-left hidden-phone row ">
    <div class="sidebar-box">
        <h4><i class="fa fa-tags"></i> Categorias</h4>
        <ul class="icon-list blog-category-list">
            <?php
            $ListCatNames = new CmsDev\Dataset\Categories();
            if ($ListCatNames->getName()[$CCParams['User']->category1]) {
                ?>
                <li><a><i class="fa fa-angle-right"></i><?php echo $ListCatNames->getName()[$CCParams['User']->category1]; ?></a>
                </li>
                <?php
            }
            if ($ListCatNames->getName()[$CCParams['User']->category2]) {
                ?>
                <li><a><i class="fa fa-angle-right"></i><?php echo $ListCatNames->getName()[$CCParams['User']->category2]; ?></a>
                </li>
                <?php
            }
            if ($ListCatNames->getName()[$CCParams['User']->category3]) {
                ?>
                <li><a><i class="fa fa-angle-right"></i><?php echo $ListCatNames->getName()[$CCParams['User']->category3]; ?></a>
                </li>
                <?php
            }
            if ($ListCatNames->getName()[$CCParams['User']->category4]) {
                ?>
                <li><a><i class="fa fa-angle-right"></i><?php echo $ListCatNames->getName()[$CCParams['User']->category4]; ?></a>
                </li>
                <?php
            }
            if ($ListCatNames->getName()[$CCParams['User']->category5]) {
                ?>
                <li><a><i class="fa fa-angle-right"></i><?php echo $ListCatNames->getName()[$CCParams['User']->category5]; ?></a>
                </li>
<?php } ?>
        </ul>
    </div>

    <div class="sidebar-box">
        <h4><i class="skt-icon-CmsDev"></i> Ventana de Negocios</h4>
        <?php 
        $SKT_CC = new \CmsDev\CustomControl\LoadControl();
        $CCParams_Calendar = array('Description' => false);
        $SKT_CC->Render('Calendar_list', $CCParams_Calendar);
        ?>
 <!--        
        <ul class="thumb-list thumb-list-right">
           <li>
                <div class="thumb-list-item-caption">
                    <h5 class="thumb-list-item-title"><a href="#">Keith Churchill</a></h5>
                    <p class="thumb-list-item-desciption">Praesent himenaeos litora arcu magna...</p>
                </div>
            </li>
            <li>
                <div class="thumb-list-item-caption">
                    <h5 class="thumb-list-item-title"><a href="#">Cheryl Gustin</a></h5>
                    <p class="thumb-list-item-desciption">Habitasse rutrum mi tortor...</p>
                </div>
            </li>
            <li>
                <div class="thumb-list-item-caption">
                    <h5 class="thumb-list-item-title"><a href="#">Richard Jones</a></h5>
                    <p class="thumb-list-item-desciption">Eget porta pharetra...</p>
                </div>
            </li>
        </ul>
 -->
    </div>

</aside>