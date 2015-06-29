<?php
$activecat = '';
if (isset($_GET['cat'])) {
    $allcat = '';
    $activecat = $_GET['cat'];
} else {
    $allcat = 'active';
    $activecat = '';
}
?>
<ul class="nav nav-tabs nav-stacked nav-coupon-category nav-coupon-category-left">
    <li class="<?php echo $allcat; ?>"><a href="<?php echo \SKT_URL_BASE; ?>lista-de-empresas"><i class="fa fa-ticket"></i> Todas</a></li>
    <?php
    $SKTDB = \CmsDev\Sql\db_Skt::connect();
    $categories = $SKTDB->get_results("SELECT * FROM " . \DB_PREFIX . "sections_category ORDER BY category ASC");
    if ($categories) {
        foreach ($categories as $category) {
            $catcss = '';
            if ($category->ID == $activecat) {
                $catcss = 'active';
            }
            ?>
            <li class="<?php echo $catcss; ?>"><a href="<?php echo \SKT_URL_BASE; ?>lista-de-empresas?cat=<?php echo $category->ID; ?>"><i class="fa fa-<?php echo $category->icon; ?>"></i><?php echo $category->category; ?></a></li>
                    <?php
                }
            }
            ?>
</ul>
