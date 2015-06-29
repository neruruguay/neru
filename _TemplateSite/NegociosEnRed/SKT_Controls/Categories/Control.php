<aside class="sidebar-left">
    <?php
    $FilterCat = " category_id = '" . GetSQLValueString($CCParams['Cat1'], "int") . "' ORDER BY Title ASC ";
    switch ((int) $CCParams['Level']) {
        case 1:
            $allcat = 'active';
            $BaseURI = SKTURL_REQUEST_URI.'/';
            break;
        case 2:
            $allcat = '';
            $BaseURI = 'empresas/' . $CCParams['UrlSort'] . $CCParams['UrlOrder'] . $CCParams['Cat1'] . '/' . $CCParams['urlcat1'];
            break;
        case 3:
            $allcat = '';
            $BaseURI = 'empresas/' . $CCParams['UrlSort'] . $CCParams['UrlOrder'] . $CCParams['Cat1'] . '/' . $CCParams['urlcat1'] . '/' . $CCParams['Cat2'] . '/' . $CCParams['urlSubcat'];
            break;
        default:
            $allcat = 'active';
            $BaseURI = SKTURL_REQUEST_URI.'/';
            $FilterCat = " category_idx = 7 Order By category_position ASC ";
            break;
    }
    ?>
    <ul class="nav nav-tabs nav-stacked nav-coupon-category nav-coupon-category-left">
        <li class="<?php echo $allcat; ?>"><a href="<?php echo \SKT_URL_BASE . $BaseURI; ?>"><i class="fa skt-icon-CmsDev"></i> Todas</a></li>
        <?php
        $categories = $SKTDB->get_results("SELECT * FROM " . \DB_PREFIX . "categories WHERE". $FilterCat);
        if ($categories) {
            foreach ($categories as $category) {
                $catcss = '';
                if ($category->category_id == $CCParams['CatLevel']) {
                    $catcss = 'active';
                }
                ?>
                <li class="<?php echo $catcss; ?>"><a href="<?php echo \SKT_URL_BASE . $BaseURI . $category->category_idx . '/' . $category->category_url; ?>/"><i class="fa <?php echo $category->category_icon; ?>"></i><?php echo $category->category_name; ?></a></li>
                <?php
            }
        }
        ?>
    </ul>
</aside>
<pre style="position: fixed; top: 50px; left: 0; z-index: 99999999; display: none;">
    <?php
    /*foreach ($CCParams as $variable => $value) {
        echo $variable . '=' . $value . '<br>';
    };*/
    ?>
</pre>
